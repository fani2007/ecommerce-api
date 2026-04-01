<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

// Middleware: Naila Sarah
// Memeriksa nilai stock produk harus lebih dari 0 saat POST
class CheckProductStock
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->isMethod('POST')) {
            $stock = $request->input('stock');

            if (is_null($stock)) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Field stock wajib diisi'
                ], 422);
            }

            if (!is_numeric($stock) || (int)$stock < 0) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Nilai stock tidak boleh negatif'
                ], 422);
            }

            if ((int)$stock === 0) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Produk baru harus memiliki stock lebih dari 0'
                ], 422);
            }
        }

        return $next($request);
    }
}
