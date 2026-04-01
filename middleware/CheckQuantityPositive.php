<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware milik Lidia — Modul OrderItem
 * Memastikan field quantity pada request adalah angka positif
 */
class CheckQuantityPositive
{
    public function handle(Request $request, Closure $next): Response
    {
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])) {
            $quantity = $request->input('quantity');

            if ($quantity !== null) {
                if (!is_numeric($quantity)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Field quantity harus berupa angka',
                    ], 422);
                }

                if ((int) $quantity <= 0) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Field quantity harus lebih dari 0',
                    ], 422);
                }
            }
        }

        return $next($request);
    }
}
