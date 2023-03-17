<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SerialNumber;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SerialNumberController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role_or_permission:super-admin|view-serialnumbers|create-serialnumber|edit-serialnumber|destroy-serialnumber']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()){
            $serialnumbers = SerialNumber::get();
            return DataTables::of($serialnumbers)
                    ->addIndexColumn()
                    ->addColumn('created_at',function($row){
                        return date_format(date_create($row->created_at),'d M Y');
                    })
                    ->addColumn('action',function ($row){
                        $editbtn = '<a data-id="'.$row->id.'" data-name="'.$row->name.'" href="javascript:void(0)" class="edit"><button class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button></a>';
                        $deletebtn = '<a data-id="'.$row->id.'" data-route="'.route('serialnumbers.destroy',$row->id).'" href="javascript:void(0)" id="deletebtn"><button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button></a>';
                        if(!can('edit-serialnumber')){
                            $editbtn = '';
                        }
                        if(!can('destroy-serialnumber')){
                            $deletebtn = '';
                        }
                        $btn = $editbtn.' '.$deletebtn;
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('admin.serialnumbers.index');
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
            'serialnumber' => 'required|min:3|max:255|unique:serial_numbers,name'
        ]);
        foreach (explode(',',trim($request->serialnumber)) as $sn){
            SerialNumber::create(['name' => $sn]);
        }
        $notification = notify("Serial Number has been created");
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
            'serialnumber' => 'required|min:3|max:255'
        ]);
        SerialNumber::findOrFail($request->id)->update(['name' => $request->serialnumber]);
        $notification = notify("Serial Number has been updated");
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
        return SerialNumber::findOrFail($request->id)->delete();
    }
}
