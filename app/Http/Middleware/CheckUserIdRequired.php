<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

// Middleware: Shilla Maulida
// Memeriksa field user_id wajib ada dan tidak kosong pada request body
class CheckUserIdRequired
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->isMethod('POST')) {
            $userId = $request->input('user_id');

            if (is_null($userId) || $userId === '') {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Field user_id wajib diisi'
                ], 422);
            }

            if (!is_numeric($userId) || (int)$userId <= 0) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Field user_id harus berupa angka positif'
                ], 422);
            }
        }

        return $next($request);
    }
}
