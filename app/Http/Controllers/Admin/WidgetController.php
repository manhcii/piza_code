<?php

namespace App\Http\Controllers\Admin;

use App\Consts;
use App\Http\Services\PageBuilderService;
use App\Models\Widget;
use App\Models\WidgetConfig;
use App\Models\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WidgetController extends Controller
{
    private $widget;
    public function __construct(Widget $widget)
    {
        $this->widget = $widget;
        $this->routeDefault  = 'widgets';
        $this->viewPart = 'admin.pages.widgets';
        $this->responseData['module_name'] = __('Widget Management');
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

        $params['order_by'] = [
            'status' => 'ASC',
            'iorder' => 'ASC',
            'id' => 'DESC'
        ];

        $rows = Widget::getSqlWidget($params)->get();
        $this->responseData['rows'] =  $rows;

        // Get all widget_configs which have status is active
        $widget_configs = WidgetConfig::where('status', 'active')->orderByRaw('iorder ASC, id DESC')->get();
        $this->responseData['widget_configs'] = $widget_configs;

        return $this->responseView($this->viewPart . '.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Get all parents which have status is active
        $parents = Widget::where('status', 'active')->orderByRaw('iorder ASC, id DESC')->get();
        // Get all widget_configs which have status is active
        $widget_configs = WidgetConfig::where('status', 'active')->orderByRaw('iorder ASC, id DESC')->get();
        // Get all components which have status is active
        $params['status'] = Consts::STATUS['active'];
        $params['order_by'] = [
            'status' => 'ASC',
            'iorder' => 'ASC',
            'id' => 'DESC'
        ];
        $components = Component::getSqlComponent($params)->where('tb_components.parent_id', NULL)->get();

        $this->responseData['components'] = $components;
        $this->responseData['parents'] = $parents;
        $this->responseData['widget_configs'] = $widget_configs;

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
            'title' => 'required|max:255',
            'widget_code' => 'required|max:255'
        ]);

        $params = $request->all();

        $params['admin_created_id'] = Auth::guard('admin')->user()->id;
        $params['admin_updated_id'] = Auth::guard('admin')->user()->id;
        $components_content = json_decode($params['output_selected']);
        $arr_components = [];
        if(!empty($components_content) && count($components_content) > 0){
            foreach($components_content as $val){
                if(!isset($val->id)){continue;}
                $arr_components[] = $val->id;
            }
        }
        $params['json_params']['component'] = $arr_components;
        unset($params['output_selected']);
        unset($params['output_available']);
        Widget::create($params);

        return redirect()->route($this->routeDefault . '.index')->with('successMessage', __('Add new successfully!'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Widget  $widget
     * @return \Illuminate\Http\Response
     */
    public function show(Widget $widget)
    {
        // Do not use this function
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Widget  $widget
     * @return \Illuminate\Http\Response
     */
    public function edit(Widget $widget)
    {
        // Get all parents which have status is active
        $parents = Widget::where('status', 'active')->where('id', '!=', $widget->id)->orderByRaw('iorder ASC, id DESC')->get();
        // Get all widget_configs which have status is active
        $widget_configs = WidgetConfig::where('status', 'active')->orderByRaw('iorder ASC, id DESC')->get();
        // Get all components which have status is active
        $params['status'] = Consts::STATUS['active'];
        $params['order_by'] = [
            'status' => 'ASC',
            'iorder' => 'ASC',
            'id' => 'DESC'
        ];
        $components = Component::getSqlComponent($params)->where('tb_components.parent_id', NULL)->get();

        $this->responseData['components'] = $components;
        $this->responseData['parents'] = $parents;
        $this->responseData['widget_configs'] = $widget_configs;
        $this->responseData['detail'] = $widget;

        // Reorder component setting of this widget
        $component_setting = $widget->json_params->component ?? [];
        // Filter selected component

        $component_selected = $components->filter(function ($item) use ($component_setting) {
            return in_array($item->id, $component_setting);
        });
        // Reorder selected component
        $component_selected = $component_selected->sortBy(function ($item) use ($component_setting) {
            return array_search($item->id, $component_setting);
        });

        $this->responseData['component_selected'] = $component_selected;

        return $this->responseView($this->viewPart . '.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Widget  $widget
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Widget $widget)
    {
        $request->validate([
            'title' => 'required|max:255',
            'widget_code' => 'required|max:255'
        ]);
        $params = $request->all();

        $params['admin_updated_id'] = Auth::guard('admin')->user()->id;
        $components_content = json_decode($params['output_selected']);
        $arr_components = [];
        if(!empty($components_content) && count($components_content) > 0){
            foreach($components_content as $val){
                if(!isset($val->id)){continue;}
                $arr_components[] =$val->id;
            }
        }
        $params['json_params']['component'] = $arr_components;
        unset($params['output_selected']);
        unset($params['output_available']);
        $widget->fill($params);
        $widget->save();

        return redirect()->back()->with('successMessage', __('Successfully updated!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Widget  $widget
     * @return \Illuminate\Http\Response
     */
    public function destroy(Widget $widget)
    {
        // Update status to delete
        $widget->status = Consts::STATUS_DELETE;
        $widget->save();

        // Delete sub
        // DB::table('tb_widgets')->where('parent_id', '=', $widget->id)->update(['status' => Consts::STATUS_DELETE]);

        return redirect()->back()->with('successMessage', __('Delete record successfully!'));
    }
    public function loadStatus($id)
    {
        // dd($this->widget);
        $widget   =  $this->widget->find($id);
        $status = $widget->status;
        if ($status=="active") {
            $statusUpdate = 'deactive';
        } else {
            $statusUpdate = 'active';
        }
        $updateResult =  $widget->update([
            'status' => $statusUpdate,
        ]);
        // dd($updateResult);
        $widget   =  $this->widget->find($id);
        if ($updateResult) {
            return response()->json([
                "code" => 200,
                "html" => view('admin.components.load-change-status', ['data' => $widget, 'type' => 'thuộc tính'])->render(),
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
