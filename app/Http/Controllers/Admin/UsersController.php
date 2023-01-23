<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Jetstream\Jetstream;
use Yajra\DataTables\DataTables;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function __construct(){
        $this->middleware(['role_or_permission:super-admin|view-users|create-user|edit-user|destroy-user']);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $breadcrumbs = [
            ['link' => "users", 'name' => "Users"], ['name' => "Users"]
        ];
        if($request->ajax()){
            $users = User::latest()->get();
            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('active', function($row){
                    $active = ($row->active === 1) ? 'checked': '';
                    return '<div data-user="'.$row->id.'" data-status="'.$row->active.'" class="form-check form-switch update_status">
                    <input type="checkbox" class="form-check-input" name="active" id="activeSwitch" '.$active.' />
                  </div>';
                })
                ->addColumn('avatar',function($user){
                    $src = asset('images/avatars/1.png');
                    if(!empty($user->profile_photo_path)){
                        $src = asset('storage/'.$user->profile_photo_path);
                    }
                    return '<div class="avatar me-1"><img src="'.$src.'" alt="avatar" width="32" height="32" /></div>';
                })
                ->addColumn('role',function($row){
                    $roles = $row->roles->pluck('name')->toArray();
                    return implode(',',$roles);
                })
                ->addColumn('action',function ($user){
                    $editbtn = '<a href="'.route('users.edit',$user->id).'" class="edit"><button class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button></a>';
                    $deletebtn = '<a data-id="'.$user->id.'" data-route="'.route('users.destroy',$user->id).'" href="javascript:void(0)" id="deletebtn"><button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></a>';
                    if(!can('edit-user')){
                        $editbtn = '';
                    }
                    if(!can('destroy-user')){
                        $deletebtn = '';
                    }
                    $btn = $editbtn.' '.$deletebtn;
                    return $btn;
                })
                ->rawColumns(['avatar','active','action'])
                ->make(true);
        }
        return view('admin.users.index');
    }

    public function updateStatus(Request $request){
        if($request->ajax()){
            $user = User::findOrFail($request->user)->update([
                'active' => ($request->status == '1') ? 0: 1,
            ]);
            if($user){
                return response()->json(['type' => 1,'message' => "User status updated successfully"]);
            }else{
                return response()->json(['type' => 0,'message' => "Something went wrong"]);
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumbs = [
            ['link' => "users", 'name' => "Users"], ['name' => "Create Users"]
        ];
        $roles = Role::get();
        return view('admin.users.create',compact(
            'breadcrumbs','roles'
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
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8|max:255'
        ]);
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'active' => !empty($request->active),
            'password' => Hash::make($request->password),
        ]);
        $user->assignRole($request->role);
        $notification = notify('user has been created');
        return redirect()->route('users.index')->with($notification);
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $breadcrumbs = [
            ['link' => "users", 'name' => "Users"], ['name' => "Edit User"]
        ];
        $roles = Role::get();
        return view('admin.users.edit',compact(
            'breadcrumbs','user','roles'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'nullable|confirmed|min:8|max:255'
        ]);

        $password = $user->password;
        if(!empty($request->password) && ($user->password != $request->password)){
            $password = Hash::make($request->password);
        }        
        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $password,
            'active' => !empty($request->active),
        ]);
        foreach($user->getRoleNames() as $userRole){
            $user->removeRole($userRole);
        }
        $user->assignRole($request->role);
        $notification = notify('user has been updated');
        return redirect()->route('users.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return User::findOrFail($request->id)->delete();
    }
}
