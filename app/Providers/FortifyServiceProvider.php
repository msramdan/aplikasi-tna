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
use App\Mail\SendOtpMail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


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
            if (config('stara.is_hit')) {
                $userId = session('otp_user_id');
                session()->forget('otp_user_id');
                if ($userId) {
                    Cache::forget('otp_' . $userId);
                }

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
                        $nip_lama = $data['data']['user_info']['user_nip'];
                        $api_token = config('stara.map_api_token_employee');
                        $endpointUnitKerja = config('stara.map_endpoint') . '/v2/pegawai/sima/atlas?api_token=' . $api_token . '&s_nip=' . $nip_lama;
                        try {
                            $response = Http::get($endpointUnitKerja);
                            if ($response->successful()) {
                                $unitKerjaData = $response->json();
                                $kode_eselon2 = $unitKerjaData['result'][0]['kode_eselon2'];
                            } else {
                                dd('Request to endpoint unit kerja failed.');
                            }
                        } catch (\Exception $e) {
                            dd('Error: ' . $e->getMessage());
                        }

                        $user = User::create([
                            'user_nip' => $data['data']['user_info']['user_nip'],
                            'name' => $data['data']['user_info']['name'],
                            'phone' => $data['data']['user_info']['nomor_hp'],
                            'email' => $data['data']['user_info']['email'],
                            'jabatan' => $data['data']['user_info']['jabatan'],
                            'kode_unit' => $kode_eselon2,
                            'key_sort_unit' => $data['data']['user_info']['key_sort_unit'],
                            'nama_unit' => $data['data']['user_info']['namaunit']
                        ]);
                        $role = Role::where('id', 3)->first();
                        if ($role) {
                            $user->assignRole($role);
                        } else {
                            dd('Role not found');
                        }
                    }

                    // Cek apakah nomor HP kosong/null
                    if (empty($data['data']['user_info']['nomor_hp']) || empty($user->phone)) {
                        // Set session untuk menampilkan form input nomor WA
                        session(['show_form_no_wa' => true]);
                    }

                    // Skip pengecekan jadwal_kap_tahunan jika session show_form_no_wa true
                    if (!session()->has('show_form_no_wa')) {
                        $now = Carbon::now();
                        $jadwalData = DB::table('jadwal_kap_tahunan')
                            ->where('tanggal_mulai', '<=', $now)
                            ->where('tanggal_selesai', '>=', $now)
                            ->first();

                        if ($jadwalData) {
                            session()->flash('login_success', true);
                            session(['jadwal_kap_tahunan' => $jadwalData]);
                        }
                    }

                    if (env('IS_SEND_OTP', false)) {
                        $otp = rand(100000, 999999);
                        $otpExpiration = env('EXPIRED_OTP', 3);
                        Cache::put('otp_' . $user->id, $otp, now()->addMinutes($otpExpiration));
                        Mail::to($user->email)->send(new SendOtpMail($otp));
                        session(['otp_user_id' => $user->id]);
                        session(['otp_email' => $user->email]);
                        return null;
                    }

                    if ($request->filled('remember')) {
                        Auth::login($user, true);
                    } else {
                        Auth::login($user);
                    }

                    return $user;
                }




                throw ValidationException::withMessages([
                    Fortify::username() => [trans('auth.failed')],
                ]);
            } else {
                $user = User::where('name', $request->username)->first();
                if (!$user) {
                    $user = User::create([
                        'user_nip' => generateRandomNip(),
                        'name' =>  $request->username,
                        'phone' =>  '-',
                        'email' => generateRandomEmail(),
                        'jabatan' =>  '-',
                        'nama_unit' =>  '-'
                    ]);
                    $role = Role::where('id', 1)->first();
                    if ($role) {
                        $user->assignRole($role);
                    } else {
                        dd('Role not found');
                    }
                }
                return $user;
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
    return str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
}
