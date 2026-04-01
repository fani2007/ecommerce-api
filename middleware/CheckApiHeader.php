<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware milik Rafani — Modul User
 * Memeriksa header X-Api-Key wajib ada dan bernilai benar
 */
class CheckApiHeader
{
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('X-Api-Key');

        if (empty($apiKey)) {
            return response()->json([
                'success' => false,
                'message' => 'Header X-Api-Key wajib disertakan',
            ], 401);
        }

        // Nilai key disimpan di .env sebagai APP_API_KEY
        if ($apiKey !== config('app.api_key', 'secret-key-ecommerce')) {
            return response()->json([
                'success' => false,
                'message' => 'X-Api-Key tidak valid',
            ], 403);
        }

        return $next($request);
    }
}
