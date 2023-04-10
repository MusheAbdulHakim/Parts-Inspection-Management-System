<?php

namespace App\Http\Controllers\Admin;

use App\Models\Calibration;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\InspectionTool;

class CalibrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $calibrations = Calibration::get();
            return DataTables::of($calibrations)
                ->addIndexColumn()
                ->addColumn('tool', function($row){
                    return $row->inspectionTool->name ?? '';
                })
                ->addColumn('interval', function($row){
                    return ($row->from_.' to '.$row->to_);
                })
                ->addColumn('cert', function($row){
                    if(!empty($row->certificate)){
                        return '<a target="_blank" href="'.$row->certificate.'" class="edit">Preview</a>';
                    }
                })
                ->addColumn('preview', function($row){
                    if(!empty($row->certificate)){
                        return '<a data-input="thumbnail" data-preview="holder" class="btn btn-primary filemanager">
                        <i data-feather="eye"></i> Preview
                        </a>';
                    }
                })
                ->addColumn('docs', function($row){
                    return $row->files;
                })
                ->addColumn('created_at',function($row){
                    return date_format(date_create($row->created_at),'d M Y');
                })
                ->addColumn('action',function ($row){
                    $editbtn = '<a href="'.route('calibrations.edit',$row->id).'" class="edit"><button class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button></a>';
                    $deletebtn = '<a data-id="'.$row->id.'" data-route="'.route('calibrations.destroy',$row->id).'" href="javascript:void(0)" id="deletebtn"><button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button></a>';
                    if(!can('edit-calibration')){
                        $editbtn = '';
                    }
                    if(!can('destroy-calibration')){
                        $deletebtn = '';
                    }
                    $btn = $editbtn.' '.$deletebtn;
                    return $btn;
                })
                ->rawColumns(['action','cert','preview'])
                ->make(true);
        }
        return view('admin.calibration.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tools = InspectionTool::get();
        return view('admin.calibration.create',compact(
            'tools'
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
            'calib_id' => 'required|string',
            'calibrationfile' => 'nullable',
            'date_' => 'required|date',
            'interval' => 'required',
            'description' => 'nullable'
        ]);

        $interval = explode('to', $request->interval);
        $calib_interval = getFullMonthsBetweenDates(Date('Y-m-d'),$request->date_);
        $interval_months = getFullMonthsBetweenDates($interval[0],$interval[1]);
        Calibration::create([
            'inspection_tool_id' => $request->tool,
            'calib_id' => $request->calib_id,
            'certificate' => $request->calibrationfile,
            'date_' => $request->date_,
            'from_' => $interval[0],
            'to_' => $interval[1],
            'status' => ($calib_interval < $interval_months) ? 'VALID': 'INVALID',
        ]);
        $notification = notify("Calibration has been added");
        return redirect()->route('calibrations.index')->with($notification);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Calibration $calibration
     * @return \Illuminate\Http\Response
     */
    public function show(Calibration $calibration)
    {
       return response()->json($calibration);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Calibration $calibration
     * @return \Illuminate\Http\Response
     */
    public function edit(Calibration $calibration)
    {
        $tools = InspectionTool::get();
        return view('admin.calibration.edit',compact(
            'calibration','tools'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Calibration $calibration
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Calibration $calibration)
    {
        $request->validate([
            'calib_id' => 'required|string',
            'calibrationfile' => 'nullable',
            'date_' => 'required|date',
            'interval' => 'required',
        ]);
        $interval = explode('to', $request->interval);
        $calib_interval = getFullMonthsBetweenDates(Date('Y-m-d'),$request->date_);
        $interval_months = getFullMonthsBetweenDates($interval[0],$interval[1]);
        $calibration->update([
            'inspection_tool_id' => $request->tool ?? $calibration->inspection_tool_id,
            'calib_id' => $request->calib_id ?? $calibration->calib_id,
            'certificate' => $request->calibrationfile ?? $calibration->certificate,
            'date_' => $request->date_ ?? $calibration->date_,
            'from_' => $interval[0] ?? $calibration->from_,
            'to_' => $interval[1] ?? $calibration->to_,
            'status' => ($calib_interval < $interval_months) ? 'VALID': 'INVALID',
        ]);
        $notification = notify("Calibration has been updated");
        return redirect()->route('calibrations.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return Calibration::findOrFail($request->id)->delete();
    }
}
