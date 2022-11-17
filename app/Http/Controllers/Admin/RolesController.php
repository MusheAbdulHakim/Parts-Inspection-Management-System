<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role_or_permission:super-admin|view-roles|create-role|edit-role|destroy-role']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pageConfigs = ['pageHeader' => false];
        $roles = Role::get();
        $permissions = Permission::get();
        if($request->ajax()){
            return DataTables::of($roles)
                ->addIndexColumn()
                ->addColumn('permissions',function ($role){
                    
                    return array_map(function($permission){
                        return $permission['name'];
                    },$role->getAllPermissions()->toArray());
                })
                ->addColumn('action',function ($row){
                    $editbtn = '<a href="javascript:void(0)" data-id="'.$row->id.'" data-name="'.$row->name.'" data-permissions='.($row->getAllPermissions()->pluck('name')).' class="edit_role"><button class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button></a>';
                    $deletebtn = '<a data-id="'.$row->id.'" data-route="'.route('roles.destroy',$row->id).'" href="javascript:void(0)" id="deletebtn"><button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></a>';
                    if(!can('edit-role')){
                        $editbtn = '';
                    }
                    if(!can('destroy-role')){
                        $deletebtn = '';
                    }
                    $btn = $editbtn.' '.$deletebtn;
                    return $btn;
                })
                ->rawColumns(['action','permissions'])
                ->make(true);
        }
        return view('admin.roles.index',compact(
            'pageConfigs','roles','permissions'
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
        $this->validate($request,[
            'role' => 'required|min:3|max:255',
            'permission' => 'required',
        ]);
        $role = Role::create(['name' => $request->role]);
        $role->syncPermissions($request->permission);
        $notification = notify('role created successfully');
        return redirect()->route('roles.index')->with($notification);
    }

   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request,[
            'role' => 'required|min:3|max:255',
            'permission' => 'required'
        ]);
        $role = Role::findOrFail($request->id);
        $role->update([
            'name' => $request->role,
        ]);
        $role->syncPermissions($request->permission);
        return redirect()->route('roles.index')->with(notify('Role updated successfully'));
    }

    public function userPermissions(Request $request){
        if($request->ajax()){
            $user_permissions = User::with('permissions')->get();
            return DataTables::of($user_permissions)
                ->addIndexColumn()
                ->addColumn('user', function($row){
                    return $row->name;
                })
                ->addColumn('permissions',function ($user){
                    return array_map(function($permission){
                        return $permission['name'];
                    },$user->getAllPermissions()->toArray());
                })
                ->addColumn('action',function ($row){
                    $editbtn = '<a href="javascript:void(0)" data-id="'.$row->id.'" data-user="'.$row->id.'" data-permissions='.($row->getAllPermissions()->pluck('name')).' class="edit"><button class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button></a>';
                    if(!can('edit-role')){
                        $editbtn = '';
                    }
                    $btn = $editbtn;
                    return $btn;
                })
                ->rawColumns(['action','permissions'])
                ->make(true);
        }
        $users = User::get();
        $permissions = Permission::get();
        return view('admin.roles.user-permissions',compact(
            'users','permissions'
        ));
    }

    public function updateUserPermissions(Request $request){
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return Role::findOrFail($request->id)->delete();
    }
}
