<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdminMenu;
use App\Models\Block;
use App\Models\BlockContent;
use App\Models\CmsPost;
use App\Models\CmsTaxonomy;
use App\Models\CmsProduct;
use App\Models\Menu;
use App\Models\Module;
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

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    private $adminMenu;
    private $block;
    private $blockContent;
    private $cmsPost;
    private $cmsProduct;
    private $cmsTaxonomy;
    private $menu;
    private $module;
    private $page;
    private $role;
    private $user;

    // Part to views for Controller
    protected $viewPart;
    // Route default for Controller
    protected $routeDefault;
    // Data response to view
    protected $responseData = [];
    public function __construct(
        AdminMenu $adminMenu,
        Block $block,
        BlockContent $blockContent,
        CmsPost $cmsPost,
        CmsTaxonomy $cmsTaxonomy,
        CmsProduct $cmsProduct,
        Menu $menu,
        Module $module,
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
        $this->menu = $menu;
        $this->module = $module;
        $this->page = $page;
        $this->role = $role;
        $this->user = $user;
    }
    /**
     * Xử lý các thông tin hệ thống trước khi đổ ra view
     * @author: ThangNH
     * @created_at: 2021/10/01
     */

    protected function responseView($view)
    {

        $this->responseData['admin_auth'] = Auth::guard('admin')->user();
        /**
         * Get all access menu to show in the sidebar by role of current User
         */
        $this->responseData['accessMenus'] = AdminService::getAccessMenu();
        // Set locale to use mutiple languages
        $languages = Language::orderBy('iorder')->get();
        $this->responseData['languages'] = $languages;
        $languageDefault = $languages->first(function ($item, $key) {
            return $item->is_default;
        });
        $this->responseData['languageDefault'] = $languageDefault;
        $locale = request()->cookie('locale_admin') ?? $languageDefault->lang_locale ?? App::getLocale();
        App::setLocale($locale);

        return view($view, $this->responseData);
    }

    protected function sendResponse($data, $message = '')
    {
        $response = [
            'data' => $data,
            'message' => $message
        ];

        return response()->json($response);
    }

    protected function getSetting()
    {
        // Get all global system params
        $options = ContentService::getOption();
        $setting = new stdClass();
        if ($options) {
            foreach ($options as $option) {
                $setting->{$option->option_name} = $option->option_value;
            }
        }

        return $setting;
    }

}
