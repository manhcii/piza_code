<?php

namespace App\Http\Controllers\FrontEnd;

use App\Consts;
use App\Http\Services\ContentService;
use App\Http\Services\PageBuilderService;
use App\Models\Menu;
use App\Models\Widget;
use App\Models\Component;
use App\Models\CmsTaxonomy;
use App\Models\CmsPost;
use App\Models\Language;
use App\Models\Wishlist;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use stdClass;
use Carbon\Carbon;



class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // Part to views for Controller
    protected $viewPart;
    // Route default for Controller
    protected $routeDefault;
    // Data response to view
    protected $responseData = [];

    public function __construct()
    {
        /**
         * For update cache CSS or JS
         * Update 21/04/2023
         */
        $this->responseData['ver'] = 1;
        // Get all global system params
        $options = ContentService::getOption();
        if ($options) {
            $setting = new stdClass();
            foreach ($options as $option) {
                $setting->{$option->option_name} = $option->option_value;
            }
            $this->responseData['setting'] = $setting;
        }

        // Set locale to use mutiple languages
        $lang = Language::where('is_default', 1)->first(); // Get default language
        App::setLocale(Cookie::get('locale')  ?? $lang->lang_code ?? App::getLocale());
        $this->responseData['locale'] = App::getLocale();
    }

    /**
     * Xử lý các thông tin hệ thống trước khi đổ ra view
     * @author: ThangNH
     * @created_at: 2021/10/01
     */

    protected function responseView($view)
    {

        $this->responseData['user_auth'] = Auth::guard('web')->user();
        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web');
            $this->responseData['count_wishlist'] =  Wishlist::where('user_id', $user->user()->id)->count();
        }
        return view ($view, $this->responseData);
    }

    protected function sendResponse($data, $message = '')
    {
        $response = [
            'data' => $data,
            'message' => $message
        ];

        return response()->json($response);
    }

    public function language($locale)
    {

        $count = Language::where('lang_code', $locale)->count();
        if ($count != null) {
            setcookie('locale', $locale, time() + 7 * 24 * 60, '/');
            return redirect()->back()->with('successMessage', __('New language is updated!'));
        } else {
            return redirect()->back()->with('errorMessage', __('Language does not exist!'));
        }
    }


    // public function sitemap()
    // {
    //     $sitemap = App()->make('sitemap');
    //     // Cache kết quả 60 phút
    //    $sitemap->setCache('sitemap', 60);
    //     if (!$sitemap->isCached()) {
    //         $sitemap->add(url('/'), Carbon::now(), 1, 'daily');
    //         // add bài viết
    //         $posts = CmsPost::where('is_type','post')->get();
    //         foreach ($posts as $post) {
    //             //$sitemap->add(url, thời gian, độ ưu tiên, thời gian quay lại)
    //             $sitemap->add(route('post.show', $post->slug), $post->updated_at, 1, 'daily');
    //         }
    //     }
    //     // show your sitemap (options: 'xml' (default), 'html', 'txt', 'ror-rss', 'ror-rdf')
    //     return $sitemap->render('xml');
    // }
}
