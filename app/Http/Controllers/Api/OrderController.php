<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

// Modul: Lidia Trifosa Simangunsong
class OrderController extends Controller
{
    // GET /api/orders
    public function index()
    {
        $orders = Order::with('user', 'items.product')->get();
        return response()->json([
            'status'  => 'success',
            'message' => 'Data order berhasil diambil',
            'data'    => $orders
        ], 200);
    }

    // POST /api/orders
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id'          => 'required|exists:users,id',
            'shipping_address' => 'required|string',
            'notes'            => 'nullable|string',
        ]);

        $data['order_code'] = 'ORD-' . date('Ymd') . '-' . str_pad(Order::count() + 1, 4, '0', STR_PAD_LEFT);
        $data['status']     = 'pending';
        $data['total_price'] = 0;

        $order = Order::create($data);

        return response()->json([
            'status'  => 'success',
            'message' => 'Order berhasil dibuat',
            'data'    => $order->load('user')
        ], 201);
    }

    // GET /api/orders/{id}
    public function show($id)
    {
        $order = Order::with('user', 'items.product')->find($id);

        if (!$order) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Order tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Data order berhasil diambil',
            'data'    => $order
        ], 200);
    }

    // POST /api/orders/{id}/items — tambah item ke order
    public function addItem(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Order tidak ditemukan'
            ], 404);
        }

        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        $product = Product::find($data['product_id']);

        $item = OrderItem::create([
            'order_id'   => $order->id,
            'product_id' => $product->id,
            'quantity'   => $data['quantity'],
            'unit_price' => $product->price,
            'subtotal'   => $product->price * $data['quantity'],
        ]);

        // Update total_price order
        $order->total_price = $order->items()->sum('subtotal');
        $order->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'Item berhasil ditambahkan ke order',
            'data'    => $item->load('product')
        ], 201);
    }

    // PUT /api/orders/{id}/status — update status order
    public function updateStatus(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Order tidak ditemukan'
            ], 404);
        }

        $data = $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $order->update($data);

        return response()->json([
            'status'  => 'success',
            'message' => 'Status order berhasil diperbarui',
            'data'    => $order
        ], 200);
    }
}
