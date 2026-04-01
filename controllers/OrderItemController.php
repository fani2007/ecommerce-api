<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class OrderItemController extends Controller
{
    // GET /api/order-items
    public function index(): JsonResponse
    {
        $items = OrderItem::with(['order', 'product'])->get();
        return response()->json(['success' => true, 'data' => $items]);
    }

    // GET /api/order-items/{id}
    public function show(int $id): JsonResponse
    {
        $item = OrderItem::with(['order', 'product'])->find($id);

        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Item tidak ditemukan'], 404);
        }

        return response()->json(['success' => true, 'data' => $item]);
    }

    // POST /api/order-items — tambah item ke order
    public function store(Request $request): JsonResponse
    {
        $orderId   = $request->input('order_id');
        $productId = $request->input('product_id');
        $quantity  = $request->input('quantity');

        if (!$orderId || !$productId || !$quantity) {
            return response()->json(['success' => false, 'message' => 'order_id, product_id, dan quantity wajib diisi'], 422);
        }

        if ((int) $quantity <= 0) {
            return response()->json(['success' => false, 'message' => 'Quantity harus lebih dari 0'], 422);
        }

        $order = Order::find($orderId);
        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order tidak ditemukan'], 404);
        }

        if ($order->status !== 'pending') {
            return response()->json(['success' => false, 'message' => 'Item hanya bisa ditambahkan ke order berstatus pending'], 409);
        }

        $product = Product::find($productId);
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan'], 404);
        }

        if ($product->stock < $quantity) {
            return response()->json(['success' => false, 'message' => 'Stok produk tidak mencukupi. Stok tersedia: ' . $product->stock], 409);
        }

        $subtotal = $product->price * $quantity;

        $item = OrderItem::create([
            'order_id'   => $orderId,
            'product_id' => $productId,
            'quantity'   => $quantity,
            'unit_price' => $product->price,
            'subtotal'   => $subtotal,
        ]);

        // Update stok produk
        $product->decrement('stock', $quantity);

        // Update total harga order
        $order->increment('total_price', $subtotal);

        return response()->json(['success' => true, 'message' => 'Item berhasil ditambahkan', 'data' => $item->load('product')], 201);
    }

    // DELETE /api/order-items/{id}
    public function destroy(int $id): JsonResponse
    {
        $item = OrderItem::find($id);

        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Item tidak ditemukan'], 404);
        }

        if ($item->order->status !== 'pending') {
            return response()->json(['success' => false, 'message' => 'Item hanya bisa dihapus dari order berstatus pending'], 409);
        }

        // Kembalikan stok
        Product::find($item->product_id)?->increment('stock', $item->quantity);

        // Kurangi total order
        $item->order->decrement('total_price', $item->subtotal);

        $item->delete();
        return response()->json(['success' => true, 'message' => 'Item berhasil dihapus']);
    }

    // GET /api/orders/{orderId}/items — semua item dalam satu order
    public function byOrder(int $orderId): JsonResponse
    {
        $order = Order::find($orderId);

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order tidak ditemukan'], 404);
        }

        $items = OrderItem::with('product')->where('order_id', $orderId)->get();
        return response()->json(['success' => true, 'data' => $items]);
    }
}
