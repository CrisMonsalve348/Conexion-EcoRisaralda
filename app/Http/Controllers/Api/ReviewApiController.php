<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\reviews;
use Illuminate\Http\Request;

class ReviewApiController extends Controller
{
    /**
     * POST /api/places/{id}/reviews
     * Create a new review (authenticated user)
     */
    public function store(Request $request, $placeId)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000',
        ]);

        $review = reviews::create([
            'user_id' => $request->user()->id,
            'place_id' => $placeId,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        $review->load('user');

        return response()->json([
            'message' => 'Reseña creada exitosamente',
            'review' => $review,
        ], 201);
    }

    /**
     * DELETE /api/reviews/{id}
     * Delete a review (owner or admin only)
     */
    public function destroy(Request $request, $id)
    {
        $review = reviews::findOrFail($id);

        // Authorization check
        if ($request->user()->id !== $review->user_id && $request->user()->role !== 'admin') {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $review->delete();

        return response()->json(['message' => 'Reseña eliminada exitosamente']);
    }
}
