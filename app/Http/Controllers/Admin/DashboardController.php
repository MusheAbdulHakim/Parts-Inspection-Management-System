<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Inspection;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(){
        $pageConfigs = ['pageHeader' => false];
        $users_count = User::count();
        $pageConfigs = ['pageHeader' => false];
        $mon = Inspection::whereRaw('WEEKDAY(inspections.created_at) = 0')->count();
        $tue = Inspection::whereRaw('WEEKDAY(inspections.created_at) = 1')->count();
        $wed = Inspection::whereRaw('WEEKDAY(inspections.created_at) = 2')->count();
        $thur = Inspection::whereRaw('WEEKDAY(inspections.created_at) = 3')->count();
        $fri = Inspection::whereRaw('WEEKDAY(inspections.created_at) = 4')->count();
        $sat = Inspection::whereRaw('WEEKDAY(inspections.created_at) = 5')->count();
        $sun = Inspection::whereRaw('WEEKDAY(inspections.created_at) = 6')->count();
        $todayInspections = Inspection::whereDate('created_at',Carbon::now())->count();
        $months = [];
        $months[1] = Inspection::whereMonth('created_at',1)->count();
        $months[2] = Inspection::whereMonth('created_at',2)->count();
        $months[3] = Inspection::whereMonth('created_at',3)->count();
        $months[4] = Inspection::whereMonth('created_at',4)->count();
        $months[5] = Inspection::whereMonth('created_at',5)->count();
        $months[6] = Inspection::whereMonth('created_at',6)->count();
        $months[7] = Inspection::whereMonth('created_at',7)->count();
        $months[8] = Inspection::whereMonth('created_at',8)->count();
        $months[9] = Inspection::whereMonth('created_at',9)->count();
        $months[10] = Inspection::whereMonth('created_at',10)->count();
        $months[11] = Inspection::whereMonth('created_at',11)->count();
        $months[12] = Inspection::whereMonth('created_at',12)->count();
        return view('admin.dashboard',compact(
            'pageConfigs','users_count','months','mon','tue','wed','thur','fri','sat','sun','todayInspections'
        ));
    }
}
