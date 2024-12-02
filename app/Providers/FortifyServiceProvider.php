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
            // Bersihkan session yang mungkin tersisa dari login sebelumnya
            $sessionsToForget = [
                'login_success',
                'show_form_no_wa',
                'jadwal_kap_tahunan',
                'otp_user_id',
                'otp_email'
            ];
            session()->forget($sessionsToForget);

            if (config('stara.is_hit')) {
                $userId = session('otp_user_id');
                if ($userId) {
                    Cache::forget('otp_' . $userId);
                }

                $request->validate([
                    'username' => 'required',
                    'password' => 'required',
                    'g-recaptcha-response' => 'required|captcha',
                ]);

                // Hit ke Stara endpoint untuk login
                $response = Http::post(config('stara.endpoint') . '/auth/login', [
                    'username' => $request->username,
                    'password' => $request->password,
                ]);
                if ($response->successful()) {
                    $data = $response->json();
                    $user = User::where('user_nip', $data['data']['user_info']['user_nip'])->first();

                    if (!$user) {
                        $user = createUser($data['data']['user_info']);
                    }

                    if (empty($user->phone)) {
                        session(['show_form_no_wa' => true]);
                    }

                    // Skip pengecekan jadwal_kap_tahunan jika session show_form_no_wa true
                    if (!session()->has('show_form_no_wa')) {
                        setJadwalKapSession();
                    }

                    if (env('IS_SEND_OTP', false)) {
                        sendOtp($user);
                        return null;
                    }

                    Auth::login($user, $request->filled('remember'));
                    session(['api_token' => $data['data']['token']]);
                    return $user;
                } else {
                    // Hit ke SIBIJAK endpoint jika Stara gagal
                    $sibijakLoginResponse = Http::post(env('ENDPOINT_SIBIJAK') . '/v1/auth/login', [
                        'username' => $request->username,
                        'password' => $request->password,
                    ]);

                    if ($sibijakLoginResponse->successful()) {
                        $sibijakData = $sibijakLoginResponse->json();
                        $token = $sibijakData['token'];
                        // Hit ke SIBIJAK endpoint /auth/me dengan token dari login
                        $meResponse = Http::withHeaders([
                            'Authorization' => 'Bearer ' . $sibijakData['token'],
                        ])->get(env('ENDPOINT_SIBIJAK') . '/v1/auth/me');

                        if ($meResponse->successful()) {
                            $meData = $meResponse->json();
                            $pegawai = $meData['pegawai'];

                            $user = User::where('user_nip', $pegawai['nip'])->first();
                            if (!$user) {
                                $user = User::create([
                                    'name' => $pegawai['nama_lengkap'],
                                    'user_nip' => $pegawai['nip'],
                                    'email' => $meData['email'],
                                    'phone' => $pegawai['nomor_telepon'],
                                    'jabatan' => $pegawai['data_terkini']['nama_jenjang_jabatan'],
                                    'kode_unit' => $pegawai['data_terkini']['unit_kerja_id'],
                                    'key_sort_unit' => null,
                                    'is_bpkp' => 'No',
                                    'nama_unit' => $pegawai['data_terkini']['nama_unit'],
                                ]);
                                assignRole($user, 3);
                            }

                            if (empty($user->phone)) {
                                session(['show_form_no_wa' => true]);
                            }

                            if (!session()->has('show_form_no_wa')) {
                                setJadwalKapSession();
                            }

                            if (env('IS_SEND_OTP', false)) {
                                sendOtp($user);
                                return null;
                            }
                            Auth::login($user, $request->filled('remember'));
                            session(['api_token' => $token]);
                            return $user;
                        }
                    }
                }

                throw ValidationException::withMessages([Fortify::username() => [trans('auth.failed')]]);
            } else {
                return handleDefaultUser($request);
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

function createUser($userInfo)
{
    try {
        $nip_lama = $userInfo['user_nip'];
        $response = Http::get(config('stara.map_endpoint') . '/v2/pegawai/sima/atlas', [
            'api_token' => config('stara.map_api_token_employee'),
            's_nip' => $nip_lama
        ]);

        if ($response->successful()) {
            $unitKerjaData = $response->json();
            $kode_eselon2 = $unitKerjaData['result'][0]['kode_eselon2'];
        } else {
            throw new \Exception('Request to endpoint unit kerja failed.');
        }

        $user = User::create([
            'user_nip' => $userInfo['user_nip'],
            'name' => $userInfo['name'],
            'phone' => $userInfo['nomor_hp'] ?? '',
            'email' => $userInfo['email'],
            'jabatan' => $userInfo['jabatan'],
            'kode_unit' => $kode_eselon2,
            'key_sort_unit' => $userInfo['key_sort_unit'],
            'nama_unit' => $userInfo['namaunit'],
            'is_bpkp' => 'Yes',
        ]);

        assignRole($user, 3);
        return $user;
    } catch (\Exception $e) {
        report($e);
        abort(500, 'Error creating user: ' . $e->getMessage());
    }
}

/**
 * Method untuk mengatur session jadwal_kap_tahunan.
 */
function setJadwalKapSession()
{
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

/**
 * Method untuk mengirim OTP ke user.
 */
function sendOtp($user)
{
    $otp = rand(100000, 999999);
    $otpExpiration = env('EXPIRED_OTP', 3);
    Cache::put('otp_' . $user->id, $otp, now()->addMinutes($otpExpiration));
    Mail::to($user->email)->send(new SendOtpMail($otp));
    session(['otp_user_id' => $user->id, 'otp_email' => $user->email]);
}

/**
 * Method untuk handle user default jika Stara tidak diaktifkan.
 */
function handleDefaultUser($request)
{
    $user = User::firstOrCreate(
        ['name' => $request->username],
        [
            'user_nip' => generateRandomNip(),
            'phone' => '-',
            'email' => generateRandomEmail(),
            'jabatan' => '-',
            'nama_unit' => '-'
        ]
    );

    assignRole($user, 1);
    return $user;
}

/**
 * Method untuk assign role ke user.
 */
function assignRole($user, $roleId)
{
    $role = Role::find($roleId);
    if ($role) {
        $user->assignRole($role);
    } else {
        abort(500, 'Role not found');
    }
}
