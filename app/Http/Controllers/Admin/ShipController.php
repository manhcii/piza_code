<?php

namespace App\Http\Controllers\Admin;

use App\Models\Ship;
use App\Models\CountryModel;
use Illuminate\Http\Request;
use App\Consts;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class ShipController extends Controller
{
    public function __construct()
    {

        $this->routeDefault  = 'ship';
        $this->viewPart = 'admin.pages.ship';
        $this->responseData['module_name'] = __('Ship Management');
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
        $this->responseData['rows'] =  Ship::select('tb_cms_ships.*')->selectRaw('countries.name AS country_name')
            ->leftJoin('countries', 'tb_cms_ships.country_id', '=', 'countries.id')->groupBy('country_id')->get();

        $list_country_ext=[];
        foreach ($this->responseData['rows'] as $key => $value) {
                array_push($list_country_ext,$value->country_id);
        }  
        
        $country = CountryModel::all();
        $this->responseData['country'] = $country;
        //Country exist
        $this->responseData['list_country_ext'] = $list_country_ext;

        return $this->responseView($this->viewPart . '.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'country_id' => 'required',
            'name' => 'required',
            'type' => 'required',
            'shipping_fee' => 'required',
            'value_from' => 'required',
        ]);

        $params = $request->all();
        $params['status']=Consts::STATUS['active'];
        
        $cmsProduct = Ship::create($params);
        return redirect()->back()->with('successMessage', __('Add new successfully!'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ship  $ship
     * @return \Illuminate\Http\Response
     */
    public function show(Ship $ship)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ship  $ship
     * @return \Illuminate\Http\Response
     */
    public function edit(Ship $ship)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ship  $ship
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $request->validate([
            'country_id' => 'required',
            'name' => 'required',
            'type' => 'required',
            'shipping_fee' => 'required',
            'value_from' => 'required',
        ]);
        $params = $request->all();

        $ship = Ship::find($id);
        $ship->update($request->all());

        return redirect()->back()->with('successMessage', __('Successfully updated!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ship  $ship
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ship $ship)
    {
        $id = request('id');
        $rule = request('rule');
        if($rule=='country') $res=ship::where('country_id',$id)->delete();
        else $res=ship::where('id',$id)->delete();
        return response()->json(['error' => 0, 'msg' => 'Deleted successfully']);
    }

}
