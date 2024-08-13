<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\CmsTaxonomy;
use App\Consts;
use App\Models\Widget;
use App\Models\WidgetConfig;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CmsTaxonomyController extends Controller
{
    public function __construct()
    {
        $this->routeDefault  = 'cms_taxonomys';
        $this->viewPart = 'admin.pages.cms_taxonomys';
        $this->responseData['module_name'] = __('Taxonomy Management');
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
        $this->responseData['rows'] =  CmsTaxonomy::getSqlTaxonomy($params)->get();

        return $this->responseView($this->viewPart . '.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $params['status'] = Consts::TAXONOMY_STATUS['active'];
        // Config widgets for this page
        $params_widget['status'] = Consts::STATUS['active'];
        $params_widget['order_by'] = [
            'widget_code' => 'ASC',
            'status' => 'ASC',
            'iorder' => 'ASC',
            'id' => 'DESC'
        ];
        $widgets = Widget::getSqlWidget($params_widget)->get();

        $this->responseData['widgets'] = $widgets;
        $this->responseData['taxonomys'] = CmsTaxonomy::getSqlTaxonomy($params)->get();
        $this->responseData['status'] = Consts::STATUS;
        $this->responseData['route_name'] = Consts::ROUTE_NAME;

        return $this->responseView($this->viewPart . '.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'taxonomy' => 'required|max:255',
            'taxonomy' => 'required|max:255',
        ]);

        $params = $request->all();
        $params['alias'] = Str::slug($params['alias'] ?? $params['name']);

        $params['admin_created_id'] = Auth::guard('admin')->user()->id;
        $params['admin_updated_id'] = Auth::guard('admin')->user()->id;

        $wedget_content = json_decode($params['widgets_selected']);
        $widget_block = [];
        if(!empty($wedget_content) && count($wedget_content) > 0){
            foreach($wedget_content as $val){
                if(!isset($val->id)){continue;}
                $widget_block[] = $val->id;
            }
        }
        $params['json_params']['widget'] = $widget_block;
        unset($params['widgets_selected']);

        CmsTaxonomy::create($params);

        return redirect()->route($this->routeDefault . '.index')->with('successMessage', __('Add new successfully!'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CmsTaxonomy  $cmsTaxonomy
     * @return \Illuminate\Http\Response
     */
    public function show(CmsTaxonomy $cmsTaxonomy)
    {
        // Do not use this function
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CmsTaxonomy  $cmsTaxonomy
     * @return \Illuminate\Http\Response
     */
    public function edit(CmsTaxonomy $cmsTaxonomy)
    {
        // Get all parents which have status is active
        $params['status'] = Consts::TAXONOMY_STATUS['active'];
        $params['different_id'] = $cmsTaxonomy->id;

        // Config widgets for this page
        $params_widget['status'] = Consts::STATUS['active'];
        $params_widget['order_by'] = [
            'widget_code' => 'ASC',
            'status' => 'ASC',
            'iorder' => 'ASC',
            'id' => 'DESC'
        ];
        $widgets = Widget::getSqlWidget($params_widget)->get();
        $widgetConfig = WidgetConfig::all();
        $this->responseData['widgets'] = $widgets;
        $this->responseData['widgetConfig'] = $widgetConfig;
        $this->responseData['categorys'] = CmsTaxonomy::getSqlTaxonomy($params)->get();
        $this->responseData['detail'] = $cmsTaxonomy;
        $this->responseData['status'] = Consts::STATUS;
        $this->responseData['route_name'] = Consts::ROUTE_NAME;

        return $this->responseView($this->viewPart . '.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CmsTaxonomy  $cmsTaxonomy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CmsTaxonomy $cmsTaxonomy)
    {
        $request->validate([
            'name' => 'required|max:255',
            'taxonomy' => 'required|max:255',
        ]);

        $params = $request->all();
        $params['alias'] = Str::slug($params['alias'] ?? $params['name']);
        $params['admin_updated_id'] = Auth::guard('admin')->user()->id;
        $wedget_content = json_decode($params['widgets_selected']);
        $widget_block = [];
        if(!empty($wedget_content) && count($wedget_content) > 0){
            foreach($wedget_content as $val){
                if(!isset($val->id)){continue;}
                $widget_block[] = $val->id;
            }
        }
        $params['json_params']['widget'] = $widget_block;
        unset($params['widgets_selected']);

        $cmsTaxonomy->fill($params);
        $cmsTaxonomy->save();

        return redirect()->back()->with('successMessage', __('Successfully updated!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CmsTaxonomy  $cmsTaxonomy
     * @return \Illuminate\Http\Response
     */
    public function destroy(CmsTaxonomy $cmsTaxonomy)
    {
        $cmsTaxonomy->status = Consts::STATUS_DELETE;
        $cmsTaxonomy->save();

        // Update delete status sub
        CmsTaxonomy::where('parent_id', '=', $cmsTaxonomy->id)->update(['status' => Consts::STATUS_DELETE]);

        return redirect()->back()->with('successMessage', __('Delete record successfully!'));
    }
}
