<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\reviews;
use App\Models\ReviewReaction;
use Illuminate\Http\Request;
use Waad\ProfanityFilter\Facades\ProfanityFilter;

class ReviewApiController extends Controller
{
    /**
     * POST /api/places/{id}/reviews
     * Create a new review (authenticated user)
     */
    public function store(Request $request, $placeId)
    {
        // Limitar a 3 comentarios por usuario por sitio al día
        $today = now()->startOfDay();
        $commentsToday = reviews::where('user_id', $request->user()->id)
            ->where('place_id', $placeId)
            ->where('created_at', '>=', $today)
            ->count();
        if ($commentsToday >= 3) {
            return response()->json([
                'message' => 'Solo puedes hacer hasta 3 comentarios por día en este sitio.'
            ], 429);
        }
        // Verificar si el usuario ya ha comentado este sitio
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => [
                'required',
                'string',
                'min:10',
                'max:1000',
                function ($attribute, $value, $fail) {
                    if (ProfanityFilter::hasProfanity($value)) {
                        $fail('El comentario contiene lenguaje inapropiado. Por favor, utiliza un lenguaje respetuoso.');
                    }
                }
            ],
        ]);
        $review = reviews::create([
            'user_id' => $request->user()->id,
            'place_id' => $placeId,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        $review->load('user');
        // Agregar contadores inicializados
        $review->likes_count = 0;
        $review->dislikes_count = 0;
        $review->user_reaction = null;

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

    /**
     * PUT /api/reviews/{id}
     * Update a review (owner or admin only)
     */
    public function update(Request $request, $id)
    {
        $review = reviews::findOrFail($id);

        // Authorization check
        if ($request->user()->id !== $review->user_id && $request->user()->role !== 'admin') {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $validated = $request->validate([
            'rating' => 'nullable|integer|min:1|max:5',
            'comment' => [
                'nullable',
                'string',
                'min:10',
                'max:1000',
                function ($attribute, $value, $fail) {
                    if ($value && ProfanityFilter::hasProfanity($value)) {
                        $fail('El comentario contiene lenguaje inapropiado. Por favor, utiliza un lenguaje respetuoso.');
                    }
                }
            ],
        ]);

        if (array_key_exists('rating', $validated)) {
            $review->rating = $validated['rating'];
        }
        if (array_key_exists('comment', $validated)) {
            $review->comment = $validated['comment'];
            // Si el comentario fue restringido y ahora no tiene palabras inapropiadas, desrestringirlo
            if ($review->is_restricted && !ProfanityFilter::hasProfanity($validated['comment'])) {
                $review->is_restricted = false;
                $review->restricted_by_role = null;
                $review->restriction_reason = null;
            }
        }

        $review->save();
        $review->load(['user', 'reactions']);
        
        // Agregar contadores y reacción del usuario
        $review->likes_count = $review->reactions->where('type', 'like')->count();
        $review->dislikes_count = $review->reactions->where('type', 'dislike')->count();
        
        $userId = $request->user()->id;
        $userReaction = $review->reactions->first(function ($reaction) use ($userId) {
            return $reaction->user_id === $userId;
        });
        $review->user_reaction = $userReaction ? $userReaction->type : null;
        
        unset($review->reactions);

        return response()->json([
            'message' => 'Reseña actualizada exitosamente',
            'review' => $review,
        ]);
    }

    /**
     * POST /api/reviews/{id}/react
     * Add or update a reaction (like/dislike) to a review
     */
    public function react(Request $request, $id)
    {
        $validated = $request->validate([
            'type' => 'required|in:like,dislike',
        ]);

        $review = reviews::findOrFail($id);
        $userId = $request->user()->id;

        // Buscar reacción existente
        $reaction = ReviewReaction::where('review_id', $id)
            ->where('user_id', $userId)
            ->first();

        if ($reaction) {
            if ($reaction->type === $validated['type']) {
                // Si es la misma reacción, eliminarla (toggle)
                $reaction->delete();
                return response()->json([
                    'message' => 'Reacción eliminada',
                    'reaction' => null,
                ]);
            } else {
                // Si es diferente, actualizarla
                $reaction->type = $validated['type'];
                $reaction->save();
                return response()->json([
                    'message' => 'Reacción actualizada',
                    'reaction' => $reaction,
                ]);
            }
        } else {
            // Crear nueva reacción
            $reaction = ReviewReaction::create([
                'review_id' => $id,
                'user_id' => $userId,
                'type' => $validated['type'],
            ]);
            return response()->json([
                'message' => 'Reacción agregada',
                'reaction' => $reaction,
            ], 201);
        }
    }
}
