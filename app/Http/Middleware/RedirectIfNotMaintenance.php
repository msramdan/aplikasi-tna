<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\SettingApp;

class RedirectIfNotMaintenance
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Ambil setting dari tabel setting_apps
        $setting = SettingApp::where('id', 1)->first();

        if ($setting && $setting->is_maintenance === 'No') {
            // Redirect ke dashboard jika tidak dalam mode maintenance
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
