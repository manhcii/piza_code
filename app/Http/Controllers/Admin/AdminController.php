<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Services\AdminService;
use App\Models\Role;
use App\Consts;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    private $admin;
    private $adminService;

    public function __construct()
    {
        $this->admin = new Admin();
        $this->adminService = new AdminService();
        $this->routeDefault  = 'admins';
        $this->viewPart = 'admin.pages.admins';
        $this->responseData['module_name'] = __('Admin user management');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = trim($request->input('keyword'));

        $admins = $this->adminService->getAdmins($request->all(), true);

        $this->responseData['admins'] = $admins;
        $this->responseData['keyword'] = $keyword;

        return $this->responseView($this->viewPart . '.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::where('status', '=', Consts::USER_STATUS['active'])->orderByRaw('status ASC, iorder ASC, id DESC')->get();
        $this->responseData['roles'] = $roles;

        return $this->responseView($this->viewPart . '.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'email' => "required|email|max:255|unique:admins",
            'password' => "required|min:8|max:255",
        ]);

        $params = $request->only([
            'email',
            'name',
            'role',
            'status',
            'password',
        ]);
        $params['admin_created_id'] = Auth::guard('admin')->user()->id;
        $params['admin_updated_id'] = Auth::guard('admin')->user()->id;

        Admin::create($params);

        return redirect()->route($this->routeDefault . '.index')->with('successMessage', __('Add new successfully!'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        // Do not use this function
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $admin = Admin::find($id);

        if (!$admin) {
            return redirect()->route($this->routeDefault . '.index')->with('errorMessage', __('Record not found!'));
        }

        $roles = Role::where('status', '=', Consts::USER_STATUS['active'])->orderByRaw('status ASC, iorder ASC, id DESC')->get();

        $this->responseData['roles'] = $roles;
        $this->responseData['admin'] = $admin;

        return $this->responseView($this->viewPart . '.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        $request->validate([
            'name' => 'required',
            'email' => "required|email|max:255|unique:admins,email," . $admin->id,
        ]);

        $params = $request->only([
            'email',
            'name',
            'role',
            'status',
        ]);
        $password_new = $request->input('password_new');
        if ($password_new != '') {
            if (strlen($password_new) < 8) {
                return redirect()->back()->with('errorMessage', __('Password is very short!'));
            }
            $params['password'] = $password_new;
        }
        $params['admin_updated_id'] = Auth::guard('admin')->user()->id;

        $admin->fill($params);
        $admin->save();

        return redirect()->back()->with('successMessage', __('Successfully updated!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        $admin->delete();

        return redirect()->route($this->routeDefault . '.index')->with('successMessage',  __('Delete record successfully!'));
    }

    public function changeAccountForm()
    {
        $roles = Role::where('status', '=', Consts::USER_STATUS['active'])->orderByRaw('status ASC, iorder ASC, id DESC')->get();

        $this->responseData['roles'] = $roles;

        return $this->responseView($this->viewPart . '.account');
    }

    public function changeAccount(Request $request)
    {
        // Check user_auth
        if (!Auth::guard('admin')->check()) {
            return back()->withInput()->with('errorMessage', __('User is not found'));
        }
        $id = Auth::guard('admin')->user()->id;
        $password = Auth::guard('admin')->user()->password;

        $request->validate([
            'email' => "required|email|max:255|unique:admins,email," . $id,
            'name' => 'required|string',
            'password_old' => 'required',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        if (!Hash::check($request->password_old, $password)) {
            return back()->withInput()->with('errorMessage', __('Old password is invalid!'));
        }

        $user = Admin::where('id', $id)
            ->update([
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);

        Auth::guard('admin')->logout();
        return redirect()->route('admin.login')->with('successMessage', __('Successfully updated. Please login again for security!'));
    }

    public function forgotPasswordForm(Request $request)
    {
        return redirect()->back()->with('warningMessage', __('This function is under development!'));
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        Mail::send('emails.forget_password', ['token' => $token], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject(__('Reset Password'));
        });

        return redirect()->back()->with('successMessage', __('We have e-mailed your password reset link!'));
    }

    public function resetPasswordForm($token)
    {
        $this->responseData['token'] = $token;
        return $this->responseView($this->viewPart . '.reset_password');
    }

    public function resetPassword(Request $request)
    {

        $request->validate([
            'email' => 'required|email|exists:admins',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        $updatePassword = DB::table('password_resets')
            ->where([
                'email' => $request->email,
                'token' => $request->token
            ])
            ->first();

        if (!$updatePassword) {
            return back()->withInput()->with('errorMessage', __('Invalid token!'));
        }

        $user = Admin::where('email', $request->email)
            ->update(['password' => bcrypt($request->password)]);

        DB::table('password_resets')->where(['email' => $request->email])->delete();


        return redirect()->route('admin.home')->with('successMessage', __('Your password has been changed!'));
    }
    public function loadStatus($id)
    {
        // dd($this->adminService);
        $admin   =  $this->admin->find($id);
        $status = $admin->status;
        if ($status=="active") {
            $statusUpdate = 'deactive';
        } else {
            $statusUpdate = 'active';
        }
        $updateResult =  $admin->update([
            'status' => $statusUpdate,
        ]);
        // dd($updateResult);
        $admin   =  $this->admin->find($id);
        if ($updateResult) {
            return response()->json([
                "code" => 200,
                "html" => view('admin.components.load-change-status', ['data' => $admin, 'type' => 'bản ghi'])->render(),
                "message" => "success"
            ], 200);
        } else {
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }
    }
}
