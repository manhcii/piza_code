<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use App\Consts;
use App\Models\BlockContent;
use App\Models\Component;
use App\Models\Page;
use App\Models\Widget;
use App\Models\CmsProduct;
use App\Models\CmsPost;
use App\Models\CmsRelationship;
use App\Models\CmsTaxonomy;
use App\Models\Menu;
use App\Models\Parameter;
use App\Models\Brand;
use App\Models\Review;
use App\Models\Comment;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

use stdClass;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     * Get all element to build page and
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $taxonomy = null, $alias = null)
    {

        if (isset($request['price']) && ($request['price'] == "0;1000" || $request['price'] == "")) {
            unset($request['price']);
        }
        if (isset($request['keyword']) &&  $request['keyword'] == "") {
            unset($request['keyword']);
        }
        $this->responseData['request'] = $request->all();
        $params_post = $request->all();
        if ($alias != '') {
            // Check trong bang taxonomy
            // return ra view tuong ung trong pages.{type}.category --check

            $params['alias'] = $alias;
            $params['status'] = Consts::STATUS['active'];
            $taxonomy = CmsTaxonomy::getSqlTaxonomy($params)->first();
            if ($taxonomy) {
                $this->buildPage($taxonomy->json_params);
                $this->responseData['page'] = $taxonomy;
                // Lấy ra toàn bộ data của taxonomy này theo type
                if ($taxonomy->sub_taxonomy_id != null) {
                    $str_taxonomy_id = $taxonomy->id . ',' . $taxonomy->sub_taxonomy_id;
                    $params_relationship['arr_id'] = array_map('intval', explode(',', $str_taxonomy_id));
                } else {
                    $params_relationship['arr_id'] = $taxonomy->id;
                }
                $relationship = CmsRelationship::getCmsRelationship($params_relationship)->get();
                $arr_object_id = [];
                foreach ($relationship as $val) {
                    $arr_object_id[] = $val->object_id;
                }
                $params_post['object_id'] = array_unique($arr_object_id);
                $params_post['status'] = Consts::STATUS['active'];
                $params_post['order_by'] = 'iorder';
                $params_post['is_type'] = $taxonomy->taxonomy;
                $params_post['user_id'] = Auth::guard('web')->user()->id ?? "";

                // lấy tất cả danh mục
                $data_taxonomy['taxonomy'] = $taxonomy->taxonomy;
                $data_taxonomy['status'] = Consts::STATUS['active'];
                $data_taxonomy['order_by'] = ['iorder' => 'ASC'];
                $data_taxonomy['count'] = true;
                $this->responseData['taxonomys'] = CmsTaxonomy::getSqlTaxonomy($data_taxonomy)->get();

                // lấy thông tin sản phẩm
                if ($taxonomy->taxonomy == Consts::TAXONOMY['product']) {
                    $rows = CmsProduct::getsqlCmsProduct($params_post, $this->responseData['locale'])->paginate(Consts::PAGINATE[$taxonomy->taxonomy]);
                    $this->responseData['rows'] = $rows;
                    // sản phẩm tương tự
                    $data_feature['status'] = Consts::STATUS['active'];
                    $data_feature['is_type'] = $taxonomy->taxonomy;
                    $data_feature['order_by'] = 'iorder';
                    $data_feature['user_id'] = Auth::guard('web')->user()->id ?? "";
                    $feature = CmsProduct::getsqlCmsProduct($data_feature)->limit(Consts::PAGINATE['sidebar'])->get();
                    $this->responseData['feature'] = $feature;
                    $this->responseData['parameter'] = Parameter::where('is_type', $taxonomy->taxonomy)->where('status', Consts::STATUS['active'])->get();
                    $this->responseData['brand'] = Brand::where('status', Consts::STATUS['active'])->get();
                }
                if ($taxonomy->taxonomy == Consts::TAXONOMY['post']) {
                    $rows = CmsPost::getsqlCmsPost($params_post, $this->responseData['locale'])->paginate(Consts::PAGINATE[$taxonomy->taxonomy]);
                    $this->responseData['rows'] = $rows;
                    // bài viết tương tự
                    $data_feature['status'] = Consts::STATUS['active'];
                    $data_feature['is_type'] = $taxonomy->taxonomy;
                    $data_feature['order_by'] = 'iorder';
                    $feature = CmsProduct::getsqlCmsProduct($data_feature)->limit(Consts::PAGINATE['sidebar'])->get();
                    $this->responseData['feature'] = $feature;
                    $this->responseData['parameter'] = Parameter::where('is_type', $taxonomy->taxonomy)->where('status', Consts::STATUS['active'])->get();
                }
                return $this->responseView('frontend.pages.' . $taxonomy->json_params->route_name . '.' . $taxonomy->json_params->template);
            } else {
                return redirect()->route('frontend.page', ['taxonomy' => '404']);
            }
        }

        if ($taxonomy == '') {
            // Home page
            $params['route_name'] = Route::getCurrentRoute()->getName();

            $params['id'] = $this->responseData['web_information']->page->{$params['route_name']} ?? null;
            $params['status'] = Consts::STATUS['active'];
            $page = Page::getSqlPage($params)->first();

            $this->buildPage($page->json_params);
            $this->responseData['page'] = $page;
            return $this->responseView('frontend.pages.' . $page->route_name);
        } else {
            // Trường hợp này chỉ check trong bảng page hoặc detail
            // Check trong bang page
            $params['alias'] = $taxonomy;
            $params['status'] = Consts::STATUS['active'];
            $page = Page::getSqlPage($params)->first();

            if ($page) {
                $this->buildPage($page->json_params);
                $this->responseData['page'] = $page;

                return $this->responseView('frontend.pages.' . $page->route_name);
            }

            // Check trong bang post
            $detail = CmsPost::getsqlCmsPost($params)->first();
            if ($detail) {
                // lấy thông tin danh mục
                $this->responseData['detail'] = $detail;
                $this->buildPage($detail->json_params);

                if ($detail->is_type == Consts::TAXONOMY['product']) {
                    // lấy danh sách danh mục
                    $params_product['taxonomy'] = $detail->is_type;
                    $params_product['status'] = Consts::STATUS['active'];
                    $taxonomy = CmsTaxonomy::getSqlTaxonomy($params_product)->get();
                    $this->responseData['taxonomy'] = $taxonomy;

                    $relationship = CmsRelationship::where('object_id', $detail->id)->get();
                    foreach ($relationship as $val) {
                        $this->responseData['relationship'][] = $val->taxonomy_id;
                    }

                    // lấy danh sách thông số
                    $this->responseData['parameter'] = Parameter::where('is_type', $detail->is_type)->where('status', Consts::STATUS['active'])->get();
                    // $this->responseData['brand'] = Brand::where('status', Consts::STATUS['active'])->get();
                    if (isset($detail->json_params->related_post)) {
                        $params_related_post['order_by'] = 'id';
                        $params_related_post['related_post'] = $detail->json_params->related_post ?? null;
                        $params_related_post['user_id'] = Auth::guard('web')->user()->id ?? "";
                        $this->responseData['relatedPosts'] = CmsProduct::getsqlCmsProduct($params_related_post)->get();
                    }
                    // thông tin review
                    $this->responseData['review'] = Review::where('id_product', $detail->id)->where('status', Consts::STATUS['active'])->orderBy('id')->get();
                    $this->responseData['user_auth'] = Auth::guard('web')->user();
                }
                if ($detail->is_type == Consts::TAXONOMY['post']) {
                    // lấy danh sách danh mục
                    $data_taxonomy['taxonomy'] = $detail->is_type;
                    $data_taxonomy['status'] = Consts::STATUS['active'];
                    $data_taxonomy['order_by'] = ['iorder' => 'ASC'];
                    $data_taxonomy['count'] = true;
                    $taxonomy = CmsTaxonomy::getSqlTaxonomy($data_taxonomy)->get();
                    $this->responseData['taxonomys'] = $taxonomy;
                    $relationship = CmsRelationship::where('object_id', $detail->id)->get();
                    foreach ($relationship as $val) {
                        $this->responseData['relationship'][] = $val->taxonomy_id;
                    }
                    // bài viết tương tự
                    $data_feature['status'] = Consts::STATUS['active'];
                    $data_feature['is_type'] = $detail->is_type;
                    $data_feature['order_by'] = 'iorder';
                    $feature = CmsProduct::getsqlCmsProduct($data_feature)->limit(Consts::PAGINATE['sidebar'])->get();
                    $this->responseData['feature'] = $feature;
                    // thông tin comment
                    $this->responseData['comment'] = Comment::where('id_post', $detail->id)->where('status', Consts::STATUS['active'])->orderBy('id')->limit(5)->get();
                    // lấy danh sách thông số
                    $this->responseData['parameter'] = Parameter::where('is_type', $detail->is_type)->where('status', Consts::STATUS['active'])->get();
                }
                // return ra view tuong ung trong pages.{type}.detail
                return $this->responseView('frontend.pages.' . $detail->json_params->route_name . '.' . $detail->json_params->template);
            }

            // Update 404 page not found and redirect to its
            return redirect()->route('frontend.page', ['taxonomy' => '404']);
        }
        return redirect()->route('frontend.page', ['taxonomy' => '404']);
    }

    public function buildPageDefault($json_params)
    {
        // Get Block content by page
        $params_page['route_name'] = $json_params->route_name;
        $pages = Page::getSqlPage($params_page)->get();
        $page_origin = $pages->first(function ($item) use ($json_params) {
            return $item->json_params->template == $json_params->template;
        });
        if (isset($page_origin->json_params->block_content)) {
            $params_block['template'] = $json_params->template;
            $params_block['status'] = Consts::STATUS['active'];
            $params_block['order_by'] = [
                'iorder' => 'ASC',
                'id' => 'DESC'
            ];
            $blocks = BlockContent::getSqlBlockContent($params_block)->get();
            // Reorder blockContents setting of this widget
            $block_setting = $page_origin->json_params->block_content ?? [];
            // Filter selected blockContents
            $blocks_selected = $blocks->filter(function ($item) use ($block_setting) {
                return in_array($item->id, $block_setting);
            });
            // Reorder selected blockContents
            $blocks_selected = $blocks_selected->sortBy(function ($item) use ($block_setting) {
                return array_search($item->id, $block_setting);
            });


            $this->responseData['blocks'] = $blocks;
            $this->responseData['blocks_selected'] = $blocks_selected;
            $this->responseData['page_origin'] = $page_origin;
        }
        // dd($this->responseData);
    }
    public function buildPage($json_params)
    {
        if (isset($json_params->block_content)) {
            $params_block['template'] = $json_params->template;
            $params_block['status'] = Consts::STATUS['active'];
            $params_block['order_by'] = [
                'iorder' => 'ASC',
                'id' => 'DESC'
            ];

            $blocks = BlockContent::getSqlBlockContent($params_block)->get();
            // Reorder blockContents setting of this widget
            $block_setting = $json_params->block_content ?? [];
            // Filter selected blockContents
            $blocks_selected = $blocks->filter(function ($item) use ($block_setting) {
                return in_array($item->id, $block_setting);
            });
            // Reorder selected blockContents
            $blocks_selected = $blocks_selected->sortBy(function ($item) use ($block_setting) {
                return array_search($item->id, $block_setting);
            });
            $this->responseData['blocks'] = $blocks;
            $this->responseData['blocks_selected'] = $blocks_selected;
        } else {

            $this->buildPageDefault($json_params);
        }

        // Check widget and get by this page
        if (isset($json_params->widget) && count(array_filter($json_params->widget)) > 0) {
            $params_widget['list_id'] = array_filter($json_params->widget);
            $params_widget['status'] = Consts::STATUS['active'];
            if (count(array_filter($json_params->widget)) < 3 && isset($this->responseData['setting']->widget)) {
                foreach (json_decode($this->responseData['setting']->widget) as $key => $val) {
                    if (!isset($params_widget['list_id'][$key])) {
                        $params_widget['list_id'][$key] = $val;
                    }
                }
                ksort($params_widget['list_id']);
            }
            $widgets = Widget::getSqlWidget($params_widget)->get();

            $widget = new stdClass();
            $component_selected = [];
            foreach ($widgets as $item) {
                $widget->{$item->widget_code} = $item;
                // Get all component_id in this page
                $component_selected = array_unique(array_merge($component_selected, $item->json_params->component));
            }
            $params_component['list_id'] = $component_selected;
            $params_component['status'] = Consts::STATUS['active'];
            $components = Component::getSqlComponent($params_component)->get();
            $this->responseData['widget'] = $widget;
            $this->responseData['components'] = $components;
            $all_components = Component::where('status', Consts::STATUS['active'])->get();
            $this->responseData['all_components'] = $all_components;

            $this->responseData['menu'] = Menu::getSqlMenu(['status' => 'active', 'order_by' => ['iorder' => 'ASC']])->get();
        } else {
            $this->buildWidgetDefault();
        }
    }

    public function buildWidgetDefault()
    {
        # Get all widget is default config on system
        if (isset($this->responseData['setting']->widget)) {
            $params_widget['list_id'] = json_decode($this->responseData['setting']->widget);
            $params_widget['status'] = Consts::STATUS['active'];

            $widgets = Widget::getSqlWidget($params_widget)->get();

            $widget = new stdClass();
            $component_selected = [];
            foreach ($widgets as $item) {
                $widget->{$item->widget_code} = $item;
                // Get all component_id in this page
                $component_selected = array_unique(array_merge($component_selected, $item->json_params->component));
            }
            $params_component['list_id'] = $component_selected;
            $params_component['status'] = Consts::STATUS['active'];
            $components = Component::getSqlComponent($params_component)->get();
            $this->responseData['widget'] = $widget;
            $this->responseData['components'] = $components;
            $all_components = Component::where('status', Consts::STATUS['active'])->get();
            $this->responseData['all_components'] = $all_components;
            $this->responseData['menu'] = Menu::getSqlMenu(['status' => 'active', 'order_by' => ['iorder' => 'ASC']])->get();
        }
    }
    public function buildWidgetDefault2()
    {

        # Get all widget is default config on system
        if (isset($this->responseData['setting']->widget)) {

            $params_widget['list_id'] = json_decode($this->responseData['setting']->widget);
            $params_widget['status'] = Consts::STATUS['active'];

            $widgets = Widget::getSqlWidget($params_widget)->get();
            $widget = new stdClass();
            $component_selected = [];
            foreach ($widgets as $item) {
                $widget->{$item->widget_code} = $item;
                // Get all component_id in this page
                $component_selected = array_unique(array_merge($component_selected, $item->json_params->component));
            }
            $params_component['list_id'] = $component_selected;
            $params_component['status'] = Consts::STATUS['active'];
            $components = Component::getSqlComponent($params_component)->get();
            $this->responseData['widget'] = $widget;
            $this->responseData['components'] = $components;
            $all_components = Component::where('status', Consts::STATUS['active'])->get();
            $this->responseData['all_components'] = $all_components;
            $this->responseData['menu'] = Menu::getSqlMenu(['status' => 'active', 'order_by' => ['iorder' => 'ASC']])->get();
            return  $this->responseData;
        }
    }
    public function quickview(Request $request)
    {
        $lang = App::getLocale();
        $id = $request->get('id')  ?? null;
        if ($id > 0) {
            $params['id'] = $id;
            $detail = [];
            $row = CmsProduct::getsqlCmsProduct($params)->first();
            $detail['id'] = $row->id;
            $detail['name'] = $row->json_params->name->$lang ?? $row->name;
            $detail['brief'] = $row->json_params->brief->$lang ?? $row->brief;
            $detail['price'] = $row->price ?? 0;
            $detail['price_old'] = $row->price_old ?? null;
            // danh sách ảnh
            $image = [];
            if ($row->image != "") {
                $image[] = $row->image ?? url('data/images/no_image.jpg');
            } else {
                $image[] = url('data/images/no_image.jpg');
            }
            // ảnh gallery
            // if($detail->image_thumb !=""){$image[]=$detail->image_thumb;}
            // if(isset($detail->json_params->gallery_image)){
            //     foreach($detail->json_params->gallery_image as $val){
            //         $image[] = $val;
            //     }
            // }
            $this->responseData['detail'] = $detail;
            $this->responseData['image'] = $image;
            $this->responseData['review']['star'] = $row->rating ?? 0;
            $this->responseData['review']['count'] = $row->count_review ?? 0;
            $messageResult = __('successfull!');
            return $this->sendResponse($this->responseData, $messageResult);
        }
    }
    public function json_search(Request $request)
    {
        $request->validate([
            'keyword' => 'required',
        ]);
        $params = $request->all();
        $lang = $params['lang'];
        $row = CmsProduct::getsqlCmsProduct($params)->limit(Consts::PAGINATE['search'])->get();
        $rows = [];
        for ($i = 0; $i < count($row); $i++) {
            $rows[$i]['id'] = $row[$i]->id;
            $rows[$i]['name'] = $row[$i]->json_params->name->$lang ?? $row[$i]->name ?? "";
            $rows[$i]['image'] = $row[$i]->image ?? url('data/images/no_image.jpg');
            $rows[$i]['price'] = $row[$i]->price ?? null;
            $rows[$i]['price_old'] = $row[$i]->price_old ?? null;;
            $rows[$i]['link'] =  $row[$i]->alias ? route('frontend.page', ['taxonomy' => $row[$i]->alias]) : "";
        }
        $messageResult = __('successfull!');
        return $this->sendResponse($rows, $messageResult);
    }

    public function view_more(Request $request)
    {
        $params = $request->all();
        $taxonomy = $params['taxonomy'];
        // $lastpage = $params['lastpage'];
        $currentpage = $params['currentpage'];
        $perpage = $params['perpage'];
        $lang = $params['lang'];
        $start = $currentpage * $perpage;


        if ($taxonomy == 0) {
            $params_post['is_type'] = $params['type'];
            $params_post['status'] = Consts::STATUS['active'];

            $row = CmsPost::getsqlCmsPost($params_post,$this->responseData['locale'])->skip($start)->take($perpage)->get();
            $rows = [];
            for ($i = 0; $i < count($row); $i++) {
                $rows[$i]['id'] = $row[$i]->id;
                $rows[$i]['name'] = $row[$i]->json_params->name->$lang ?? $row[$i]->name ?? "";
                $rows[$i]['brief'] = $row[$i]->json_params->brief->$lang ?? $row[$i]->brief ?? "";
                $rows[$i]['image'] = $row[$i]->image ?? url('data/images/no_image.jpg');
                $rows[$i]['time'] = date('d.M.Y', strTotime($row[$i]->created_at));
                $rows[$i]['link'] = route('frontend.page', ['taxonomy' => $row[$i]->alias ?? '']);
            }
        } else {
            $data_relationship['id'] = $taxonomy;
            $row = CmsRelationship::getCmsProduct($data_relationship)->skip($start)->take($perpage)->get();
            $rows = [];
            for ($i = 0; $i < count($row); $i++) {
                $rows[$i]['id'] = $row[$i]->id;
                $rows[$i]['name'] = $row[$i]->json_params->name->$lang ?? $row[$i]->name ?? "";
                $rows[$i]['brief'] = $row[$i]->json_params->brief->$lang ?? $row[$i]->brief ?? "";
                $rows[$i]['image'] = $row[$i]->image ?? url('data/images/no_image.jpg');
                $rows[$i]['price'] = $row[$i]->price != '' ? number_format($row[$i]->price, 2) : 0;
                $rows[$i]['price_old'] = $row[$i]->price_old ?? null;
                $rows[$i]['link'] =  route('frontend.page', ['taxonomy' => $row[$i]->alias ?? '']);
            }
        }

        $messageResult = __('successfull!');
        return $this->sendResponse($rows, $messageResult);
    }
}
