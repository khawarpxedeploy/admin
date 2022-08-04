<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(){
        $settings = Setting::where('id', 1)->first();
        return view("admin.modules.settings.setting_form", compact('settings'));
    }

    public function store(Request $request, Setting $setting){
        $setting->updateOrCreate(
            ['id' => 1],
            ['shop_charges' => $request->shop_charges]
        );
        if ($request->hasFile('logo')) {
            $sett = Setting::find(1);
            $sett->logo = $request->logo->store('logo', 'public');
            $sett->save();
        }
        notify()->success('Settings updated successfully!');
        return redirect()->back();
    }
}
