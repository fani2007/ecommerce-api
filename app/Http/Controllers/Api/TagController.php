<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::with('products')->get();
        return response()->json(['status' => 'success', 'message' => 'Data tag berhasil diambil', 'data' => $tags], 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate(['name' => 'required|string|max:100|unique:tags,name']);
        $data['slug'] = Str::slug($data['name']);
        $tag = Tag::create($data);
        return response()->json(['status' => 'success', 'message' => 'Tag berhasil dibuat', 'data' => $tag], 201);
    }

    public function show($id)
    {
        $tag = Tag::with('products')->find($id);
        if (!$tag) {
            return response()->json(['status' => 'error', 'message' => 'Tag tidak ditemukan'], 404);
        }
        return response()->json(['status' => 'success', 'message' => 'Data tag berhasil diambil', 'data' => $tag], 200);
    }

    public function destroy($id)
    {
        $tag = Tag::find($id);
        if (!$tag) {
            return response()->json(['status' => 'error', 'message' => 'Tag tidak ditemukan'], 404);
        }
        $tag->delete();
        return response()->json(['status' => 'success', 'message' => 'Tag berhasil dihapus'], 200);
    }

    public function attachToProduct($productId, $tagId)
    {
        $product = Product::find($productId);
        $tag     = Tag::find($tagId);
        if (!$product || !$tag) {
            return response()->json(['status' => 'error', 'message' => 'Produk atau tag tidak ditemukan'], 404);
        }
        if ($product->tags()->where('tag_id', $tagId)->exists()) {
            return response()->json(['status' => 'error', 'message' => 'Tag sudah terpasang pada produk ini'], 409);
        }
        $product->tags()->attach($tagId);
        return response()->json(['status' => 'success', 'message' => 'Tag berhasil ditambahkan ke produk', 'data' => $product->load('tags')], 200);
    }

    public function detachFromProduct($productId, $tagId)
    {
        $product = Product::find($productId);
        $tag     = Tag::find($tagId);
        if (!$product || !$tag) {
            return response()->json(['status' => 'error', 'message' => 'Produk atau tag tidak ditemukan'], 404);
        }
        $product->tags()->detach($tagId);
        return response()->json(['status' => 'success', 'message' => 'Tag berhasil dilepas dari produk', 'data' => $product->load('tags')], 200);
    }
}
