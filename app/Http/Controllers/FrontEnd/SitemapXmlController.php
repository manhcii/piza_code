<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use App\Http\Services\ContentService;
use App\Consts;
use App\Models\CmsPost;
use App\Models\Page;
use App\Models\CmsTaxonomy;

class SitemapXmlController extends Controller
{
    public function index()
    {
        return response()->view('frontend.sitemap.index', [
            'sitemap' => Consts::ROUTE_SITEMAP,
        ])->header('Content-Type', 'text/xml');
    }

    public function taxonomy($type = null)
    {
        $routes = [];
        foreach (Consts::ROUTE_SITEMAP as $item) {
            $routes[] = $item['name'];
        }
        if ($type != null && in_array($type, $routes)) {
            $data_pages=$data_taxonomy=$data_post=[];
            switch ($type) {
                case 'pages':
                    $data_pages = Page::where('status', "!=", Consts::STATUS_DELETE)
                        ->orderByRaw('status ASC, iorder ASC, id DESC')
                        ->get();
                    break;
                case 'taxonomy':
                    $data_taxonomy = CmsTaxonomy::where('status', "!=", Consts::STATUS_DELETE)
                        ->orderByRaw('status ASC, iorder ASC, id DESC')
                        ->get();
                    break;
                case 'post':
                    $data_post = CmsPost::where('status', "!=", Consts::STATUS_DELETE)
                        ->orderByRaw('status ASC, iorder ASC, id DESC')
                        ->get();
                    break;
            }
            return response()->view('frontend.sitemap.data', [
                'data_pages' => $data_pages,
                'data_taxonomy' => $data_taxonomy,
                'data_post' => $data_post,
            ])->header('Content-Type', 'text/xml');
        }
    }
}
