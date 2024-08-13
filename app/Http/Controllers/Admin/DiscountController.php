<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\CmsProduct;
use App\Models\User;
use App\Models\Discount;
use App\Models\CmsTaxonomy;
use App\Models\CmsRelationship;
use App\Models\Widget;
use App\Models\WidgetConfig;
use App\Models\Brand;
use App\Models\Parameter;
use App\Consts;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->is_type  = 'product';
        $this->routeDefault  = 'discounts';
        $this->viewPart = 'admin.pages.discounts';
        $this->responseData['module_name'] = __('Discount Management');
    }
    public function index(Request $request)
    {
        $params = $request->all();
        $this->responseData['postStatus'] = Consts::STATUS;
        $this->responseData['rows'] = Discount::getsqlDiscount($params)->paginate(Consts::DEFAULT_PAGINATE_LIMIT);
        return $this->responseView($this->viewPart . '.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
        $this->responseData['status'] = Consts::STATUS;

        //list product
        $params['is_type'] = 'product';
        $params['status'] =Consts::STATUS['active'];
        $this->responseData['product'] = CmsProduct::getsqlCmsProduct($params)->get();

        //list cate
        $paramcate['taxonomy'] = 'product';
        $paramcate['status'] =Consts::STATUS['active'];
        $this->responseData['category'] = CmsTaxonomy::getSqlTaxonomy($paramcate)->get();

        //list customer
        $this->responseData['user_list'] = User::where('status',Consts::STATUS['active'])->get();

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
            'name' => 'required|max:255',
            'coupon_code' => 'required|max:255|unique:tb_discounts,coupon_code',
        ]);
        $params = $request->all();

        if($request->specific_product!=null) $params['specific_product']=implode(',', $request->specific_product);
        if($request->category_product!=null) $params['category_product']=implode(',', $request->category_product);
        if($request->customer!=null) $params['customer']=implode(',', $request->customer);

        $discount = Discount::create($params);
        return redirect()->route($this->routeDefault . '.index')->with('successMessage', __('Add new successfully!'));
    }
    public function statusCoupon(Request $request,Discount $discount){
        $id=$request->id;
        $discount = Discount::find($id);
        if($request->tt==1) $discount->status = Consts::STATUS['active'];
        if($request->tt==2) $discount->status = Consts::STATUS['deactive'];
        $discount->save();
        return response()->json(['error' => 0, 'msg' => 'Updated successfully']);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function show(Discount $discount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function edit(Discount $discount)
    {
        $this->responseData['status'] = Consts::STATUS;

        //list product
        $params['is_type'] = 'product';
        $params['status'] =Consts::STATUS['active'];
        $this->responseData['product'] = CmsProduct::getsqlCmsProduct($params)->get();

        //list cate
        $paramcate['taxonomy'] = 'product';
        $paramcate['status'] =Consts::STATUS['active'];
        $this->responseData['category'] = CmsTaxonomy::getSqlTaxonomy($paramcate)->get();

        //list customer
        $this->responseData['user_list'] = User::where('status',Consts::STATUS['active'])->get();
        $this->responseData['detail'] = $discount;
        return $this->responseView($this->viewPart . '.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Discount $discount)
    {
        $request->validate([
            'name' => 'required|max:255',
            'coupon_code' => 'required|max:255',
        ]);
        $params = $request->all();
        
        if($request->specific_product!=null) $params['specific_product']=implode(',', $request->specific_product);
        if($request->category_product!=null) $params['category_product']=implode(',', $request->category_product);
        if($request->customer!=null) $params['customer']=implode(',', $request->customer);

        $discount->fill($params);
        $discount->save();
        return redirect()->back()->with('successMessage', __('Successfully updated!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function destroy(Discount $discount)
    {
        $discount->delete();

        return redirect()->route($this->routeDefault . '.index')->with('successMessage',  __('Delete record successfully!'));
    }
}
