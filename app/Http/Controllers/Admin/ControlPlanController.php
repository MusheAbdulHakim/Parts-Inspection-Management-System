<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BinaryFeature;
use App\Models\ControlPlan;
use App\Models\Feature;
use App\Models\GaugeFeature;
use App\Models\NumberFeature;
use App\Models\WorkInstruction;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

use function PHPSTORM_META\map;

class ControlPlanController extends Controller
{

    public function __construct(){
        $this->middleware(['role_or_permission:super-admin|view-controlPlans|create-controlPlan|edit-controlPlan|destroy-controlPlan']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $plans = ControlPlan::get();
            return DataTables::of($plans)
                ->addIndexColumn()
                ->addColumn('feature', function($row){
                    $names = array_map(function($feature){
                        return Feature::find($feature)->name ?? null;
                    }, $row->features);
                    return implode(',', $names);
                })
                ->addColumn('feature_type', function($row){
                    return $row->feature->type ?? '';
                })
                ->addColumn('work', function($row){
                    return $row->workInstruction->name ?? '';
                })
                ->addColumn('created_at',function($row){
                    return date_format(date_create($row->created_at),'d M Y');
                })
                ->addColumn('action',function ($row){
                    $editbtn = '<a data-id="'.$row->id.'" href="javascript:void(0)" class="edit"><button class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button></a>';
                    $deletebtn = '<a data-id="'.$row->id.'" data-route="'.route('control-plans.destroy',$row->id).'" href="javascript:void(0)" id="deletebtn"><button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button></a>';
                    if(!can('edit-controlPlan')){
                        $editbtn = '';
                    }
                    if(!can('destroy-controlPlan')){
                        $deletebtn = '';
                    }
                    $btn = $editbtn.' '.$deletebtn;
                    return $btn;
                })
                ->rawColumns(['action','description'])
                ->make(true);
        }
        $features = Feature::get();
        $work_instructions = WorkInstruction::get();
        return view('admin.control-plans.index',compact(
            'features','work_instructions'
        ));
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
            'feature' => 'required',
            'work' => 'required',
        ],[
            'work.required' => 'Please select work instruction'
        ]);
        ControlPlan::create([
            'name' => $request->name,
            'features' => $request->feature,
            'work_instruction_id' => $request->work
        ]);
        $notification = notify("Control plan has been added");
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
        return response()->json(ControlPlan::findOrFail($id));
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
            'work' => 'required',
        ],[
            'work.required' => 'Please select work instruction'
        ]);
        ControlPlan::findOrFail($request->id)->update([
            'name' => $request->name,
            'features' => $request->feature,
            'work_instruction_id' => $request->work
        ]);
        $notification = notify("Control plan has been added");
        return back()->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return ControlPlan::findOrFail($request->id)->delete();
    }
}
