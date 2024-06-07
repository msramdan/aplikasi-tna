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
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;


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
            if ($request->session()->has('otp_user_id')) {
                // Verifikasi OTP
                $request->validate([
                    'otp' => 'required|numeric',
                ]);

                $userId = session('otp_user_id');
                $cachedOtp = Cache::get('otp_' . $userId);

                if ($cachedOtp && $cachedOtp == $request->otp) {
                    Cache::forget('otp_' . $userId);
                    session()->forget('otp_user_id');
                    // Log in the user
                    auth()->loginUsingId($userId);
                    return User::find($userId);
                } else {
                    throw ValidationException::withMessages([
                        'otp' => ['The provided OTP is incorrect.'],
                    ]);
                }
            } else {
                // Autentikasi username dan password
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
                    dd('here');
                    if (env('IS_SEND_OTP', false)) {

                        $otp = rand(100000, 999999);
                        Cache::put('otp_' . $user->id, $otp, now()->addMinutes(10));

                        Mail::to($user->email)->send(new \App\Mail\SendOtpMail($otp));

                        session(['otp_user_id' => $user->id]);

                        return null; // Return null to indicate that OTP verification is needed
                    }

                    return $user;
                }
                throw ValidationException::withMessages([
                    Fortify::username() => [trans('auth.failed')],
                ]);
            }
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

function generateRandomEmail()
{
    $randomString = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 10);
    $domain = 'gamail.com';
    return $randomString . '@' . $domain;
}

function generateRandomNip()
{
    return str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT); // Generate a 6-digit random number
}
