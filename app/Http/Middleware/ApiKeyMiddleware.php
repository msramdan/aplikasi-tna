<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiKeyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Mendapatkan API key dari query parameter
        $apiKey = $request->query('api_key');

        // Mengambil API key dari .env
        $expectedApiKey = env('API_KEY_TNA');

        // Validasi API key
        if (empty($apiKey)) {
            return response()->json(['status' => false, 'message' => 'API key is required.'], 401);
        }

        if ($apiKey !== $expectedApiKey) {
            return response()->json(['status' => false, 'message' => 'Invalid token or token required.'], 403);
        }

        // Jika validasi berhasil, lanjutkan ke request berikutnya
        return $next($request);
    }
}
