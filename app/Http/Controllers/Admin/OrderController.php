<?php

namespace App\Http\Controllers\Admin;

use App\Consts;
use App\Http\Services\ContentService;
use App\Http\Services\UserService;
use App\Models\AffiliateHistory;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserRegisterConfirmation;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->routeDefault  = 'orders';
        $this->viewPart = 'admin.pages.orders';
        $this->responseData['module_name'] = __('Order Management');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        // Try catch và xử lý kiểm tra trạng thái đơn hàng để + hoặc - điểm (tiền) cho AFL
        DB::beginTransaction();
        try {
            $request->validate([
                'status' => 'required|max:255'
            ]);
            $params = $request->only([
                'payment_status', 'status', 'admin_note', 'json_params'
            ]);
            $params['admin_updated_id'] = Auth::guard('admin')->user()->id;

            if (isset($order->email)) {
                $email = $order->email;
                Mail::send(
                    'frontend.emails.order',
                    [
                        'order' => $order
                    ],
                    function ($message) use ($email) {
                        $message->to($email);
                        $message->subject(__('Your order has been updated'));
                    }
                );
            }
            // Update order
            $order->fill($params);
            $order->save();

            DB::commit();

            return redirect()->back()->with('successMessage', __('Successfully updated!'));
        } catch (Exception $ex) {
            DB::rollBack();
            throw $ex;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        if ($order->status == Consts::ORDER_STATUS['processed']) {
            return redirect()->back()->with('errorMessage', __('Processed orders cannot be deleted!'));
        }

        $order->delete();

        return redirect()->back()->with('successMessage', __('Delete record successfully!'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function listOrderProduct(Request $request)
    {
        $this->responseData['module_name'] = __('Order Product Management');

        $params = $request->all();
        $this->responseData['params'] = $params;
        $params['is_type'] = Consts::ORDER_TYPE['product'];
        if (isset($params['created_at_from'])) {
            $params['created_at_from'] = Carbon::createFromFormat('d/m/Y', $params['created_at_from'])->format('Y-m-d');
        }
        if (isset($params['created_at_to'])) {
            $params['created_at_to'] = Carbon::createFromFormat('d/m/Y', $params['created_at_to'])->addDays(1)->format('Y-m-d');
        }
        $rows = Order::getOrderProduct($params)->paginate(Consts::DEFAULT_PAGINATE_LIMIT);
        $this->responseData['rows'] =  $rows;

        return $this->responseView($this->viewPart . '.order_product_list');
    }

    public function showOrderProduct(Order $order)
    {

        $this->responseData['module_name'] = __('Order Product Management');
        $this->responseData['detail'] = Order::getOrderProduct(['id' => $order->id])->first();

        $params['order_id'] = $order->id;
        $this->responseData['rows'] = Order::getOrderDetail($params)->get();

        // Check if customer_id is existed, get infor of account customer
        if ($order->customer_id > 0) {
            $this->responseData['customer'] = User::find($order->customer_id);
        }
        return $this->responseView($this->viewPart . '.order_product_show');
    }
}
