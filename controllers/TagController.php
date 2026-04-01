<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class TagController extends Controller
{
    // GET /api/tags
    public function index(): JsonResponse
    {
        $tags = Tag::withCount('products')->get();
        return response()->json(['success' => true, 'data' => $tags]);
    }

    // GET /api/tags/{id}
    public function show(int $id): JsonResponse
    {
        $tag = Tag::with('products')->find($id);

        if (!$tag) {
            return response()->json(['success' => false, 'message' => 'Tag tidak ditemukan'], 404);
        }

        return response()->json(['success' => true, 'data' => $tag]);
    }

    // POST /api/tags
    public function store(Request $request): JsonResponse
    {
        $name = $request->input('name');

        if (empty($name)) {
            return response()->json(['success' => false, 'message' => 'Field name wajib diisi'], 422);
        }

        $slug = Str::slug($name);

        if (Tag::where('slug', $slug)->exists()) {
            return response()->json(['success' => false, 'message' => 'Tag sudah ada'], 409);
        }

        $tag = Tag::create(['name' => $name, 'slug' => $slug]);
        return response()->json(['success' => true, 'message' => 'Tag berhasil dibuat', 'data' => $tag], 201);
    }

    // PUT /api/products/{productId}/tags/{tagId}  — attach tag ke produk
    public function attachToProduct(int $productId, int $tagId): JsonResponse
    {
        $product = Product::find($productId);
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan'], 404);
        }

        $tag = Tag::find($tagId);
        if (!$tag) {
            return response()->json(['success' => false, 'message' => 'Tag tidak ditemukan'], 404);
        }

        if ($product->tags()->where('tag_id', $tagId)->exists()) {
            return response()->json(['success' => false, 'message' => 'Tag sudah ditambahkan ke produk ini'], 409);
        }

        $product->tags()->attach($tagId);
        return response()->json(['success' => true, 'message' => 'Tag berhasil ditambahkan ke produk', 'data' => $product->load('tags')]);
    }

    // DELETE /api/products/{productId}/tags/{tagId} — detach tag dari produk
    public function detachFromProduct(int $productId, int $tagId): JsonResponse
    {
        $product = Product::find($productId);
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan'], 404);
        }

        $product->tags()->detach($tagId);
        return response()->json(['success' => true, 'message' => 'Tag berhasil dihapus dari produk']);
    }

    // DELETE /api/tags/{id}
    public function destroy(int $id): JsonResponse
    {
        $tag = Tag::find($id);

        if (!$tag) {
            return response()->json(['success' => false, 'message' => 'Tag tidak ditemukan'], 404);
        }

        $tag->products()->detach();
        $tag->delete();
        return response()->json(['success' => true, 'message' => 'Tag berhasil dihapus']);
    }
}
