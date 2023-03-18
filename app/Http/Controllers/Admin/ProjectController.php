<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role_or_permission:super-admin|view-projects|create-project|edit-project|destroy-project']);
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
            $projects = Project::get();
            return DataTables::of($projects)
                    ->addIndexColumn()
                    ->addColumn('created_at',function($row){
                        return date_format(date_create($row->created_at),'d M Y');
                    })
                    ->addColumn('action',function ($row){
                        $editbtn = '<a data-id="'.$row->id.'" data-customer="'.$row->customer.'" data-name="'.$row->name.'" href="javascript:void(0)" class="edit"><button class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button></a>';
                        $deletebtn = '<a data-id="'.$row->id.'" data-route="'.route('projects.destroy',$row->id).'" href="javascript:void(0)" id="deletebtn"><button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button></a>';
                        if(!can('edit-project')){
                            $editbtn = '';
                        }
                        if(!can('destroy-project')){
                            $deletebtn = '';
                        }
                        $btn = $editbtn.' '.$deletebtn;
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('admin.projects.index');
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
            'customer' => 'required',
        ]);
        Project::create([
            'name' => $request->name,
            'customer' => $request->customer,
        ]);
        $notification = notify("Project has been added");
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
            'customer' => 'required',
        ]);
        Project::findOrFail($request->id)->update([
            'name' => $request->name,
            'customer' => $request->customer,
        ]);
        $notification = notify("Project has been updated");
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
        return Project::findOrFail($request->id)->delete();
    }
}
