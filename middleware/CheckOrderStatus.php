<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Order;
use Symfony\Component\HttpFoundation\Response;

class CheckOrderStatus
{
    public function handle(Request $request, Closure $next): Response
    {
        $orderId = $request->route('id');

        if ($orderId) {
            $order = Order::find($orderId);

            if ($order && $order->status === 'cancelled') {
                return response()->json([
                    'success' => false,
                    'message' => 'Order dengan status cancelled tidak dapat dimodifikasi',
                ], 403);
            }
        }

        return $next($request);
    }
}
