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
        $setting_app = SettingApp::findOrFail($id);
        if ($request->file('logo') != null || $request->file('logo') != '') {
            Storage::disk('local')->delete('public/img/setting_app/' . $setting_app->logo);
            $logo = $request->file('logo');
            $logo->storeAs('public/img/setting_app', $logo->hashName());
            $setting_app->update([
                'logo'     => $logo->hashName(),
            ]);
        }

        if ($request->file('favicon') != null || $request->file('favicon') != '') {
            Storage::disk('local')->delete('public/img/setting_app/' . $setting_app->favicon);
            $favicon = $request->file('favicon');
            $favicon->storeAs('public/img/setting_app', $favicon->hashName());
            $setting_app->update([
                'favicon'     => $favicon->hashName(),
            ]);
        }

        $setting_app->update([
            'aplication_name' => $request->aplication_name,
        ]);

        Alert::toast('The settingApp was updated successfully.', 'success');
        return redirect()->route('setting-apps.index');
    }
}
