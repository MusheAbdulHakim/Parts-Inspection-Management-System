<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $pageConfigs = ['pageHeader' => false];
        $users_count = User::count();
        return view('admin.dashboard',compact(
            'pageConfigs','users_count'
        ));
    }
}
