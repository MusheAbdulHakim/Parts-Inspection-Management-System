<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\GaugeFeature;

class GaugeFeatureController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role_or_permission:super-admin|view-gaugeFeatures|create-gaugeFeature|edit-gaugeFeature|destroy-gaugeFeature']);
    }


    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()){
            $features = GaugeFeature::get();
            return DataTables::of($features)
                    ->addIndexColumn()
                    ->addColumn('bool', function($row){
                        return ($row->bool == 1) ? 'True': 'False';
                    })
                    ->addColumn('created_at',function($row){
                        return date_format(date_create($row->created_at),'d M Y');
                    })
                    ->addColumn('action',function ($row){
                        $editbtn = '<a data-id="'.$row->id.'" href="javascript:void(0)" class="edit"><button class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button></a>';
                        $deletebtn = '<a data-id="'.$row->id.'" data-route="'.route('gauge-features.destroy',$row->id).'" href="javascript:void(0)" id="deletebtn"><button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button></a>';
                        if(!can('edit-gaugeFeature')){
                            $editbtn = '';
                        }
                        if(!can('destroy-gaugeFeature')){
                            $deletebtn = '';
                        }
                        $btn = $editbtn.' '.$deletebtn;
                        return $btn;
                    })
                    ->rawColumns(['action','description'])
                    ->make(true);
        }
        return view('admin.features.gauge');
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
            'name' => 'required|unique:binary_features,name',
            'bool' => 'required|boolean',
            'description' => 'nullable|string'
        ]);
        GaugeFeature::create([
            'name' => $request->name,
            'bool' => $request->bool,
            'description' => $request->description
        ]);
        $notification = notify("Gauge feature has been created");
        return back()->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(GaugeFeature::findOrFail($id));
    }

   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'bool' => 'required|boolean',
            'description' => 'nullable|string'
        ]);
        GaugeFeature::findOrFail($request->id)->update([
            'name' => $request->name,
            'bool' => $request->bool,
            'description' => $request->description
        ]);
        $notification = notify("Gauge feature has been updated");
        return back()->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return GaugeFeature::findOrFail($request->id)->delete();
    }
}
