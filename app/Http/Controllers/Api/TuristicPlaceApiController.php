<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TuristicPlace;
use App\Models\reviews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class TuristicPlaceApiController extends Controller
{
    /**
     * GET /api/places
     * List all turistic places
     */
    public function index()
    {
        return response()->json(TuristicPlace::with('user')->latest()->get());
    }

    /**
     * GET /api/places/{id}
     * Show single place with reviews
     */
    public function show($id)
    {
        $place = TuristicPlace::with('user')->findOrFail($id);
        $reviews = reviews::where('place_id', $id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return response()->json([
            'place' => $place,
            'reviews' => $reviews,
        ]);
    }

    /**
     * POST /api/places
     * Create a new turistic place (operator/admin only)
     */
    public function store(Request $request)
    {
        // Authorization check
        if (!in_array($request->user()->role, ['operator', 'admin'])) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        // Validation
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'slogan' => 'required|string|max:255',
            'descripcion' => 'required|string|min:10',
            'localizacion' => 'required|string|min:10',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'clima' => 'required|string|min:10',
            'caracteristicas' => 'required|string|min:10',
            'flora' => 'required|string|min:10',
            'infraestructura' => 'required|string|min:10',
            'recomendacion' => 'required|string|min:10',
            
            'portada' => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
            'clima_img' => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
            'caracteristicas_img' => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
            'flora_img' => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
            'infraestructura_img' => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        // Store images
        $portada_path = $request->file('portada')->store('portadas', 'public');
        $clima_path = $request->file('clima_img')->store('clima', 'public');
        $caracteristicas_path = $request->file('caracteristicas_img')->store('caracteristicas', 'public');
        $flora_path = $request->file('flora_img')->store('flora', 'public');
        $infraestructura_path = $request->file('infraestructura_img')->store('infraestructura', 'public');

        // Create place
        $place = TuristicPlace::create([
            'user_id' => $request->user()->id,
            'name' => $validated['nombre'],
            'slogan' => $validated['slogan'],
            'description' => $validated['descripcion'],
            'localization' => $validated['localizacion'],
            'lat' => $validated['lat'],
            'lng' => $validated['lng'],
            'Weather' => $validated['clima'],
            'features' => $validated['caracteristicas'],
            'flora' => $validated['flora'],
            'estructure' => $validated['infraestructura'],
            'tips' => $validated['recomendacion'],
            'cover' => $portada_path,
            'Weather_img' => $clima_path,
            'features_img' => $caracteristicas_path,
            'flora_img' => $flora_path,
            'estructure_img' => $infraestructura_path,
            'terminos' => true,
            'politicas' => true,
        ]);

        return response()->json([
            'message' => 'Sitio creado exitosamente',
            'place' => $place,
        ], 201);
    }

    /**
     * PUT /api/places/{id}
     * Update a turistic place (operator/admin only)
     */
    public function update(Request $request, $id)
    {
        $place = TuristicPlace::findOrFail($id);

        // Authorization check
        if ($request->user()->id !== $place->user_id && $request->user()->role !== 'admin') {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        // Validation
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'slogan' => 'required|string|max:255',
            'descripcion' => 'required|string|min:10',
            'localizacion' => 'required|string|min:10',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'clima' => 'required|string|min:10',
            'caracteristicas' => 'required|string|min:10',
            'flora' => 'required|string|min:10',
            'infraestructura' => 'required|string|min:10',
            'recomendacion' => 'required|string|min:10',
            
            'portada' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'clima_img' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'caracteristicas_img' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'flora_img' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'infraestructura_img' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        // Update text fields
        $place->name = $validated['nombre'];
        $place->slogan = $validated['slogan'];
        $place->description = $validated['descripcion'];
        $place->localization = $validated['localizacion'];
        $place->lat = $validated['lat'];
        $place->lng = $validated['lng'];
        $place->Weather = $validated['clima'];
        $place->features = $validated['caracteristicas'];
        $place->flora = $validated['flora'];
        $place->estructure = $validated['infraestructura'];
        $place->tips = $validated['recomendacion'];

        // Update images if provided
        if ($request->hasFile('portada')) {
            if ($place->cover) Storage::disk('public')->delete($place->cover);
            $place->cover = $request->file('portada')->store('portadas', 'public');
        }
        if ($request->hasFile('clima_img')) {
            if ($place->Weather_img) Storage::disk('public')->delete($place->Weather_img);
            $place->Weather_img = $request->file('clima_img')->store('clima', 'public');
        }
        if ($request->hasFile('caracteristicas_img')) {
            if ($place->features_img) Storage::disk('public')->delete($place->features_img);
            $place->features_img = $request->file('caracteristicas_img')->store('caracteristicas', 'public');
        }
        if ($request->hasFile('flora_img')) {
            if ($place->flora_img) Storage::disk('public')->delete($place->flora_img);
            $place->flora_img = $request->file('flora_img')->store('flora', 'public');
        }
        if ($request->hasFile('infraestructura_img')) {
            if ($place->estructure_img) Storage::disk('public')->delete($place->estructure_img);
            $place->estructure_img = $request->file('infraestructura_img')->store('infraestructura', 'public');
        }

        $place->save();

        return response()->json([
            'message' => 'Sitio actualizado exitosamente',
            'place' => $place,
        ]);
    }

    /**
     * DELETE /api/places/{id}
     * Delete a turistic place (operator/admin only)
     */
    public function destroy(Request $request, $id)
    {
        $place = TuristicPlace::findOrFail($id);

        // Authorization check
        if ($request->user()->id !== $place->user_id && $request->user()->role !== 'admin') {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        // Delete images
        if ($place->cover) Storage::disk('public')->delete($place->cover);
        if ($place->Weather_img) Storage::disk('public')->delete($place->Weather_img);
        if ($place->features_img) Storage::disk('public')->delete($place->features_img);
        if ($place->flora_img) Storage::disk('public')->delete($place->flora_img);
        if ($place->estructure_img) Storage::disk('public')->delete($place->estructure_img);

        $place->delete();

        return response()->json(['message' => 'Sitio eliminado exitosamente']);
    }

    /**
     * GET /api/places/{id}/user-places
     * Get all places created by authenticated user
     */
    public function userPlaces(Request $request)
    {
        $user = $request->user();
        
        if ($user->role === 'operator') {
            $places = TuristicPlace::where('user_id', $user->id)->get();
        } elseif ($user->role === 'admin') {
            $places = TuristicPlace::all();
        } else {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        return response()->json($places);
    }
}
