<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    // GET /api/categories
    public function index(): JsonResponse
    {
        $categories = Category::withCount('products')->get();
        return response()->json(['success' => true, 'data' => $categories]);
    }

    // GET /api/categories/{id}
    public function show(int $id): JsonResponse
    {
        $category = Category::with('products')->find($id);

        if (!$category) {
            return response()->json(['success' => false, 'message' => 'Kategori tidak ditemukan'], 404);
        }

        return response()->json(['success' => true, 'data' => $category]);
    }

    // POST /api/categories
    public function store(Request $request): JsonResponse
    {
        $data = $request->only(['name', 'description', 'is_active']);

        if (empty($data['name'])) {
            return response()->json(['success' => false, 'message' => 'Field name wajib diisi'], 422);
        }

        $data['slug'] = Str::slug($data['name']);

        if (Category::where('slug', $data['slug'])->exists()) {
            return response()->json(['success' => false, 'message' => 'Kategori dengan nama ini sudah ada'], 409);
        }

        $category = Category::create($data);
        return response()->json(['success' => true, 'message' => 'Kategori berhasil dibuat', 'data' => $category], 201);
    }

    // PUT /api/categories/{id}
    public function update(Request $request, int $id): JsonResponse
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['success' => false, 'message' => 'Kategori tidak ditemukan'], 404);
        }

        $data = $request->only(['name', 'description', 'is_active']);

        if (!empty($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $category->update($data);
        return response()->json(['success' => true, 'message' => 'Kategori berhasil diupdate', 'data' => $category]);
    }

    // DELETE /api/categories/{id}
    public function destroy(int $id): JsonResponse
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['success' => false, 'message' => 'Kategori tidak ditemukan'], 404);
        }

        if ($category->products()->exists()) {
            return response()->json(['success' => false, 'message' => 'Kategori tidak bisa dihapus karena masih memiliki produk'], 409);
        }

        $category->delete();
        return response()->json(['success' => true, 'message' => 'Kategori berhasil dihapus']);
    }
}
