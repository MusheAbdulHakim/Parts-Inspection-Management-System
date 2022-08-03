<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Settings\GeneralSettings;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
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
        $logo = '';
        if($request->hasFile('logo')){
            $logo = time().'.'.$request->logo->extension();
            $request->logo->move(public_path('storage/settings/general'), $logo);
        }
        $favicon = '';
        if($request->hasFile('favicon')){
            $favicon = time().'.'.$request->favicon->extension();
            $request->favicon->move(public_path('storage/settings/general'), $favicon);
        }
        $settings->logo = $logo;
        $settings->favicon = $favicon;
        $settings->site_active = ($request->site_active == 'on' ? true: false);
        $settings->currency = $request->currency ?? '';
        $settings->save();
        $notification = notify('Settings has been updated');
        return back()->with($notification);
    }
}
