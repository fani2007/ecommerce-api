<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

// Middleware: Nabila Anjani
// Memeriksa field name tidak boleh kosong pada POST/PUT kategori
class CheckCategoryName
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->isMethod('POST')) {
            $name = $request->input('name');

            if (is_null($name) || trim($name) === '') {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Field name kategori tidak boleh kosong'
                ], 422);
            }

            if (strlen(trim($name)) < 3) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Nama kategori minimal 3 karakter'
                ], 422);
            }
        }

        return $next($request);
    }
}
