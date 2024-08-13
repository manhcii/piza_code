<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdminMenu;
use App\Models\Block;
use App\Models\BlockContent;
use App\Models\CmsPost;
use App\Models\CmsTaxonomy;
use App\Models\CmsProduct;
use App\Models\PostCategory;
use App\Models\ProductCategory;
use App\Models\Parameter;
use App\Models\Widget;
use App\Models\Component;
use App\Models\Menu;
use App\Models\Module;
use App\Models\ModuleFunction;
use App\Models\Page;
use App\Models\Role;
use App\Models\User;
use App\Models\Language;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Http\Services\AdminService;
use App\Http\Services\ContentService;
use Illuminate\Support\Facades\App;
use stdClass;


class LoadUpdateController extends Controller
{
    private $adminMenu;
    private $block;
    private $blockContent;
    private $cmsPost;
    private $cmsProduct;
    private $cmsTaxonomy;
    private $postCategory;
    private $productCategory;
    private $parameter;
    private $widget;
    private $component;
    private $menu;
    private $module;
    private $moduleFunction;
    private $page;
    private $role;
    private $user;
    public function __construct(
        AdminMenu $adminMenu,
        Block $block,
        BlockContent $blockContent,
        CmsPost $cmsPost,
        CmsTaxonomy $cmsTaxonomy,
        CmsProduct $cmsProduct,
        PostCategory $postCategory,
        ProductCategory $productCategory,
        Parameter $parameter,
        Widget $widget,
        Component $component,
        Menu $menu,
        Module $module,
        ModuleFunction $moduleFunction,
        Page $page,
        Role $role,
        User $user
    ) {
        // $this->middleware('auth:admin');
        $this->adminMenu = $adminMenu;
        $this->block = $block;
        $this->blockContent = $blockContent;
        $this->cmsTaxonomy = $cmsTaxonomy;
        $this->cmsProduct = $cmsProduct;
        $this->cmsPost = $cmsPost;
        $this->postCategory = $postCategory;
        $this->productCategory = $productCategory;
        $this->parameter = $parameter;
        $this->widget = $widget;
        $this->component = $component;
        $this->menu = $menu;
        $this->module = $module;
        $this->moduleFunction = $moduleFunction;
        $this->page = $page;
        $this->role = $role;
        $this->user = $user;
    }
    public function loadOrderVeryModel($table, $id, Request $request)
    {
        switch ($table) {
            case 'modules':
                $model = $this->module;
                break;
            case 'module_functions':
                $model = $this->moduleFunction;
                break;
            case 'blocks':
                $model = $this->block;
                break;
            case 'cms_taxonomys':
                $model = $this->cmsTaxonomy;
                break;
            case 'postCategory':
                $model = $this->postCategory;
                break;
            case 'productCategory':
                $model = $this->productCategory;
                break;
            case 'cms_posts':
                $model = $this->cmsPost;
                break;
            case 'cms_products':
                $model = $this->cmsProduct;
                break;
            case 'cms_resources':
                $model = $this->cmsResource;
                break;
            case 'parameter':
                $model = $this->parameter;
                break;
            case 'widget':
                $model = $this->widget;
                break;
            case 'components':
                $model = $this->component;
                break;
            case 'pages':
                $model = $this->page;
                break;
            case 'block_contents':
                $model = $this->blockContent;
                break;
            case 'roles':
                $model = $this->role;
                break;
            case 'menus':
                $model = $this->menu;
                break;
            case 'admin_menus':
                $model = $this->adminMenu;
                break;

            case 'tb_tags':
                $model = $this->tag;
                break;

            default:
                $model = null;
                break;
        }
        //   dd($table);
        if ($model) {
            try {
                DB::beginTransaction();

                $dataUpdate = [
                    "iorder" => $request->input('order'),
                    "admin_updated_id" => auth()->guard('admin')->id()
                ];
                $model->find($id)->update($dataUpdate);

                DB::commit();
                return response()->json([
                    "code" => 200,
                    "html" => 'Sửa số thứ tự thành công',
                    "message" => "success"
                ], 200);
            } catch (\Exception $exception) {
                // dd($exception);
                DB::rollBack();
                Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
                return response()->json([
                    "code" => 500,
                    "message" => "fail"
                ], 500);
            }
        } else {
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }
    }
    public function updateStatus($table, $id, Request $request)
    {

        switch ($table) {
            case 'modules':
                $model = $this->module;
                break;
            case 'blocks':
                $model = $this->block;
                break;
            case 'cms_taxonomys':
                $model = $this->cmsTaxonomy;
                break;
            case 'cms_posts':
                $model = $this->cmsPost;
                break;
            case 'cms_products':
                $model = $this->cmsProduct;
                break;
            case 'cms_resources':
                $model = $this->cmsResource;
                break;
            case 'pages':
                $model = $this->page;
                break;
            case 'block_contents':
                $model = $this->blockContent;
                break;
            case 'roles':
                $model = $this->role;
                break;
            case 'menus':
                $model = $this->menu;
                break;
            case 'admin_menus':
                $model = $this->adminMenu;
                break;
            case 'tb_tags':
                $model = $this->tag;
                break;

            default:
                $model = null;
                break;
        }
        //   dd($table);
        if ($model) {
            try {
                DB::beginTransaction();
                $dataStatus   =  $model->find($id);
                $status = $dataStatus->status;
                if ($status=="active") {
                    $statusUpdate = 'deactive';
                } else {
                    $statusUpdate = 'active';
                }
                $updateResult =  $dataStatus->update([
                    'status' => $statusUpdate,
                ]);
                $dataStatus  =  $model->find($id);
                DB::commit();
                return response()->json([
                    "code" => 200,
                    "html" => view('admin.components.load-change-status', ['data' => $dataStatus, 'type' => 'bản ghi'])->render(),
                    "message" => "success"
                ], 200);
            } catch (\Exception $exception) {
                // dd($exception);
                DB::rollBack();
                Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
                return response()->json([
                    "code" => 500,
                    "message" => "fail"
                ], 500);
            }
        } else {
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }
    }
    public function updateIsfeatured($table, $id, Request $request)
    {

        switch ($table) {
            case 'modules':
                $model = $this->module;
                break;
            case 'blocks':
                $model = $this->block;
                break;
            case 'cms_taxonomys':
                $model = $this->cmsTaxonomy;
                break;
            case 'cms_posts':
                $model = $this->cmsPost;
                break;
            case 'cms_products':
                $model = $this->cmsProduct;
                break;
            case 'cms_resources':
                $model = $this->cmsResource;
                break;
            case 'pages':
                $model = $this->page;
                break;
            case 'block_contents':
                $model = $this->blockContent;
                break;
            case 'roles':
                $model = $this->role;
                break;
            case 'menus':
                $model = $this->menu;
                break;
            case 'admin_menus':
                $model = $this->adminMenu;
                break;

            case 'tb_tags':
                $model = $this->tag;
                break;

            default:
                $model = null;
                break;
        }
        //   dd($table);
        if ($model) {
            try {
                DB::beginTransaction();

                $dataIsfeatured   =  $model->find($id);
                
                $is_featured = $dataIsfeatured->is_featured;
                
                if ($is_featured) {
                    $is_featuredUpdate = 0;
                } else {
                    $is_featuredUpdate = 1;
                }
                $updateResult =  $dataIsfeatured->update([
                    'is_featured' => $is_featuredUpdate,
                ]);
                $dataIsfeatured   =  $model->find($id);
                DB::commit();
                return response()->json([
                    "code" => 200,
                    "html" => view('admin.components.load-change-is_featured', ['data' => $dataIsfeatured, 'type' => 'bản ghi'])->render(),
                    "message" => "success"
                ], 200);
            } catch (\Exception $exception) {
                // dd($exception);
                DB::rollBack();
                Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
                return response()->json([
                    "code" => 500,
                    "message" => "fail"
                ], 500);
            }
        } else {
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }
    }

    public function loadStatusProduct($id)
    {
        // dd($this->cmsProduct);
        $cmsProduct   =  $this->cmsProduct->find($id);
        $status = $cmsProduct->status;
        if ($status=="active") {
            $statusUpdate = 'deactive';
        } else {
            $statusUpdate = 'active';
        }
        $updateResult =  $cmsProduct->update([
            'status' => $statusUpdate,
        ]);
        // dd($updateResult);
        $cmsProduct   =  $this->cmsProduct->find($id);
        if ($updateResult) {
            return response()->json([
                "code" => 200,
                "html" => view('admin.components.load-change-status', ['data' => $cmsProduct, 'type' => 'bản ghi'])->render(),
                "message" => "success"
            ], 200);
        } else {
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }
    }
    public function loadStatusPost($id)
    {
        // dd($this->cmsPost);
        $cmsPost   =  $this->cmsPost->find($id);
        $status = $cmsPost->status;
        if ($status=="active") {
            $statusUpdate = 'deactive';
        } else {
            $statusUpdate = 'active';
        }
        $updateResult =  $cmsPost->update([
            'status' => $statusUpdate,
        ]);
        // dd($updateResult);
        $cmsPost   =  $this->cmsPost->find($id);
        if ($updateResult) {
            return response()->json([
                "code" => 200,
                "html" => view('admin.components.load-change-status', ['data' => $cmsPost, 'type' => 'bản ghi'])->render(),
                "message" => "success"
            ], 200);
        } else {
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }
    }
    public function loadStatusTaxonomys($id)
    {
        // dd($this->cmsTaxonomy);
        $cmsTaxonomy   =  $this->cmsTaxonomy->find($id);
        $status = $cmsTaxonomy->status;
        if ($status=="active") {
            $statusUpdate = 'deactive';
        } else {
            $statusUpdate = 'active';
        }
        $updateResult =  $cmsTaxonomy->update([
            'status' => $statusUpdate,
        ]);
        // dd($updateResult);
        $cmsTaxonomy   =  $this->cmsTaxonomy->find($id);
        if ($updateResult) {
            return response()->json([
                "code" => 200,
                "html" => view('admin.components.load-change-status', ['data' => $cmsTaxonomy, 'type' => 'danh mục'])->render(),
                "message" => "success"
            ], 200);
        } else {
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }
    }
}
