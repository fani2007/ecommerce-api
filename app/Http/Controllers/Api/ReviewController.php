<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['user', 'product'])->get();
        return response()->json(['status' => 'success', 'data' => $reviews]);
    }

    public function store(Request $request)
    {
        $userId = $request->input('user_id');
        $productId = $request->input('product_id');
        $rating = $request->input('rating');

        if (!$userId || !$productId || !$rating) {
            return response()->json(['status' => 'error', 'message' => 'user_id, product_id, dan rating wajib diisi'], 422);
        }
        if ($rating < 1 || $rating > 5) {
            return response()->json(['status' => 'error', 'message' => 'Rating harus antara 1 sampai 5'], 422);
        }
        if (Review::where('user_id', $userId)->where('product_id', $productId)->exists()) {
            return response()->json(['status' => 'error', 'message' => 'User sudah memberikan review untuk produk ini'], 409);
        }
        $review = Review::create([
            'user_id'  => $userId,
            'product_id'  => $productId,
            'rating' => $rating,
            'comment'  => $request->input('comment'),
            'is_approved' => false,
        ]);
        return response()->json(['status' => 'success', 'message' => 'Review berhasil dikirim', 'data' => $review->load(['user', 'product'])], 201);
    }

    public function approve($id)
    {
        $review = Review::find($id);
        if (!$review) {
            return response()->json(['status' => 'error', 'message' => 'Review tidak ditemukan'], 404);
        }
        $review->update(['is_approved' => true]);
        return response()->json(['status' => 'success', 'message' => 'Review berhasil diapprove', 'data' => $review]);
    }
}
