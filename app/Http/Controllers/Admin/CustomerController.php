<?php

namespace App\Http\Controllers\Admin;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\CmsProduct;
use App\Models\CountryModel;
use App\Models\CmsRelationship;
use App\Consts;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class CustomerController extends Controller
{
    protected $is_type;
    public function __construct()
    {
        $this->routeDefault  = 'customer';
        $this->viewPart = 'admin.pages.customer';
        $this->responseData['module_name'] = __('Customer Management');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       $params = $request->all();
        // Get list post with filter params
        $rows = Customer::getsqlUser($params)->paginate(Consts::DEFAULT_PAGINATE_LIMIT);
        $this->responseData['params'] = $params;
        $this->responseData['rows'] =  $rows;
        return $this->responseView($this->viewPart . '.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Customer  $customer)
    {
        $country = CountryModel::all();
        $this->responseData['country'] = $country;
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
            'password' => "required|min:6|max:255",
        ]);

        
        $params=$request->all();

        Customer::create($params);

        return redirect()->route($this->routeDefault . '.index')->with('successMessage', __('Add new successfully!'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer  $customer)
    {
        $country = CountryModel::all();
        $this->responseData['country'] = $country;
        $this->responseData['detail'] = $customer;
        return $this->responseView($this->viewPart . '.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer  $customer)
    {
        $id=$customer->id;
        $request->validate([
            'name' => 'required|max:255',
            'email' => "required|email|max:255|unique:users,email," . $id,
        ]);
        $params = $request->only([
            'email',
            'name',
            'phone',
            'country_id',
            'city_id',
            'street_address',
            'status',
            'avatar',
        ]);
        $password_new = $request->input('password_new');
        if ($password_new != '') {
            if (strlen($password_new) < 6) {
                return redirect()->back()->with('errorMessage', __('Password is very short!'));
            }
            $params['password'] = $password_new;
        }
        $customer->fill($params);
        $customer->save();
        return redirect()->back()->with('successMessage', __('Successfully updated!'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $customer->status = Consts::STATUS_DELETE;
        $customer->save();

        return redirect()->route($this->routeDefault . '.index')->with('successMessage', __('Delete record successfully!'));
    }
   
}
