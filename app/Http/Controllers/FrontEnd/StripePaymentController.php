<?php
   
namespace App\Http\Controllers\FrontEnd;

use App\Consts;
use Illuminate\Http\Request;
use Stripe;
use App\Models\CountryModel;
use App\Models\Order;
use App\Models\OrderDetail;

class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {
        $page = new PageController;
        $this->responseData = $page->buildWidgetDefault2();
        $country = CountryModel::all();
        $this->responseData['country'] = $country;
        return $this->responseView('frontend.pages.cart.checkout_stripe');
    }
  
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPayment(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'ship_fee' => 'required',
            'json_params.country' => 'required',
            'json_params.city' => 'required',
            'json_params.address' => 'required',
            'phone' => 'required'
        ]);
        $data = $request->all();
        return view('frontend.pages.shop.checkout', compact('data'));
    }

    public function stripePost(Request $request)
    {
        $price = $request->price ?? '';
        $name = $request->name ?? '';
        $phone = $request->phone ?? '';
        $email = $request->email ?? '';
        $country = $request->country ?? '';
        $city = $request->city ?? '';
        $address = $request->address ?? '';
        $note = $request->note ?? '';

        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create ([
                "amount" => $price * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Stripe Payment"
        ]);
        
        $order_params['is_type'] = Consts::TAXONOMY['product'];
        $order_params['name'] = $name;
        $order_params['phone'] = $phone;
        $order_params['email'] = $email;
        $order_params['total'] = $price;

        $order = Order::create($order_params);

        $data = [];
        $cart = session()->get('cart', []);

        foreach ($cart as $id => $details) {
            // Check and store order_detail
            $order_detail_params['name'] = $details['title'];
            $order_detail_params['order_id'] = $order->id;
            $order_detail_params['item_id'] = $id;
            $order_detail_params['quantity'] = $details['quantity'] ?? 1;
            $order_detail_params['price'] = $details['price'] ?? null;

            array_push($data, $order_detail_params);
        }
        OrderDetail::insert($data);

        session()->forget('cart');
        return redirect()->route('frontend.order.checkout')
                        ->with('successMessage', 'Thanh toán thành công.');
    }
}