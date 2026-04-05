<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class CheckRatingRange
{
    public function handle(Request $request, Closure $next): Response
    {
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])) {
            $rating = $request->input('rating');

            if ($rating !== null) {
                if (!is_numeric($rating)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Field rating harus berupa angka',
                    ], 422);
                }

                if ((int) $rating < 1 || (int) $rating > 5) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Field rating harus bernilai antara 1 sampai 5',
                    ], 422);
                }
            }
        }

        return $next($request);
    }
}
