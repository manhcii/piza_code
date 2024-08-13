<?php

namespace App\Http\Controllers\Admin;

use App\Models\Comment;
use App\Models\CmsPost;
use Illuminate\Http\Request;
use App\Consts;

class CommentController extends Controller
{
    private $comment;
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
        $this->routeDefault  = 'comments';
        $this->viewPart = 'admin.pages.comments';
        $this->responseData['module_name'] = __('Comments setting');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = Comment::orderBy('id')->paginate(Consts::DEFAULT_PAGINATE_LIMIT);
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
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        
        $this->responseData['detail'] = $comment;
        if($comment->id_post > 0){
            $param['id'] = $comment->id_post;
            $param['is_type'] = Consts::TAXONOMY['post'];
            $this->responseData['posts'] = CmsPost::getsqlCmsPost($param)->first();
        }
        return $this->responseView($this->viewPart . '.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        $params = $request->all();
        $comment->fill($params);
        $comment->save();
        return redirect()->back()->with('successMessage', __('Successfully updated!'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $comment->status = Consts::STATUS_DELETE;
        $comment->save();
        return redirect()->route($this->routeDefault . '.index')->with('successMessage', __('Delete record successfully!'));
    }
    public function loadStatus($id)
    {
        // dd($this->comment);
        $comment   =  $this->comment->find($id);
        $status = $comment->status;
        if ($status=="active") {
            $statusUpdate = 'deactive';
        } else {
            $statusUpdate = 'active';
        }
        $updateResult =  $comment->update([
            'status' => $statusUpdate,
        ]);
        // dd($updateResult);
        $comment   =  $this->comment->find($id);
        if ($updateResult) {
            return response()->json([
                "code" => 200,
                "html" => view('admin.components.load-change-status', ['data' => $comment, 'type' => 'bản ghi'])->render(),
                "message" => "success"
            ], 200);
        } else {
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }
    }
    public function deleteSelectComment(Request $request)
    {

        $ids = $request->ids;
        // $is_type = $request->is_type;
        $data = $this->comment->whereIn('id',$ids)->get();
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
