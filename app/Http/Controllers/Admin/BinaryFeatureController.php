<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\BinaryFeature;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class BinaryFeatureController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role_or_permission:super-admin|view-binaryFeatures|create-binaryFeature|edit-binaryFeature|destroy-binaryFeature']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()){
            $features = BinaryFeature::get();
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
                        $deletebtn = '<a data-id="'.$row->id.'" data-route="'.route('binary-features.destroy',$row->id).'" href="javascript:void(0)" id="deletebtn"><button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button></a>';
                        if(!can('edit-binaryFeature')){
                            $editbtn = '';
                        }
                        if(!can('destroy-binaryFeature')){
                            $deletebtn = '';
                        }
                        $btn = $editbtn.' '.$deletebtn;
                        return $btn;
                    })
                    ->rawColumns(['action','description'])
                    ->make(true);
        }
        
        return view('admin.features.binary');
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
        BinaryFeature::create([
            'name' => $request->name,
            'bool' => $request->bool,
            'description' => $request->description
        ]);
        $notification = notify("Binary feature has been created");
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
        return response()->json(BinaryFeature::findOrFail($id));
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
            'description' => 'nullable|string',
            'bool' => 'required|boolean'
        ]);
        BinaryFeature::findOrFail($request->id)->update([
            'name' => $request->name,
            'bool' => $request->bool,
            'description' => $request->description
        ]);
        $notification = notify("Binary feature has been updated");
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
        return BinaryFeature::findOrFail($request->id)->delete();
    }
}
