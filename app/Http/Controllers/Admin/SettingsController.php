<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BusinessSetting;
use App\Models\SMTPSetting;
use App\Models\SmsSetting;
use App\Models\NotificationSetting;

class SettingsController extends Controller
{
    private $settingID = 1;

    function index()
    {
        $settings = Setting::where('id', $this->settingID)->first();
        return view('admin.modules.settings.business', compact('settings'));
    }

    function update_settings(Request $request)
    {
        $request->validate([
            'name' => 'nullable|max:50|min:3',
            'email' => 'nullable|email',
            'distance_unit' => 'nullable|max:10',
        ]);


        BusinessSetting::updateOrCreate(['id' => $this->settingID], $request->except('_token'));
        notify()->success('Settings updated successfully!');
        return redirect()->back();
    }
}
