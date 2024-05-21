<?php

namespace App\Providers;

use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Http;
use Spatie\Permission\Models\Role;



class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function boot()
    {
        Fortify::authenticateUsing(function (Request $request) {
            $request->validate([
                'username' => 'required',
                'password' => 'required',
                'g-recaptcha-response' => 'required|captcha',
            ]);
            $endpointStara = config('stara.endpoint') . '/auth/login';
            $response = Http::post($endpointStara, [
                'username' => $request->username,
                'password' => $request->password,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $user = User::where('user_nip', $data['data']['user_info']['user_nip'])->first();
                if (!$user) {
                    $user = User::create([
                        'user_nip' => $data['data']['user_info']['user_nip'],
                        'name' =>  $data['data']['user_info']['name'],
                        'phone' =>  $data['data']['user_info']['nomorhp'],
                        'email' =>  $data['data']['user_info']['email'],
                        'jabatan' =>  $data['data']['user_info']['jabatan'],
                        'nama_unit' =>  $data['data']['user_info']['namaunit']
                    ]);
                    $role = Role::where('id', 3)->first();
                    if ($role) {
                        $user->assignRole($role);
                    } else {
                        dd('Role not found');
                    }
                }
                return $user;
            }
            throw ValidationException::withMessages([
                Fortify::username() => [trans('auth.failed')],
            ]);
        });

        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(10)->by($request->username . $request->ip());
        });

        Fortify::loginView(function () {
            return view('auth.login');
        });
    }
}
