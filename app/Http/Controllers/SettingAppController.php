<?php

namespace App\Http\Controllers;

use App\Models\SettingApp;
use App\Http\Requests\{StoreSettingAppRequest, UpdateSettingAppRequest};
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class SettingAppController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:setting app view')->only('index');
        $this->middleware('permission:setting app edit')->only('update');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settingApp = SettingApp::findOrFail(1)->first();
        $users = User::orderBy('name', 'ASC')->get();
        return view('setting-apps.edit', compact('settingApp', 'users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'favicon' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',
        ]);

        $setting_app = SettingApp::findOrFail($id);

        if ($request->hasFile('logo')) {
            Storage::disk('local')->delete('public/img/setting_app/' . $setting_app->logo);
            $logo = $request->file('logo');
            $logo->storeAs('public/img/setting_app', $logo->hashName());
            $setting_app->update(['logo' => $logo->hashName()]);
        }

        if ($request->hasFile('favicon')) {
            Storage::disk('local')->delete('public/img/setting_app/' . $setting_app->favicon);
            $favicon = $request->file('favicon');
            $favicon->storeAs('public/img/setting_app', $favicon->hashName());
            $setting_app->update(['favicon' => $favicon->hashName()]);
        }

        $setting_app->update([
            'aplication_name' => $request->aplication_name,
            'is_maintenance' => $request->is_maintenance,
            'otomatis_sync_info_diklat' => $request->otomatis_sync_info_diklat,
            'reverse_atur_tagging' => $request->reverse_atur_tagging
        ]);

        Alert::toast('Setting aplikasi berhasil diperbarui.', 'success');
        return redirect()->route('setting-apps.index');
    }
}
