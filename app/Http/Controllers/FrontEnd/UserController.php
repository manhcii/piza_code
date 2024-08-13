<?php

namespace App\Http\Controllers\FrontEnd;

use App\Consts;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use App\Models\Order;
use App\Models\CountryModel;
use App\Models\City;
use App\Models\OrderDetail;
use App\Models\Wishlist;
use Exception;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Mail\UserRegisterConfirmation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use SebastianBergmann\CodeUnitReverseLookup\Wizard;

class UserController extends Controller
{

    public function index()
    {
        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web');

            $page = new PageController;
            $this->responseData = $page->buildWidgetDefault2();
            $this->responseData['detail'] = $user;
            $this->responseData['list_order'] = Order::where("customer_id", $user->user()->id)->where('is_type', 'product')->get();

            //detail address
            $this->responseData['user_contry'] = CountryModel::select('name')->where("id", $user->user()->country_id)->first();
            $this->responseData['user_city'] = City::select('name')->where("id", $user->user()->city_id)->first();
            return $this->responseView('frontend.pages.user.account');
        }

        return redirect()->back()->with('warningMessage', __('You are not login!'));
    }

    public function view_details_order(Request $request)
    {
        $id = $request->id;
        $ret = OrderDetail::select('tb_order_details.*')
            ->selectRaw('tb_cms_posts.name AS product_name, tb_cms_posts.image, tb_cms_posts.image_thumb')
            ->join('tb_cms_posts', 'tb_cms_posts.id', '=', 'tb_order_details.item_id')
            ->where('order_id', $id)->get();
        return $this->sendResponse($ret, 'success');
    }


    public function login(LoginRequest $request)
    {

        $current = $request->input('current') ?? route('home.default');
        $referer = $request->input('referer') ?? '';
        $url = $current == route('home.default') ? $referer : $current;
        if (Auth::guard('web')->check()) {
            return $this->sendResponse('', 'success');
        }
        try {
            $email = $request->email;
            $password = $request->password;
            $attempt = Auth::guard('web')->attempt([
                'email' => $email,
                'password' => $password,
                'status' => Consts::USER_STATUS['active']
            ]);

            if (!$attempt) {
                abort(401, __('Login failed!'));
            }

            session()->flash('successMessage', 'Login successfully!');
            return $this->sendResponse(['url' => $url], 'success');
        } catch (Exception $ex) {
            abort(422, __($ex->getMessage()));
        }
    }

    public function logout()
    {
        Auth::guard('web')->logout();

        return redirect()->route('home.default')->with('successMessage', __('Logout successfully!'));
    }


    // Signup new account
    public function signup(UserRegisterRequest $request)
    {
        DB::beginTransaction();
        try {
            $params = $request->all();

            $user = User::create($params);
            $confirmationCode = Str::random(32);
            $user->email_verification_code = $confirmationCode;
            $user->save();

            Mail::to($user->email)->send(new UserRegisterConfirmation($user->email, $confirmationCode));
            DB::commit();
            session()->flash('successMessage', 'Register successfully.Please active in your email');
            return $this->sendResponse($user, __('Signup successed!'));
        } catch (Exception $ex) {
            DB::rollBack();
            // throw $ex;
            abort(422, __($ex->getMessage()));
        }
    }

    // Verify new account from email
    public function verifyAccount(Request $request)
    {
        try {
            $user = User::where('email_verification_code', $request->code)->first();

            if (empty($user)) {
                throw new Exception(__('Account verification failed'));
            }

            $user->email_verified_at = now();
            $user->email_verification_code = null;
            $user->email_verified = true;
            $user->status = Consts::STATUS['active'];
            $user->save();

            Auth::login($user, true);
            return redirect()->route('home.default')->with('successMessage', __('Active account successfully!'));
        } catch (Exception $ex) {
            return $this->sendResponse('error', $ex->getMessage());
        }
    }

    public function forgotPasswordForm(Request $request)
    {
        $page = new PageController;
        $this->responseData = $page->buildWidgetDefault2();
        return $this->responseView('frontend.pages.user.forgot_password');

    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);
        try {

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

            return redirect()->route('home.default')->with('successMessage', __('We have e-mailed your password reset link!'));
            // return $this->sendResponse('success', __('We have e-mailed your password reset link!'));

        } catch (Exception $ex) {
            // throw $ex;
            abort(422, __($ex->getMessage()));
        }
    }

    public function resetPasswordForm($token)
    {
        $page = new PageController;
        $this->responseData = $page->buildWidgetDefault2();
        $this->responseData['token'] = $token;
        return $this->responseView('frontend.pages.forgot');
        // return $this->responseView('pages.user.reset_password');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);
        DB::beginTransaction();
        try {
            $updatePassword = DB::table('password_resets')
                ->where([
                    'email' => $request->email,
                    'token' => $request->token
                ])
                ->first();

            if (!$updatePassword) {
                return back()->with('errorMessage', __('Invalid token!'));
            }

            $user = User::where('email', $request->email)
                ->update(['password' => bcrypt($request->password)]);

            DB::table('password_resets')->where(['email' => $request->email])->delete();
            DB::commit();

            return redirect()->route('home.default')->with('successMessage', __('Your password has been changed!'));
        } catch (Exception $ex) {
            DB::rollBack();
            // throw $ex;
            abort(422, __($ex->getMessage()));
        }
    }

    public function changeAccountForm()
    {
        return $this->responseView('pages.user.change_account');
    }

    public function changeAccount(Request $request)
    {
        $id = Auth::user()->id;
        $request->validate([
            'email' => "required|email|max:255|unique:users,email," . $id,
            'name' => 'required',
            'password_old' => 'required',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);
        // Check user_auth
        if (!Auth::check()) {
            // throw new Exception(__('User is not found'));
            abort(401, __('User is not found'));
        }

        $password = Auth::user()->password;
        DB::beginTransaction();
        try {

            if (!Hash::check($request->password_old, $password)) {
                return back()->withInput()->with('errorMessage', __('Old password is invalid!'));
            }

            $user = User::where('id', $id)
                ->update([
                    'email' => $request->email,
                    'name' => $request->name,
                    'password' => bcrypt($request->password)
                ]);

            DB::commit();

            Auth::logout();
            return redirect()->route('home.default')->with('successMessage', __('Successfully updated. Please login again for security!'));
        } catch (Exception $ex) {
            DB::rollBack();
            // throw $ex;
            abort(422, __($ex->getMessage()));
        }
    }

    // check and show wishlist
    public function wishlist()
    {
        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web');
            $page = new PageController;
            $this->responseData = $page->buildWidgetDefault2();

            //list wishlist
            $params['status'] = Consts::STATUS['active'];
            $params['is_type'] = Consts::TAXONOMY['product'];
            $params['user_id'] = $user->user()->id ?? "";
            $rows = Wishlist::getsqlWhishlist($params)->get();
            $this->responseData['rows'] = $rows;
            return $this->responseView('frontend.pages.user.wishlist');
        }

        return redirect()->back()->with('warningMessage', __('You are not login!'));
    }
    public function checkWishlist(Request $request)
    {
        if (Auth::guard('web')->check()) {
            $lang = $request['lang'];
            $id = $request['id'];
            $user = Auth::guard('web');
            if (!empty($id)) {
                $check_wishlist = Wishlist::where('user_id', $user->user()->id)->where('object_id', $id)->count();
                if ($check_wishlist == 0) {
                    $data_wishlist['user_id'] = $user->user()->id;
                    $data_wishlist['object_id'] = $id;
                    $add_wishlist = Wishlist::create($data_wishlist);
                }
            }

            //list wishlist product
            $params['status'] = Consts::STATUS['active'];
            $params['is_type'] = Consts::TAXONOMY['product'];
            $params['user_id'] = $user->user()->id ?? "";
            $rows = Wishlist::getsqlWhishlist($params)->get();

            $arr_product = [];
            $i = 0;
            foreach ($rows as $val) {
                $arr_product[$i]['id'] = $val->id;
                $arr_product[$i]['id_wishlist'] = $val->id_wishlist;
                $arr_product[$i]['name'] = $val->json_params->name->{$lang} ?? $val->name;
                $arr_product[$i]['image'] = $val->image ?? $val->image_thumb ?? url('data/images/no_image.jpg');
                $arr_product[$i]['price'] = $val->price ?? '';
                $arr_product[$i]['time'] = date('M d,Y', strtotime($val->created_at));
                $arr_product[$i]['link'] = route('frontend.page', ['taxonomy' => $val->alias ?? '']);
                $i++;
            }

            $messageResult = __('successfull!');
            return $this->sendResponse($arr_product, $messageResult);
        }
        return $this->sendResponse('error', __('You are not login!'));
    }
    public function deleteWishlist(Request $request)
    {
        $id = $request['id'];
        $user = Auth::guard('web');
        $res = Wishlist::where('user_id', $user->user()->id)->where('object_id', $id)->delete();;
        $messageResult = __('successfull!');
        return $this->sendResponse($id, $messageResult);
    }
}
