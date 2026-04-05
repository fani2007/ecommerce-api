<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Category;
use Symfony\Component\HttpFoundation\Response;

class CheckCategoryActive
{
    public function handle(Request $request, Closure $next): Response
    {
        $categoryId = $request->input('category_id') ?? $request->route('id');

        if ($categoryId) {
            $category = Category::find($categoryId);

            if ($category && !$category->is_active) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kategori tidak aktif, tidak bisa digunakan',
                ], 403);
            }
        }

        return $next($request);
    }
}
