<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\Calibration;
use App\Models\InspectionTool;

class InspectionToolController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role_or_permission:super-admin|view-inspectionTools|create-inspectionTool|edit-inspectionTool|destroy-inspectionTool']);
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
            $tools = InspectionTool::get();
            return DataTables::of($tools)
                    ->addIndexColumn()
                    ->addColumn('calibration', function($row){
                        return $row->calibration->first()->status ?? 'INVALID';
                    })
                    ->addColumn('tool', function($row){
                        return $row->tool_id ?? '';
                    })
                    ->addColumn('created_at',function($row){
                        return date_format(date_create($row->created_at),'d M Y');
                    })
                    ->addColumn('action',function ($row){
                        $editbtn = '<a data-id="'.$row->id.'" data-name="'.$row->name.'" href="javascript:void(0)" class="edit"><button class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button></a>';
                        $deletebtn = '<a data-id="'.$row->id.'" data-route="'.route('inspection-tools.destroy',$row->id).'" href="javascript:void(0)" id="deletebtn"><button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button></a>';
                        if(!can('edit-inspectionTool')){
                            $editbtn = '';
                        }
                        if(!can('destroy-inspectionTool')){
                            $deletebtn = '';
                        }
                        $btn = $editbtn.' '.$deletebtn;
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        $calibrations = Calibration::get();
        return view('admin.inspection-tools.index',compact(
            'calibrations'
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
            'name' => 'required|min:3|max:255|unique:inspection_tools,name'
        ]);
        InspectionTool::create([
            'tool_id' => $request->tool_id,
            'name' => $request->name,
            'calibration_id' => $request->calibration,
            'description' => $request->description
        ]);
        $notification = notify("Inspection tool has been created");
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
        return response()->json(InspectionTool::findOrFail($id));
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
            'name' => 'required|min:3|max:255'
        ]);
        InspectionTool::findOrFail($request->id)->update([
            'tool_id' => $request->tool_id,
            'name' => $request->name,
            'calibration_id' => $request->calibration,
            'description' => $request->description
        ]);
        $notification = notify("Inspection tool has been updated");
        return back()->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return InspectionTool::findOrFail($request->id)->delete();
    }
}
