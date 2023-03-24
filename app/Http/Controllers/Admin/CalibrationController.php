<?php

namespace App\Http\Controllers\Admin;

use App\Models\Calibration;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;


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
                ->addColumn('interval', function($row){
                    return ($row->from_.' to '.$row->to_);
                })
                ->addColumn('cert', function($row){
                    return '<a target="_blank" href="'.$row->certificate.'" class="edit">Preview</a>';
                })
                ->addColumn('preview', function($row){
                    return '<a data-input="thumbnail" data-preview="holder" class="btn btn-primary filemanager">
                    <i data-feather="eye"></i> Preview
                    </a>';
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
        return view('admin.calibration.create');
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
            'calibrationfile' => 'nullable',
            'date_' => 'required|date',
            'interval' => 'required',
            'description' => 'nullable'
        ]);
        $interval = explode('to', $request->interval);
        Calibration::create([
            'name' => $request->name,
            'certificate' => $request->calibrationfile,
            'date_' => $request->date_,
            'from_' => $interval[0],
            'to_' => $interval[1]
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
        return view('admin.calibration.edit',compact(
            'calibration'
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
            'name' => 'required',
            'calibrationfile' => 'nullable',
            'date_' => 'required|date',
            'interval' => 'required',
        ]);
        $interval = explode('to', $request->interval);
        $calibration->update([
            'name' => $request->name ?? $calibration->name,
            'certificate' => $request->calibrationfile ?? $calibration->certificate,
            'date_' => $request->date_ ?? $calibration->date_,
            'from_' => $interval[0] ?? $calibration->from_,
            'to_' => $interval[1] ?? $calibration->to_,
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
