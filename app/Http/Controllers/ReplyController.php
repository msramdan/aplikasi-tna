<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Include DB facade for Query Builder
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ReplyController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'log_review_id' => 'required|integer|exists:log_review_pengajuan_kap,id',
            'message' => 'required|string|max:500',
            'kode_pembelajaran' => 'required|string', // Pastikan kode_pembelajaran juga divalidasi
        ]);

        $replyId = DB::table('log_review_pengajuan_kap_replies')->insertGetId([
            'log_review_pengajuan_kap_id' => $request->log_review_id,
            'user_name' => Auth::user()->name,
            'message' => $request->message,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $reply = DB::table('log_review_pengajuan_kap_replies')->where('id', $replyId)->first();

        if ($reply) {
            $nomor_hp = '083874731480';
            $namaUser = Auth::user()->name;
            // Batasi pesan hingga 100 karakter
            $limitedMessage = Str::limit($request->message, 100, '...');

            $pesan = "{$namaUser} telah memberikan komentar pada pengajuan KAP dengan kode {$request->kode_pembelajaran}: \"_" . $limitedMessage . "_\". Untuk informasi lebih lanjut, silakan kunjungi tautan berikut: {$request->full_url}";

            if (env('SEND_NOTIFICATIONS', false)) {
                try {
                    $notificationSent = send($nomor_hp, $pesan);
                    if (!$notificationSent) {
                        self::sendTelegramNotification('Failed to send WA notification to ' . $nomor_hp);
                    }
                } catch (\Exception $e) {
                    \Log::error('Failed to send notification: ' . $e->getMessage());
                    self::sendTelegramNotification('Error occurred while sending WA notification: ' . $e->getMessage());
                }
            }
        } else {
            return response()->json(['error' => 'Failed to create reply'], 500);
        }
        return response()->json($reply);
    }


    function sendTelegramNotification($message)
    {
        $telegramApiToken = env('TELEGRAM_API_TOKEN');
        $chatId = env('TELEGRAM_CHAT_ID');

        $url = "https://api.telegram.org/bot{$telegramApiToken}/sendMessage";

        $data = [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'HTML',
        ];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }
}
