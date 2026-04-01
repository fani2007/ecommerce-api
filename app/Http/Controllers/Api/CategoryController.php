<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

// Modul: Nabila Anjani
class CategoryController extends Controller
{
    // GET /api/categories
    public function index()
    {
        $categories = Category::withCount('products')->get();
        return response()->json([
            'status'  => 'success',
            'message' => 'Data kategori berhasil diambil',
            'data'    => $categories
        ], 200);
    }

    // POST /api/categories
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100|unique:categories,name',
            'description' => 'nullable|string',
            'is_active'   => 'nullable|boolean',
        ]);

        $data['slug'] = Str::slug($data['name']);

        $category = Category::create($data);

        return response()->json([
            'status'  => 'success',
            'message' => 'Kategori berhasil dibuat',
            'data'    => $category
        ], 201);
    }

    // GET /api/categories/{id}
    public function show($id)
    {
        $category = Category::with('products')->find($id);

        if (!$category) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Kategori tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Data kategori berhasil diambil',
            'data'    => $category
        ], 200);
    }

    // PUT /api/categories/{id}
    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Kategori tidak ditemukan'
            ], 404);
        }

        $data = $request->validate([
            'name'        => 'sometimes|string|max:100|unique:categories,name,' . $id,
            'description' => 'nullable|string',
            'is_active'   => 'nullable|boolean',
        ]);

        if (isset($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $category->update($data);

        return response()->json([
            'status'  => 'success',
            'message' => 'Kategori berhasil diperbarui',
            'data'    => $category
        ], 200);
    }

    // DELETE /api/categories/{id}
    public function destroy($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Kategori tidak ditemukan'
            ], 404);
        }

        $category->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Kategori berhasil dihapus'
        ], 200);
    }
}
