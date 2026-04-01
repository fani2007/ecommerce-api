<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

// Modul: Naila Sarah
class ProductController extends Controller
{
    // GET /api/products
    public function index()
    {
        $products = Product::with('category', 'tags')->get();
        return response()->json([
            'status'  => 'success',
            'message' => 'Data produk berhasil diambil',
            'data'    => $products
        ], 200);
    }

    // POST /api/products
    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'status'      => 'nullable|in:active,inactive',
        ]);

        $data['slug'] = Str::slug($data['name']) . '-' . uniqid();

        $product = Product::create($data);

        return response()->json([
            'status'  => 'success',
            'message' => 'Produk berhasil dibuat',
            'data'    => $product->load('category')
        ], 201);
    }

    // GET /api/products/{id}
    public function show($id)
    {
        $product = Product::with('category', 'tags')->find($id);

        if (!$product) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Data produk berhasil diambil',
            'data'    => $product
        ], 200);
    }

    // PUT /api/products/{id}
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }

        $data = $request->validate([
            'category_id' => 'sometimes|exists:categories,id',
            'name'        => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'sometimes|numeric|min:0',
            'stock'       => 'sometimes|integer|min:0',
            'status'      => 'nullable|in:active,inactive',
        ]);

        $product->update($data);

        return response()->json([
            'status'  => 'success',
            'message' => 'Produk berhasil diperbarui',
            'data'    => $product->load('category', 'tags')
        ], 200);
    }

    // DELETE /api/products/{id}
    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }

        $product->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Produk berhasil dihapus'
        ], 200);
    }
}
