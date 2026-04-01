<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

// Middleware: Rafani Wasi'unnikmah Siregar
// Memeriksa header X-Kelompok harus ada dan bernilai benar
class CheckGroupHeader
{
    public function handle(Request $request, Closure $next)
    {
        $kelompok = $request->header('X-Kelompok');

        if (!$kelompok) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Header X-Kelompok wajib disertakan'
            ], 400);
        }

        // Nilai X-Kelompok harus berupa string tidak kosong
        if (trim($kelompok) === '') {
            return response()->json([
                'status'  => 'error',
                'message' => 'Nilai header X-Kelompok tidak boleh kosong'
            ], 400);
        }

        return $next($request);
    }
}
