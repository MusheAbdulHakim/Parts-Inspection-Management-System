<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\NumberFeature;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class NumberFeatureController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role_or_permission:super-admin|view-numberFeatures|create-numberFeature|edit-numberFeature|destroy-numberFeature']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request  $request)
    {
        if ($request->ajax()){
            $features = NumberFeature::get();
            return DataTables::of($features)
                    ->addIndexColumn()
                    ->addColumn('created_at',function($row){
                        return date_format(date_create($row->created_at),'d M Y');
                    })
                    ->addColumn('action',function ($row){
                        $editbtn = '<a data-id="'.$row->id.'" data-name="'.$row->name.'" data-target="'.$row->target.'" data-upper="'.$row->upper_limit.'" data-lower="'.$row->lower_limit.'" data-description="'.$row->description.'" href="javascript:void(0)" class="edit"><button class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button></a>';
                        $deletebtn = '<a data-id="'.$row->id.'" data-route="'.route('number-features.destroy',$row->id).'" href="javascript:void(0)" id="deletebtn"><button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button></a>';
                        if(!can('edit-numberFeature')){
                            $editbtn = '';
                        }
                        if(!can('destroy-numberFeature')){
                            $deletebtn = '';
                        }
                        $btn = $editbtn.' '.$deletebtn;
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('admin.features.numerical');
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
            'target' => 'nullable|numeric',
            'upper_limit' => 'nullable|numeric',
            'lower_limit' => 'nullable|numeric',
            'description' => 'nullable|max:255'
        ]);
        
        NumberFeature::create([
            'name' => $request->name,
            'target' => $request->target,
            'upper_limit' => $request->upper_limit,
            'lower_limit' => $request->lower_limit,
            'description' => $request->description
        ]);
        $notification = notify('Number feature has been created');
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
        //
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
            'target' => 'nullable|numeric',
            'upper_limit' => 'nullable|numeric',
            'lower_limit' => 'nullable|numeric',
            'description' => 'nullable|max:255'
        ]);
        
        NumberFeature::findOrFail($request->id)->update([
            'name' => $request->name,
            'target' => $request->target,
            'upper_limit' => $request->upper_limit,
            'lower_limit' => $request->lower_limit,
            'description' => $request->description
        ]);
        $notification = notify('Number feature has been updated');
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
        return NumberFeature::findOrFail($request->id)->delete();
    }
}
