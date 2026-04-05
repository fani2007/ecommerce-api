<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTagNameNotEmpty
{
    public function handle(Request $request, Closure $next): Response
    {
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])) {
            $name = $request->input('name');

            if ($name !== null && trim($name) === '') {
                return response()->json([
                    'success' => false,
                    'message' => 'Field name tidak boleh berisi string kosong',
                ], 422);
            }
        }

        return $next($request);
    }
}
