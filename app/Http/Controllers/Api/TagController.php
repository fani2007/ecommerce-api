<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

// Modul: Dewi Lestari Tampubolon
class TagController extends Controller
{
    // GET /api/tags
    public function index()
    {
        $tags = Tag::with('products')->get();
        return response()->json([
            'status'  => 'success',
            'message' => 'Data tag berhasil diambil',
            'data'    => $tags
        ], 200);
    }

    // POST /api/tags
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100|unique:tags,name',
        ]);

        $data['slug'] = Str::slug($data['name']);

        $tag = Tag::create($data);

        return response()->json([
            'status'  => 'success',
            'message' => 'Tag berhasil dibuat',
            'data'    => $tag
        ], 201);
    }

    // GET /api/tags/{id}
    public function show($id)
    {
        $tag = Tag::with('products')->find($id);

        if (!$tag) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Tag tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Data tag berhasil diambil',
            'data'    => $tag
        ], 200);
    }

    // PUT /api/products/{productId}/tag/{tagId} — attach tag ke product
    public function attachToProduct($productId, $tagId)
    {
        $product = Product::find($productId);
        $tag     = Tag::find($tagId);

        if (!$product || !$tag) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Produk atau tag tidak ditemukan'
            ], 404);
        }

        // Cek sudah ter-attach belum
        if ($product->tags()->where('tag_id', $tagId)->exists()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Tag sudah terpasang pada produk ini'
            ], 409);
        }

        $product->tags()->attach($tagId);

        return response()->json([
            'status'  => 'success',
            'message' => 'Tag berhasil ditambahkan ke produk',
            'data'    => $product->load('tags')
        ], 200);
    }

    // DELETE /api/products/{productId}/tag/{tagId} — detach tag dari product
    public function detachFromProduct($productId, $tagId)
    {
        $product = Product::find($productId);
        $tag     = Tag::find($tagId);

        if (!$product || !$tag) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Produk atau tag tidak ditemukan'
            ], 404);
        }

        $product->tags()->detach($tagId);

        return response()->json([
            'status'  => 'success',
            'message' => 'Tag berhasil dilepas dari produk',
            'data'    => $product->load('tags')
        ], 200);
    }

    // DELETE /api/tags/{id}
    public function destroy($id)
    {
        $tag = Tag::find($id);

        if (!$tag) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Tag tidak ditemukan'
            ], 404);
        }

        $tag->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Tag berhasil dihapus'
        ], 200);
    }
}
