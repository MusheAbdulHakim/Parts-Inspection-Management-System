<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\WorkInstruction;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class WorkInstructionController extends Controller
{

    public function __construct(){
        $this->middleware(['role_or_permission:super-admin|view-workInstructions|create-workInstruction|edit-workInstruction|destroy-workInstruction']);
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
            $work_instructions = WorkInstruction::get();
            return DataTables::of($work_instructions)
                    ->addIndexColumn()
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
                        $editbtn = '<a href="'.route('work-instructions.edit',$row->id).'" class="edit"><button class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button></a>';
                        $deletebtn = '<a data-id="'.$row->id.'" data-route="'.route('work-instructions.destroy',$row->id).'" href="javascript:void(0)" id="deletebtn"><button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button></a>';
                        if(!can('edit-workInstruction')){
                            $editbtn = '';
                        }
                        if(!can('destroy-workInstruction')){
                            $deletebtn = '';
                        }
                        $btn = $editbtn.' '.$deletebtn;
                        return $btn;
                    })
                    ->rawColumns(['action','preview'])
                    ->make(true);
        }

        return view('admin.work-instructions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.work-instructions.create');
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
            'revision' => 'required',
            'filepath' => 'required'
        ]);

        WorkInstruction::create([
            'name' => $request->name,
            'revision' => $request->revision,
            'files' => $request->filepath
        ]);
        $notification = notify("Working files has been added");
        return redirect()->route('work-instructions.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WorkInstruction $work_instruction
     * @return \Illuminate\Http\Response
     */
    public function show($work_instruction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WorkInstruction $work_instruction
     * @return \Illuminate\Http\Response
     */
    public function edit(WorkInstruction $work_instruction)
    {
        return view('admin.work-instructions.edit',compact(
            'work_instruction'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WorkInstruction $work_instruction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WorkInstruction $work_instruction)
    {
        $request->validate([
            'name' => 'required',
            'revision' => 'required',
            'filepath' => 'required'
        ]);
        $work_instruction->update([
            'name' => $request->name,
            'revision' => $request->revision,
            'files' => $request->filepath
        ]);
        $notification = notify("Working files has been updated");
        return redirect()->route('work-instructions.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return WorkInstruction::findOrFail($request->id)->delete();
    }
}
