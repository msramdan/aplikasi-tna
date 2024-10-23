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
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'message' => $request->message,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $reply = DB::table('log_review_pengajuan_kap_replies')->where('id', $replyId)->first();

        if ($reply) {
            $namaUser = Auth::user()->name;
            // Batasi pesan hingga 100 karakter
            $limitedMessage = Str::limit($request->message, 100, '...');

            $pesan = "{$namaUser} telah memberikan komentar pada pengajuan KAP dengan kode {$request->kode_pembelajaran}: \"_" . $limitedMessage . "_\". Untuk informasi lebih lanjut, silakan kunjungi tautan berikut: {$request->full_url}";

            if (env('SEND_NOTIFICATIONS', false)) {
                // get data user user
                try {
                    $request->user_created;

                    // Get data user config step
                    $userReviewIds = DB::table('config_step_review')
                        ->where('remark', $request->current_step_remark)
                        ->pluck('user_review_id')
                        ->toArray();

                    // Get data log_review_pengajuan_kap_replies
                    $repliesUserIds = DB::table('log_review_pengajuan_kap_replies')
                        ->where('log_review_pengajuan_kap_id', $request->log_review_id)
                        ->whereNotNull('user_id')
                        ->where('user_id', '!=', '')
                        ->groupBy('user_id')
                        ->pluck('user_id')
                        ->toArray();

                    // Gabungkan kedua array dan pastikan unik
                    $combinedUserIds = array_unique(array_merge($userReviewIds, $repliesUserIds));

                    // Ambil ID pengguna yang sedang login
                    $loggedInUserId = Auth::id(); // Mendapatkan ID pengguna yang sedang login

                    // Jika user_created tidak null dan tidak sama dengan user yang login
                    if ($request->user_created !== null && $request->user_created !== '' && (int)$request->user_created !== $loggedInUserId) {
                        $combinedUserIds[] = (int)$request->user_created; // Pastikan ini bertipe integer
                    }

                    // Hapus ID pengguna yang sedang login dari combinedUserIds jika ada
                    $combinedUserIds = array_filter($combinedUserIds, function ($userId) use ($loggedInUserId) {
                        return $userId !== $loggedInUserId;
                    });

                    // Jika combinedUserIds kosong, hanya ambil user_created jika ada
                    if (empty($combinedUserIds)) {
                        if ($request->user_created !== null && $request->user_created !== '' && (int)$request->user_created !== $loggedInUserId) {
                            $combinedUserIds[] = (int)$request->user_created; // Pastikan ini bertipe integer
                        }
                    }

                    // Ambil ID pengguna yang sesuai dari combinedUserIds jika tidak kosong
                    $users = [];
                    if (!empty($combinedUserIds)) {
                        $users = DB::table('users')
                            ->whereIn('id', $combinedUserIds)
                            ->get();
                    }

                    // Looping data users di sini dan send notif
                    foreach ($users as $user) {
                        if (!empty($user->phone)) { // Pastikan nomor telepon tidak kosong
                            $notificationSent = send($user->phone, $pesan);
                            if (!$notificationSent) {
                                self::sendTelegramNotification('Failed to send WA notification to ' . $user->phone);
                            }
                        }
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
