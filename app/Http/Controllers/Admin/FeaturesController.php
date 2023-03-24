<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class FeaturesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Iluminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $features = Feature::get();
            return DataTables::of($features)
                ->addIndexColumn()
                ->addColumn('binary', function($row){
                    return ($row->bool == '1') ? 'True': 'False';
                })
                ->addColumn('created_at',function($row){
                    return date_format(date_create($row->created_at),'d M Y');
                })
                ->addColumn('action',function ($row){
                    $editbtn = '<a href="'.route('features.edit',$row->id).'" class="edit"><button class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button></a>';
                    $deletebtn = '<a data-id="'.$row->id.'" data-route="'.route('features.destroy',$row->id).'" href="javascript:void(0)" id="deletebtn"><button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button></a>';
                    if(!can('edit-feature')){
                        $editbtn = '';
                    }
                    if(!can('destroy-feature')){
                        $deletebtn = '';
                    }
                    $btn = $editbtn.' '.$deletebtn;
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.features.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.features.create');
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
            'name' => 'required',
            'feature_type' => 'required'
        ]);
        Feature::create([
            'name' => $request->name,
            'type' => $request->feature_type,
            'target' => $request->target,
            'upper_limit' => $request->upper_limit,
            'lower_limit' => $request->lower_limit,
            'control_method' => $request->control_method,
            'bool' => $request->bool,
            'calibration_id' => $request->calibration,
            'control_tool_id' => $request->tool,
        ]);
        $notification = notify("Feature has been added");
        return redirect()->route('features.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Feature $feature
     * @return \Illuminate\Http\Response
     */
    public function show(Feature $feature)
    {
        return response()->json($feature);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Feature $feature
     * @return \Illuminate\Http\Response
     */
    public function edit(Feature $feature)
    {
        return view('admin.features.edit',compact(
            'feature'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Feature $feature
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Feature $feature)
    {
        $request->validate([
            'name' => 'required',
            'feature_type' => 'required'
        ]);
        $feature->update([
            'name' => $request->name,
            'type' => $request->feature_type,
            'target' => $request->target,
            'upper_limit' => $request->upper_limit,
            'lower_limit' => $request->lower_limit,
            'control_method' => $request->control_method,
            'bool' => $request->bool,
            'calibration_id' => $request->calibration,
            'control_tool_id' => $request->tool,
        ]);
        $notification = notify("Feature has been updated");
        return redirect()->route('features.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return Feature::findOrFail($request->id)->delete();
    }
}
