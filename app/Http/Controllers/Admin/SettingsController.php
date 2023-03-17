<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Settings\GeneralSettings;
use Illuminate\Http\Request;

class SettingsController extends Controller
{

    public function __construct(){
        $this->middleware(['role_or_permission:super-admin|view-settings']);
    }

    public function index(GeneralSettings $settings){
        $pageConfigs = ['pageHeader' => false];
        return view('admin.settings.general',compact(
            'pageConfigs','settings'
        ));
    }

    /**
     * updateGeneralSettings
     * @param \Illuminate\Http\Request $request
     */
    public function updateGeneralSettings(Request $request,GeneralSettings $settings){
        $request->validate([
            'logo' => 'nullable|file|image',
            'favicon' => 'nullable|file|image',
        ]);
        $logo = $settings->logo;
        if($request->hasFile('logo')){
            $logo = 'logo_'.time().'.'.$request->logo->extension();
            $request->logo->move(public_path('storage/settings/general'), $logo);
        }
        $favicon = $settings->favicon;
        if($request->hasFile('favicon')){
            $favicon = 'favicon_'.time().'.'.$request->favicon->extension();
            $request->favicon->move(public_path('storage/settings/general'), $favicon);
        }
        $settings->logo = $logo;
        $settings->favicon = $favicon;
        $settings->currency = $request->currency ?? '';
        $settings->save();
        $notification = notify('Settings has been updated');
        return back()->with($notification);
    }
}
