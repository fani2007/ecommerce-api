<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ReviewController extends Controller
{
    // GET /api/reviews
    public function index(): JsonResponse
    {
        $reviews = Review::with(['user', 'product'])->get();
        return response()->json(['success' => true, 'data' => $reviews]);
    }

    // GET /api/reviews/{id}
    public function show(int $id): JsonResponse
    {
        $review = Review::with(['user', 'product'])->find($id);

        if (!$review) {
            return response()->json(['success' => false, 'message' => 'Review tidak ditemukan'], 404);
        }

        return response()->json(['success' => true, 'data' => $review]);
    }

    // POST /api/reviews
    public function store(Request $request): JsonResponse
    {
        $userId    = $request->input('user_id');
        $productId = $request->input('product_id');
        $rating    = $request->input('rating');

        if (!$userId || !$productId || !$rating) {
            return response()->json(['success' => false, 'message' => 'user_id, product_id, dan rating wajib diisi'], 422);
        }

        if ($rating < 1 || $rating > 5) {
            return response()->json(['success' => false, 'message' => 'Rating harus antara 1 sampai 5'], 422);
        }

        if (Review::where('user_id', $userId)->where('product_id', $productId)->exists()) {
            return response()->json(['success' => false, 'message' => 'User sudah memberikan review untuk produk ini'], 409);
        }

        $review = Review::create([
            'user_id'     => $userId,
            'product_id'  => $productId,
            'rating'      => $rating,
            'comment'     => $request->input('comment'),
            'is_approved' => false,
        ]);

        return response()->json(['success' => true, 'message' => 'Review berhasil dikirim', 'data' => $review->load(['user', 'product'])], 201);
    }

    // GET /api/reviews/product/{productId} — semua review untuk produk tertentu
    public function byProduct(int $productId): JsonResponse
    {
        $reviews = Review::with('user')
            ->where('product_id', $productId)
            ->where('is_approved', true)
            ->get();

        return response()->json(['success' => true, 'data' => $reviews]);
    }

    // PUT /api/reviews/{id}/approve — approve review
    public function approve(int $id): JsonResponse
    {
        $review = Review::find($id);

        if (!$review) {
            return response()->json(['success' => false, 'message' => 'Review tidak ditemukan'], 404);
        }

        if ($review->is_approved) {
            return response()->json(['success' => false, 'message' => 'Review sudah diapprove sebelumnya'], 409);
        }

        $review->update(['is_approved' => true]);
        return response()->json(['success' => true, 'message' => 'Review berhasil diapprove', 'data' => $review]);
    }

    // DELETE /api/reviews/{id}
    public function destroy(int $id): JsonResponse
    {
        $review = Review::find($id);

        if (!$review) {
            return response()->json(['success' => false, 'message' => 'Review tidak ditemukan'], 404);
        }

        $review->delete();
        return response()->json(['success' => true, 'message' => 'Review berhasil dihapus']);
    }
}
