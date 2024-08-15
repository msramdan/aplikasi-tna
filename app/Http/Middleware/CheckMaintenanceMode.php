<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\SettingApp; // Model untuk tabel setting_apps

class CheckMaintenanceMode
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
        $setting = SettingApp::where('id', 1)->first(); // Misalkan kita hanya punya satu record

        if ($setting && $setting->is_maintenance === 'Yes') {
            // Redirect ke halaman maintenance
            return redirect()->route('maintenance');
        }

        return $next($request);
    }
}
