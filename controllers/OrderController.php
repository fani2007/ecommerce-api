<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    // GET /api/orders
    public function index(): JsonResponse
    {
        $orders = Order::with(['user', 'orderItems.product'])->get();
        return response()->json(['success' => true, 'data' => $orders]);
    }

    // GET /api/orders/{id}
    public function show(int $id): JsonResponse
    {
        $order = Order::with(['user', 'orderItems.product'])->find($id);

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order tidak ditemukan'], 404);
        }

        return response()->json(['success' => true, 'data' => $order]);
    }

    // POST /api/orders
    public function store(Request $request): JsonResponse
    {
        $required = ['user_id', 'shipping_address', 'shipping_city', 'shipping_postal_code'];
        foreach ($required as $field) {
            if (empty($request->input($field))) {
                return response()->json(['success' => false, 'message' => "Field $field wajib diisi"], 422);
            }
        }

        $orderCode = 'ORD-' . date('Y') . '-' . str_pad(Order::count() + 1, 4, '0', STR_PAD_LEFT);

        $order = Order::create([
            'user_id'              => $request->input('user_id'),
            'order_code'           => $orderCode,
            'total_price'          => 0,
            'status'               => 'pending',
            'shipping_address'     => $request->input('shipping_address'),
            'shipping_city'        => $request->input('shipping_city'),
            'shipping_postal_code' => $request->input('shipping_postal_code'),
        ]);

        return response()->json(['success' => true, 'message' => 'Order berhasil dibuat', 'data' => $order], 201);
    }

    // PUT /api/orders/{id}/status — update status order
    public function updateStatus(Request $request, int $id): JsonResponse
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order tidak ditemukan'], 404);
        }

        $newStatus = $request->input('status');
        $allowed   = ['pending', 'paid', 'shipped', 'delivered', 'cancelled'];

        if (!in_array($newStatus, $allowed)) {
            return response()->json(['success' => false, 'message' => 'Status tidak valid. Pilihan: ' . implode(', ', $allowed)], 422);
        }

        if ($order->status === 'cancelled') {
            return response()->json(['success' => false, 'message' => 'Order yang sudah dibatalkan tidak bisa diubah statusnya'], 409);
        }

        $order->update(['status' => $newStatus]);
        return response()->json(['success' => true, 'message' => 'Status order berhasil diupdate', 'data' => $order]);
    }

    // GET /api/orders/user/{userId} — semua order milik user tertentu
    public function byUser(int $userId): JsonResponse
    {
        $orders = Order::with('orderItems.product')
            ->where('user_id', $userId)
            ->get();

        return response()->json(['success' => true, 'data' => $orders]);
    }

    // DELETE /api/orders/{id}
    public function destroy(int $id): JsonResponse
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order tidak ditemukan'], 404);
        }

        if (!in_array($order->status, ['pending', 'cancelled'])) {
            return response()->json(['success' => false, 'message' => 'Hanya order berstatus pending atau cancelled yang bisa dihapus'], 409);
        }

        $order->delete();
        return response()->json(['success' => true, 'message' => 'Order berhasil dihapus']);
    }
}
