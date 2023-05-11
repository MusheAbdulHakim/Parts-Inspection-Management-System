<?php

namespace App\Http\Controller\Admin;

use App\Models\Product;
use App\Models\Inspection;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class InspectionController extends Controller
{
    public function __construct(){
        $this->middleware(['role_or_permission:super-admin|view-inspections|create-inspection|edit-inspection|show-inspection|destroy-inspection']);
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
            $inspections = Inspection::get();
            return DataTables::of($inspections)
                ->addIndexColumn()
                ->addColumn('project', function($row){
                    $product = Product::where('part_no', $row->partnumber)->first();
                    return $product->project->name ?? '';
                })
                ->addColumn('plan', function($row){
                    $product = Product::where('part_no', $row->partnumber)->first();
                    return $product->controlPlan->name ?? '';
                })
                ->addColumn('created_at',function($row){
                    return date_format(date_create($row->created_at),'d M Y');
                })
                ->addColumn('action',function ($row){
                    $editbtn = '<a href="'.route('inspections.edit',$row->id).'" class="edit"><button class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button></a>';
                    $showbtn = '<a href="'.route('inspections.show',$row->id).'" class="show"><button class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></button></a>';
                    $deletebtn = '<a data-id="'.$row->id.'" data-route="'.route('inspections.destroy',$row->id).'" href="javascript:void(0)" id="deletebtn"><button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button></a>';
                    if(!can('edit-inspection')){
                        $editbtn = '';
                    }
                    if(!can('show-inspection')){
                        $showbtn = '';
                    }
                    if(!can('destroy-inspection')){
                        $deletebtn = '';
                    }
                    $btn = $editbtn.' '.$showbtn.' '.$deletebtn;
                    return $btn;
                })
                ->rawColumns(['action','preview'])
                ->make(true);
        }
        return view('admin.inspection.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageConfigs = ['pageHeader' => false];
        return view('admin.inspection.create', compact(
            'pageConfigs'
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
            'partnumber' => 'required',
            'batch_no' => 'required',
            'quantity' => 'required',
            'measure_value' => 'required',
        ]);
        $quantity = $request->quantity;
        Inspection::create([
            'partnumber' => $request->partnumber,
            'user_id' => auth()->user()->id,
            'batch_no' => $request->batch_no,
            'quantity' => $quantity,
            'measure_values' => explode(',',$request->measure_value),
            'extra_data' => ['binary_values' => json_decode($request->binary_value)]
        ]);
        $notification = notify("Inspection has been created");
        if($quantity > 1){
            $new_quantity = intval($quantity) - 1;
            Session::put('quantity',$new_quantity);
            return back()->with($notification);
        }else{
            return redirect()->route('inspections.index')->with($notification);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inspection $inspection
     * @return \Illuminate\Http\Response
     */
    public function show(Inspection $inspection)
    {
        $pageConfigs = ['pageHeader' => false];
        return view('admin.inspection.show', compact(
            'inspection','pageConfigs'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inspection $inspection
     * @return \Illuminate\Http\Response
     */
    public function edit(Inspection $inspection)
    {
        $pageConfigs = ['pageHeader' => false];
        return view('admin.inspection.edit',compact(
            'inspection','pageConfigs'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inspection $inspection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inspection $inspection)
    {
        $request->validate([
            'partnumber' => 'required',
            'batch_no' => 'required',
            'quantity' => 'required',
            'measure_value' => 'required',
        ]);
        $inspection->update([
            'partnumber' => $request->partnumber ?? $inspection->partnumber,
            'user_id' => auth()->user()->id,
            'batch_no' => $request->batch_no  ?? $inspection->batch_no,
            'quantity' => $request->quantity ?? $inspection->quantity,
            'measure_values' => explode(',',$request->measure_value) ?? $inspection->measure_values,
            'extra_data' => ['binary_values' => json_decode($request->binary_value)]
        ]);
        $notification = notify("Inspection has been updated");
        return redirect()->route('inspections.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return Inspection::findOrFail($request->id)->delete();
    }
}
