<?php

namespace App\Http\Controllers\Admin;

use App\Consts;
use App\Models\CmsPost;
use App\Models\CmsProduct;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Comment;
use App\Models\Contact;

use Illuminate\Http\Request;
use App\Http\Services\AdminService;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->viewPart = 'admin.pages.home';
        $this->responseData['module_name'] = 'Welcome to Admin System!';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $params['is_type'] = Consts::TAXONOMY['post'];
        $params['is_featured'] = true;
        $params['status'] = Consts::STATUS['active'];
        $params['order_by'] = 'created_at';

        // Get list post with filter params
        $rows_post = CmsPost::getsqlCmsPost($params)->limit(10)->get();
        $this->responseData['rows_post'] = $rows_post;

        // Get list product with filter params
        $params['is_type'] = Consts::TAXONOMY['product'];
        $rows_product = CmsProduct::getsqlCmsProduct($params)->limit(10)->get();
        $this->responseData['rows_product'] = $rows_product;

        // Get list product with filter params
        $params['is_type'] = Consts::TAXONOMY['post'];
        $rows_post = CmsPost::getsqlCmsPost($params)->limit(10)->get();
        $this->responseData['rows_post'] = $rows_post;

        // Get list order with filter params
        $params['is_type'] = Consts::ORDER_TYPE['product'];
        $rows_order = Order::getOrderProduct($params)->get();
        $this->responseData['rows_order'] = $rows_order;

        // Get list customer with filter params
        $rows_customer = Customer::orderBy('created_at', 'DESC')->get();
        $this->responseData['rows_customer'] = $rows_customer;

        // Get list customer with filter params
        $rows_comment = Comment::orderBy('created_at', 'DESC')->get();
        $this->responseData['rows_comment'] = $rows_comment;

        // Get list customer with filter params
        $rows_contact = Contact::where('status','!=',Consts::STATUS['delete'])->orderBy('created_at', 'DESC')->get();
        $this->responseData['rows_contact'] = $rows_contact;


        // Get list user with filter params
        $get_admin = new AdminService();
        $admins = $get_admin->getAdmins($request->all(), true);
        $this->responseData['admins'] = $admins;


        return $this->responseView($this->viewPart . '.index');
    }
}
