<?php
// app/Http/Controllers/Auth/OtpController.php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class OtpController extends Controller
{
    public function verifyOtp(Request $request)
    {
        $userId = session('otp_user_id');
        if (!$userId) {
            return redirect()->route('login')->withErrors(['alert_verify_otp' => 'Session expired. Please try again.']);
        }

        $otp = $request->input('satu') . $request->input('dua') . $request->input('tiga') .
            $request->input('empat') . $request->input('lima') . $request->input('enam');

        $cachedOtp = Cache::get('otp_' . $userId);

        if ($cachedOtp === null) {
            session()->forget('otp_user_id');
            return redirect()->route('login')->withErrors(['alert_verify_otp' => 'OTP expired. Please try again.']);
        }

        if ($cachedOtp == $otp) {
            Cache::forget('otp_' . $userId);
            session()->forget('otp_user_id');
            $user = User::find($userId);
            if ($user) {
                Auth::login($user);
                return redirect()->route('dashboard')->with('success', 'OTP verified successfully.');
            }

            return redirect()->route('login')->withErrors(['alert_verify_otp' => 'User not found. Please try again.']);
        } else {
            return redirect()->back()->with('otp_error', 'Invalid OTP. Please try again.');
        }
    }
}
