<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

function set_show($uri)
{
    if (is_array($uri)) {
        foreach ($uri as $u) {
            if (Route::is($u)) {
                return 'show';
            }
        }
    } else {
        if (Route::is($uri)) {
            return 'show';
        }
    }
}

if (!function_exists('set_active')) {
    function set_active($uri)
    {
        if (is_array($uri)) {
            foreach ($uri as $u) {
                if (Route::is($u)) {
                    return 'active';
                }
            }
        } else {
            if (Route::is($uri)) {
                return 'active';
            }
        }
    }
}

function setting_web()
{
    $setting = DB::table('setting_apps')->first();
    return $setting;
}
