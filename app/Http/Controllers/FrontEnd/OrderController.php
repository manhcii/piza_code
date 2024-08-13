<?php

namespace App\Http\Controllers\FrontEnd;

use App\Consts;
use App\Models\CmsProduct;
use App\Models\CmsService;
use App\Models\Order;
use App\Models\CountryModel;
use App\Models\City;
use App\Models\Discount;
use App\Models\Ship;
use App\Models\OrderDetail;
use App\Models\Parameter;
use Illuminate\Support\Facades\App;
use App\Models\User;
use Exception;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeOrderService(Request $request)
    {
        // Change to used for template website order
        // 2022-10-31
        DB::beginTransaction();
        try {
            $request->validate([
                'name' => 'required',
                'phone' => 'required',
                'item_id' => "required|integer|min:0",
            ]);
            // Check and store order
            $order_params = $request->only([
                'name', 'email', 'phone', 'address', 'customer_note'
            ]);
            $order_params['is_type'] = Consts::TAXONOMY['product'];

            $order = Order::create($order_params);

            // Check and store order_detail
            $order_detail_params = $request->only([
                'item_id', 'quantity', 'price', 'discount'
            ]);
            // Check service detail is existed
            $service_detail = CmsProduct::find($order_detail_params['item_id']);
            if ($service_detail) {
                $order_detail_params['price'] = $service_detail->json_params->price ?? null;
            } else {
                abort(422, __('Services is not exist!'));
            }

            $order_detail_params['quantity'] = $request->get('quantity') > 0 ? $request->get('quantity') : 1;
            $order_detail_params['order_id'] = $order->id;
            $order_detail_params['json_params']['post_type'] = Consts::TAXONOMY['product'];
            $order_detail_params['json_params']['post_link'] = $request->headers->get('referer');

            $order_detail = OrderDetail::create($order_detail_params);

            $messageResult = __('Booking successfull!');

            // if (isset($this->web_information->information->email)) {
            //     $email = $this->web_information->information->email;
            //     Mail::send(
            //         'frontend.emails.booking',
            //         [
            //             'order' => $order,
            //             'order_detail' => $order_detail
            //         ],
            //         function ($message) use ($email) {
            //             $message->to($email);
            //             $message->subject(__('You received a new booking service from the system'));
            //         }
            //     );
            // }
            DB::commit();
            return $this->sendResponse($order, $messageResult);
        } catch (Exception $ex) {
            DB::rollBack();
            // throw $ex;
            abort(422, __($ex->getMessage()));
        }
    }

    // Cart
    public function cart()
    {
        $page = new PageController;
        $this->responseData = $page->buildWidgetDefault2();
        return $this->responseView('frontend.pages.cart.default');

    }
    public function orderReceived($id,Request $request)
    {
        $page = new PageController;
        $this->responseData = $page->buildWidgetDefault2();
        $rows = Order::where('id', $id)->where('token', $request->key)->first();
        $this->responseData['rows'] =  $rows;
        $this->responseData['order_id'] =  $id;
        return $this->responseView('frontend.pages.cart.received');
    }

    public function getCity(Request $request)
    {
        $id = $request->get('id')  ?? null;
        $city = City::where('country_id', $id)->get();
        return $this->sendResponse($city, 'Thành công');
    }
    public function getShip(Request $request)
    {
        $id = $request->get('id')  ?? null;

        $list = Ship::select('tb_cms_ships.*')->selectRaw('countries.name AS country_name')
            ->leftJoin('countries', 'tb_cms_ships.country_id', '=', 'countries.id')->groupBy('country_id')->get();

        $list_country_ext = [];
        foreach ($list as $key => $value) {
            array_push($list_country_ext, $value->country_id);
        }
        if (in_array($id, $list_country_ext)) {
            $rule_childs = Ship::where('country_id', $id)->get();
        } else $rule_childs = "";
        //Country exist
        return $this->sendResponse($rule_childs, 'Thành công');
    }

    public function addToCart(Request $request)
    {

        $id = $request->get('id')  ?? null;
        $quantity = $request->get('quantity')  ?? 1;
        $size = $request->get('size')  ?? null;
        $color = $request->get('color')  ?? null;
        $size_name =  $color_name = '';
        $product = CmsProduct::findOrFail($id);

        if(isset($product->json_params->paramater)){
            foreach($product->json_params->paramater as $key => $val){
                if (in_array($val->name, ['size', 'color'])){

                    if($val->name=='size'){
                        $size = $request->get('size')  ?? $val->childs[0];
                        $paramare_default = Parameter::where('id', $size)->where('status', Consts::STATUS['active'])->first();
                        $size_name = $paramare_default->json_params->name->{App::getLocale()} ?? $paramare_default->name;
                    }
                    else{
                        $color = $request->get('color')  ?? $val->childs[0];
                        $paramare_default = Parameter::where('id', $color)->where('status', Consts::STATUS['active'])->first();
                        $color_name = $paramare_default->propety_value;
                    }
                }
            }
        }
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $check=0;
            // nếu đã có
            foreach($cart[$id] as $key => $val){
                if($cart[$id][$key]['size'] == $size_name && $cart[$id][$key]['color'] == $color_name){
                    $cart[$id][$key]['quantity'] =$cart[$id][$key]['quantity'] + $quantity;
                    $check++;
                    break;

                }
            }
            // nếu chưa có
            if($check==0){
                $cart[$id][(count($cart[$id]))] = [
                    "id" => $product->id,
                    "title" => $product->name,
                    "alias" => $product->alias,
                    "quantity" => $quantity,
                    "price" => $product->price ?? null,
                    "image" => $product->image,
                    "image_thumb" => $product->image_thumb,
                    "size" => $size_name??"",
                    "color" => $color_name??""
                ];
            }

        } else {

            $cart[$id][0] = [
                "id" => $product->id,
                "title" => $product->name,
                "alias" => $product->alias,
                "quantity" => $quantity,
                "price" => $product->price ?? null,
                "image" => $product->image,
                "image_thumb" => $product->image_thumb,
                "size" => $size_name??"",
                "color" => $color_name??""
            ];
        }

        session()->put('cart', $cart);

        // session()->flash('successMessageCart', __('Product was added to cart successfully!'));
        session()->flash('successMessage', __('Product was added to cart successfully!'));
    }

    public function updateCart(Request $request)
    {
        // echo $request->quantity;
        if ($request->id && $request->quantity) {
            $cart = session()->get('cart');
            $cart[$request->id][$request->key]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            session()->flash('successMessage', __('Cart updated successfully!'));
        }
    }

    public function removeCart(Request $request)
    {
        if ($request->id && $request->key) {
            $cart = session()->get('cart');
            if (isset($cart[$request->id][$request->key])) {
                unset($cart[$request->id][$request->key]);
                // lặp lại mảng cart để lấy key theo thứ tự
                $arr = [];
                foreach($cart[$request->id] as $val){
                    $arr[] = $val;
                }
                $cart[$request->id] = $arr;
                session()->put('cart', $cart);
            }
            session()->flash('successMessage', __('Product removed successfully!'));
        }
    }
    public function checkout()
    {

        $page = new PageController;
        $this->responseData = $page->buildWidgetDefault2();

        $country = CountryModel::all();
        $this->responseData['country'] = $country;
        return $this->responseView('frontend.pages.cart.checkout');
    }

    // public function storeOrderProduct(Request $request )
    // {
    //     $request->validate([
    //         'name' => 'required',
    //         'email' => 'required',
    //         'phone' => 'required'
    //     ]);

    //     $createaccount=$request->createaccount;
    //     if ($createaccount==1) {
    //         $request->validate([
    //             'account_password' => 'required',
    //             'email' => "required|string|max:255|unique:users,email",
    //         ]);

    //     }
    //     DB::beginTransaction();
    //     try {
    //         $cart = session()->get('cart', []);
    //         if (empty($cart)) {
    //             return redirect()->back()->with('errorMessage', __('Cart is empty!'));
    //         }
    //         // Check and store order
    //         $order_params = $request->only([
    //             'name',
    //             'json_params',
    //             'phone',
    //             'email',
    //             'transaction_code',
    //         ]);
    //         $order_params['is_type'] = Consts::TAXONOMY['product'];

    //         // Check and add user_id login or affiliate_code
    //         if (Auth::guard('web')->check()) {
    //             $order_params['customer_id'] = Auth::guard('web')->id();
    //         } else if ($request->get('affiliate_code') != '') {
    //             $affiliate = User::where('affiliate_code', $request->get('affiliate_code'))->first();
    //             if ($affiliate) {
    //                 $order_params['customer_id'] = $affiliate->id;
    //             } else {
    //                 return redirect()->back()->with('errorMessage', __('Affiliate code is not existed!'));
    //             }
    //         }
    //         $order = Order::create($order_params);

    //         $data = [];
    //         foreach ($cart as $id => $details) {
    //             // Check and store order_detail
    //             $order_detail_params['name'] = $request->name;
    //             $order_detail_params['order_id'] = $order->id;
    //             $order_detail_params['item_id'] = $id;
    //             $order_detail_params['quantity'] = $details['quantity'] ?? 1;
    //             $order_detail_params['price'] = $details['price'] ?? null;
    //             array_push($data, $order_detail_params);
    //         }
    //         OrderDetail::insert($data);

    //         $messageResult = $this->web_information->information->notice_order_cart ?? __('Submit order successfull!');

    //         if (isset($this->web_information->information->email)) {
    //             $email = $this->web_information->information->email;
    //             Mail::send(
    //                 'frontend.emails.order',
    //                 [
    //                     'order' => $order
    //                 ],
    //                 function ($message) use ($email) {
    //                     $message->to($email);
    //                     $message->subject(__('You received a new order from the system'));
    //                 }
    //             );
    //         }
    //         if ($createaccount==1) {
    //             $request->validate([
    //                 'account_password' => 'required',
    //                 'email' => "required|string|max:255|unique:users,email",
    //             ]);
    //             $params_sigup['name'] = $request->name;
    //             $params_sigup['email'] = $request->email;
    //             $params_sigup['password'] = $request->account_password;
    //             $params_sigup['phone'] = $request->phone;
    //             $params_sigup['country_id'] = $request->json_params['country']??'0';
    //             $params_sigup['city_id'] = $request->json_params['city']??"0";
    //             $params_sigup['status'] = Consts::STATUS['active'];
    //             // dd($params_sigup);
    //             $user = User::create($params_sigup);
    //         }

    //         DB::commit();
    //         session()->forget('cart');
    //         return redirect()->back()->with('successMessage', $messageResult);
    //     } catch (Exception $ex) {
    //         DB::rollBack();
    //         // throw $ex;
    //         abort(422, __($ex->getMessage()));
    //     }
    // }
    // public function storeReviewProduct(Request $request)
    // {
    //     $id_product=$request->id_product_review;
    //     $email=$request->template_reviewform_email;
    //     $name=$request->template_reviewform_name;
    //     $rating=$request->template_reviewform_rating;
    //     $comment=$request->template_reviewform_comment;

    //     $request->validate([
    //         'template_reviewform_name' => 'required',
    //         'template_reviewform_email' => 'required',
    //         'template_reviewform_comment' => 'required'
    //     ],[
    //         "template_reviewform_name.required"=>"Tên bắt buộc phải nhập",
    //         "template_reviewform_email.required"=>"Email bắt buộc phải nhập",
    //         "template_reviewform_comment.required"=>"Nội dung bắt buộc phải nhập"
    //     ]);

    //     $data = [
    //         'id_product' => $id_product,
    //         'email' => $email,
    //         'name' => $name,
    //         'rating' => $rating,
    //         'comment' => $comment
    //     ];
    //     $insert=Review::insert($data);
    //     if ($insert) return redirect()->back()->with('successMessage', 'Gửi thành công');


    // }
    //COUPON
    public function addToCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required',
        ]);
        $name = $request->get('coupon_code')  ?? null;
        $amount_sub = $request->amount_sub;

        $coupon = Discount::where('coupon_code', $name)->where('status', 'active')->first();
        if ($coupon) {
            $time_end = strtotime($coupon->time_end);
            $list_customer_accept = explode(',', $coupon->customer);

            if ($coupon->is_unlimited == '' && $coupon->coupon_quantity <= 0) return redirect()->back()->with('errorMessage', 'This coupon quantity is not enought!');
            if ($coupon->never_expired == '' && $time_end < time()) return redirect()->back()->with('errorMessage', 'This coupon is expired!');
            if ($coupon->apply_for == 'amount-minimum-order' && $coupon->amount_minimum_order > $amount_sub) return redirect()->back()->with('errorMessage', 'Amount subtotal order is not valid!');

            if ($coupon->apply_for == 'customer') {
                if (Auth::guard('web')->check()) {
                    $user = Auth::guard('web');
                    $id_user = $user->user()->id;
                    if (!in_array($id_user, $list_customer_accept)) return redirect()->back()->with('errorMessage', "You are not in customer'discount !");
                } else return redirect()->back()->with('errorMessage', 'You are not login!');
            }

            $cou = array(
                'id' => $coupon->id,
                'name' => $coupon->name,
                'coupon_code' => $coupon->coupon_code,
                'coupon_type' => $coupon->coupon_type,
                'discount' => $coupon->discount,
            );
            session()->put('coupon', $cou);
            return redirect()->back()->with('successMessage', 'Add coupon successfully!!!');
        } else {
            return redirect()->back()->with('errorMessage', 'This coupon is invalid or expired!');
        }
    }
    public function unset_coupon()
    {
        // $coupon = Session::get('coupon');
        $coupon = session()->get('coupon');
        if ($coupon == true) {
            // Session::forget('coupon');
            session()->forget('coupon');
            return redirect()->back()->with('successMessage', 'Xóa mã khuyến mãi thành công!!!');
        }
    }
}
