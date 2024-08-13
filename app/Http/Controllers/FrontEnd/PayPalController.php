<?php

namespace App\Http\Controllers\FrontEnd;

use App\Consts;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Discount;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\UserRegisterConfirmation;

use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalController extends Controller
{
    /**
     * create transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function createTransaction()
    {
        return view('frontend.pages.cart.test');
    }

    /**
     * process transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function processTransaction(Request $request)
    {
        session()->put('paypal', $request->all());
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->back()->with('errorMessage', __('Cart is empty!'));
        }
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'ship_fee' => 'required',
            'json_params.country' => 'required',
            'json_params.city' => 'required',
            'json_params.address' => 'required',
            'phone' => 'required'
        ]);

        $createaccount = $request->createaccount;
        if ($createaccount == 1) {
            $request->validate([
                'account_password' => 'required',
                'email' => "required|string|max:255|unique:users,email",
            ]);
        }


        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();



        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('successTransaction'),
                "cancel_url" => route('cancelTransaction'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $request->total
                    ]
                ]
            ]
        ]);

        if (isset($response['id']) && $response['id'] != null) {

            // redirect to approve href
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }

            return redirect()
                ->route('frontend.order.checkout')
                ->with('errorMessage', 'Lỗi! Vui lòng thử lại.');
        } else {
            return redirect()
                ->route('frontend.order.checkout')
                ->with('errorMessage', $response['message'] ?? 'Lỗi! Vui lòng thử lại.');
        }
    }

    /**
     * success transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function successTransaction(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);

        $paypal = session()->get('paypal');
        $cart   = session()->get('cart', []);
        $createaccount = $paypal['createaccount'] ?? "";

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            DB::beginTransaction();
            try {

                // Check and store order
                $order_params['is_type'] = Consts::TAXONOMY['product'];
                $order_params['name'] = $paypal['name'];
                $order_params['json_params'] = $paypal['json_params'];
                $order_params['phone'] = $paypal['phone'];
                $order_params['email'] = $paypal['email'];
                $order_params['transaction_code'] = $paypal['transaction_code'];
                $order_params['total'] = $paypal['total'];
                $order_params['discount'] = $paypal['discount']??0;
                $order_params['shipping'] = $paypal['ship_fee'];
                $order_params['payment_status'] = 1;
                $order_params['status'] = 0;
                $order_params['token'] = $paypal['_token'];

                // Check and add user_id login or affiliate_code
                if (Auth::guard('web')->check()) {
                    $order_params['customer_id'] = Auth::guard('web')->id();
                }

                $order = Order::create($order_params);

                // update coupon_quantity
                $discount = Discount::find($paypal['json_params']['id_discount']);
                if ($discount->is_unlimited != "unlimited" && $discount->coupon_quantity >= 1) {
                    $discount->coupon_quantity -= 1;
                    $discount->save();
                }
                $data = [];
                foreach ($cart as $id => $items_cart) {
                    // Check and store order_detail
                    foreach ($items_cart as $details) {
                        $order_detail_params['name'] = $paypal['name'];
                        $order_detail_params['order_id'] = $order->id;
                        $order_detail_params['item_id'] = $id;
                        $order_detail_params['quantity'] = $details['quantity'] ?? 1;
                        $order_detail_params['price'] = $details['price'] ?? null;
                        $json['size'] = $details['size'] ?? null;
                        $json['color'] = $details['color'] ?? null;
                        $order_detail_params['json_params'] = json_encode($json);
                        array_push($data, $order_detail_params);
                    }
                }
                OrderDetail::insert($data);

                $messageResult = __('Submit order successfull!');

                if (isset($this->responseData['setting']->email)) {
                    // $email = $this->responseData['setting']->email;
                    $email = $paypal['email'];
                    Mail::send(
                        'frontend.emails.order',
                        [
                            'order' => $order
                        ],
                        function ($message) use ($email) {
                            $message->to($email);
                            $message->subject(__('You received a new order from the system'));
                        }
                    );
                }
                if ($createaccount == 1) {
                    $params_sigup['name'] = $paypal['name'];
                    $params_sigup['email'] = $paypal['email'];
                    $params_sigup['password'] = $paypal['account_password'];
                    $params_sigup['phone'] = $paypal['phone'];
                    $params_sigup['country_id'] = $paypal["json_params['country']"] ?? '0';
                    $params_sigup['city_id'] = $paypal["json_params['city']"] ?? "0";
                    $params_sigup['street_address'] = $paypal["json_params['address']"] ?? "";
                    // dd($params_sigup);
                    $user = User::create($params_sigup);
                    $confirmationCode = Str::random(32);
                    $user->email_verification_code = $confirmationCode;
                    $user->save();

                    Mail::to($user->email)->send(new UserRegisterConfirmation($user->email, $confirmationCode));
                }

                DB::commit();
                session()->forget('cart');
                session()->forget('paypal');
            } catch (Exception $ex) {
                DB::rollBack();
                // throw $ex;
                abort(422, __($ex->getMessage()));
            }
            return redirect()
                ->route('frontend.order.received', ['id' => $order->id, 'key' => $paypal['_token']])
                ->with('successMessage', 'Thanh toán thành công.');
        } else {
            return redirect()
                ->route('frontend.order.checkout')
                ->with('errorMessage', $response['message'] ?? 'Lỗi! Vui lòng thử lại.');
        }
    }

    /**
     * cancel transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function cancelTransaction(Request $request)
    {
        return redirect()
            ->route('frontend.order.checkout')
            ->with('errorMessage', $response['message'] ?? 'Bạn đã hủy thanh toán.');
    }
}
