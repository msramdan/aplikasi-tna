<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Include DB facade for Query Builder
use Illuminate\Support\Facades\Auth;

class ReplyController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'log_review_id' => 'required|integer|exists:log_review_pengajuan_kap,id',
            'message' => 'required|string|max:500',
        ]);

        // Insert the new reply using Query Builder
        $replyId = DB::table('log_review_pengajuan_kap_replies')->insertGetId([
            'log_review_pengajuan_kap_id' => $request->log_review_id,
            'user_name' => Auth::user()->name,
            'message' => $request->message,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Fetch the newly created reply to return (if needed)
        $reply = DB::table('log_review_pengajuan_kap_replies')->where('id', $replyId)->first();

        return response()->json($reply);
    }
}
