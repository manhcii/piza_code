<?php

namespace App\Http\Controllers\Admin;

use App\Models\Review;
use App\Models\CmsProduct;
use Illuminate\Http\Request;
use App\Consts;

class ReviewController extends Controller
{
    private $review;
    public function __construct(Review $review)
    {
        $this->review = $review;
        $this->routeDefault  = 'reviews';
        $this->viewPart = 'admin.pages.reviews';
        $this->responseData['module_name'] = __('Reviews setting');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = Review::orderBy('id')->paginate(Consts::DEFAULT_PAGINATE_LIMIT);
        $this->responseData['rows'] = $rows;
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
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        $this->responseData['detail'] = $review;
        if($review->id_product > 0){
            $param['id'] = $review->id_product;
            $param['is_type'] = Consts::TAXONOMY['product'];
            $this->responseData['posts'] = CmsProduct::getsqlCmsProduct($param)->first();

        }
        return $this->responseView($this->viewPart . '.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {
        $params = $request->all();
        $review->fill($params);
        $review->save();
        return redirect()->back()->with('successMessage', __('Successfully updated!'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        $review->status = Consts::STATUS_DELETE;
        $review->save();
        return redirect()->route($this->routeDefault . '.index')->with('successMessage', __('Delete record successfully!'));

    }
    public function loadStatus($id)
    {
        // dd($this->review);
        $review   =  $this->review->find($id);
        $status = $review->status;
        if ($status=="active") {
            $statusUpdate = 'deactive';
        } else {
            $statusUpdate = 'active';
        }
        $updateResult =  $review->update([
            'status' => $statusUpdate,
        ]);
        // dd($updateResult);
        $review   =  $this->review->find($id);
        if ($updateResult) {
            return response()->json([
                "code" => 200,
                "html" => view('admin.components.load-change-status', ['data' => $review, 'type' => 'danh mục'])->render(),
                "message" => "success"
            ], 200);
        } else {
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }
    }
    public function deleteSelectReview(Request $request)
    {

        $ids = $request->ids;
        // $is_type = $request->is_type;
        $data = $this->review->whereIn('id',$ids)->get();
        // dd($data);
        if(count($data)>0){
            foreach($data as $item){
                $item->delete();
            }
        }

        if ($data) {
            return response()->json([
                "code" => 200,
                "html" => view($this->viewPart . '.index'),
                "message" => "Xóa thành công!"
            ], 200);
        } else {
            return response()->json([
                "code" => 500,
                "html" => view($this->viewPart . '.index'),
                "message" => "Xóa thất bại!"
            ], 500);
        }
    }
}
