<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

// Middleware: Dewi Lestari Tampubolon
// Memeriksa field name tag tidak boleh kosong dan tidak mengandung karakter spesial
class CheckTagName
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->isMethod('POST')) {
            $name = $request->input('name');

            if (is_null($name) || trim($name) === '') {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Field name tag tidak boleh kosong'
                ], 422);
            }

            // Nama tag tidak boleh mengandung karakter spesial selain spasi dan strip
            if (!preg_match('/^[a-zA-Z0-9\s\-]+$/', trim($name))) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Nama tag hanya boleh mengandung huruf, angka, spasi, dan strip'
                ], 422);
            }
        }

        return $next($request);
    }
}
