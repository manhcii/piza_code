<?php

namespace App\Http\Controllers\Admin;

use App\Consts;
use App\Models\Contact;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    private $contact;
    public function __construct()
    {
        $this->contact = new Contact();
        $this->routeDefault  = 'contacts';
        $this->viewPart = 'admin.pages.contacts';
        $this->responseData['module_name'] = __('Contact Management');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $params = $request->all();
        $this->responseData['params'] = $params;
        $params['is_type'] = Consts::CONTACT_TYPE['contact'];
        if (isset($params['created_at_from'])) {
            $params['created_at_from'] = Carbon::createFromFormat('d/m/Y', $params['created_at_from'])->format('Y-m-d');
        }
        if (isset($params['created_at_to'])) {
            $params['created_at_to'] = Carbon::createFromFormat('d/m/Y', $params['created_at_to'])->addDays(1)->format('Y-m-d');
        }
        // Get list with filter params
        $rows = Contact::getContact($params)->paginate(Consts::DEFAULT_PAGINATE_LIMIT);
        $this->responseData['rows'] =  $rows;

        return $this->responseView($this->viewPart . '.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact)
    {
        $this->responseData['detail'] = $contact;
        return $this->responseView($this->viewPart . '.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact $contact)
    {
        $params = $request->all();
        $params['admin_updated_id'] = Auth::guard('admin')->user()->id;

        $contact->fill($params);
        $contact->save();

        return redirect()->back()->with('successMessage', __('Successfully updated!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->back()->with('successMessage', __('Delete record successfully!'));

    }

    public function listCallRequest(Request $request)
    {
        $this->responseData['module_name'] = __('Call request Management');

        $params = $request->all();
        $this->responseData['params'] = $params;
        $params['is_type'] = Consts::CONTACT_TYPE['call_request'];
        if (isset($params['created_at_from'])) {
            $params['created_at_from'] = Carbon::createFromFormat('d/m/Y', $params['created_at_from'])->format('Y-m-d');
        }
        if (isset($params['created_at_to'])) {
            $params['created_at_to'] = Carbon::createFromFormat('d/m/Y', $params['created_at_to'])->addDays(1)->format('Y-m-d');
        }
        // Get list with filter params
        $rows = Contact::getContact($params)->paginate(Consts::DEFAULT_PAGINATE_LIMIT);
        $this->responseData['rows'] =  $rows;

        return $this->responseView($this->viewPart . '.call_request_list');
    }

    public function showCallRequest(Contact $contact)
    {
        $this->responseData['module_name'] = __('Call request Management');
        $this->responseData['detail'] = $contact;

        return $this->responseView($this->viewPart . '.call_request_show');
    }
    public function deleteSelectContact(Request $request)
    {

        $ids = $request->ids;
        // $is_type = $request->is_type;
        $data = $this->contact->whereIn('id',$ids)->get();
        // dd($data);
        if(count($data)>0){
            foreach($data as $item){
                $item->delete();
            }
        }

        if ($data) {
            return response()->json([
                "code" => 200,
                "html" => view($this->viewPart . '.call_request_list'),
                "message" => "Xóa thành công!"
            ], 200);
        } else {
            return response()->json([
                "code" => 500,
                "html" => view($this->viewPart . '.call_request_list'),
                "message" => "Xóa thất bại!"
            ], 500);
        }
    }
    public function deleteSelectCallRequest(Request $request)
    {

        $ids = $request->ids;
        // $is_type = $request->is_type;
        $data = $this->contact->whereIn('id',$ids)->get();
        // dd($data);
        if(count($data)>0){
            foreach($data as $item){
                $item->delete();
            }
        }

        if ($data) {
            return response()->json([
                "code" => 200,
                "html" => view($this->viewPart . '.call_request_list'),
                "message" => "Xóa thành công!"
            ], 200);
        } else {
            return response()->json([
                "code" => 500,
                "html" => view($this->viewPart . '.call_request_list'),
                "message" => "Xóa thất bại!"
            ], 500);
        }
    }
}
