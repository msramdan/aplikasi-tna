<?php

namespace App\Http\Controllers;

use App\Models\SettingApp;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ConfigStepReview extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('permission:config step review view')->only('index');
    //     $this->middleware('permission:config step review edit')->only('update');
    // }

    public function index()
    {
        $settingApp = SettingApp::findOrFail(1)->first();
        $users = User::orderBy('name', 'ASC')->get();
        return view('config-step-review.edit', compact('settingApp', 'users'));
    }
}
