<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user', 'items.product')->get();
        return response()->json(['status' => 'success', 'message' => 'Data order berhasil diambil', 'data' => $orders], 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'shipping_address' => 'required|string',
            'notes' => 'nullable|string',
        ]);
        $data['order_code']  = 'ORD-' . date('Ymd') . '-' . str_pad(Order::count() + 1, 4, '0', STR_PAD_LEFT);
        $data['status'] = 'pending';
        $data['total_price'] = 0;
        $order = Order::create($data);
        return response()->json(['status' => 'success', 'message' => 'Order berhasil dibuat', 'data' => $order->load('user')], 201);
    }

    public function show($id)
    {
        $order = Order::with('user', 'items.product')->find($id);
        if (!$order) {
            return response()->json(['status' => 'error', 'message' => 'Order tidak ditemukan'], 404);
        }
        return response()->json(['status' => 'success', 'message' => 'Data order berhasil diambil', 'data' => $order], 200);
    }

    public function addItem(Request $request, $id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['status' => 'error', 'message' => 'Order tidak ditemukan'], 404);
        }
        $data    = $request->validate(['product_id' => 'required|exists:products,id', 'quantity' => 'required|integer|min:1']);
        $product = Product::find($data['product_id']);
        $item    = OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => $data['quantity'],
            'unit_price' => $product->price,
            'subtotal' => $product->price * $data['quantity'],
        ]);
        $order->total_price = $order->items()->sum('subtotal');
        $order->save();
        return response()->json(['status' => 'success', 'message' => 'Item berhasil ditambahkan', 'data' => $item->load('product')], 201);
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['status' => 'error', 'message' => 'Order tidak ditemukan'], 404);
        }
        $data = $request->validate(['status' => 'required|in:pending,processing,shipped,delivered,cancelled']);
        $order->update($data);
        return response()->json(['status' => 'success', 'message' => 'Status order berhasil diperbarui', 'data' => $order], 200);
    }
}
