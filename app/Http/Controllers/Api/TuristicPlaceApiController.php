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
     * List all turistic places with optional search
     */
    public function index(Request $request)
    {
        $query = TuristicPlace::with(['user', 'label'])->latest();
        
        // Si hay un parámetro de búsqueda, filtrar resultados por nombre
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }
        
        return response()->json($query->get());
    }

    /**
     * GET /api/places/{id}
     * Show single place with reviews
     */
    public function show(Request $request, $id)
    {
        $place = TuristicPlace::with(['user', 'label'])->findOrFail($id);
        $reviews = reviews::where('place_id', $id)
            ->with(['user', 'reactions'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Procesar cada review para agregar contadores y reacción del usuario
        // Intentar obtener el usuario autenticado (puede ser null si es público)
        $userId = $request->user() ? $request->user()->id : null;
        
        $reviews->each(function ($review) use ($userId) {
            // Contar likes y dislikes
            $review->likes_count = $review->reactions->where('type', 'like')->count();
            $review->dislikes_count = $review->reactions->where('type', 'dislike')->count();
            
            // Obtener reacción del usuario actual si existe
            if ($userId) {
                $userReaction = $review->reactions->first(function ($reaction) use ($userId) {
                    return $reaction->user_id === $userId;
                });
                $review->user_reaction = $userReaction ? $userReaction->type : null;
            } else {
                $review->user_reaction = null;
            }
            
            // Eliminar las reacciones del payload para reducir tamaño
            unset($review->reactions);
        });
        
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
            'preferences' => 'required|array|min:1',
            'preferences.*' => 'integer|exists:preferences,id',
            'contacto' => 'nullable|string|max:500',
            'dias_abiertos' => 'nullable',
            'estado_apertura' => 'nullable|in:open,closed_temporarily,open_with_restrictions',
            
            'portada' => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
            'clima_img' => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
            'caracteristicas_img' => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
            'flora_img' => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
            'infraestructura_img' => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
        ], [
            'nombre.required' => 'El nombre del sitio es obligatorio.',
            'nombre.max' => 'El nombre del sitio no debe tener más de 255 caracteres.',
            'slogan.required' => 'El slogan es obligatorio.',
            'slogan.max' => 'El slogan no debe tener más de 255 caracteres.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.min' => 'La descripción debe tener al menos 10 caracteres.',
            'localizacion.required' => 'La localización es obligatoria.',
            'localizacion.min' => 'La localización debe tener al menos 10 caracteres.',
            'lat.required' => 'La latitud es obligatoria. Por favor, selecciona una ubicación en el mapa.',
            'lat.numeric' => 'La latitud debe ser un número válido.',
            'lng.required' => 'La longitud es obligatoria. Por favor, selecciona una ubicación en el mapa.',
            'lng.numeric' => 'La longitud debe ser un número válido.',
            'clima.required' => 'La descripción del clima es obligatoria.',
            'clima.min' => 'La descripción del clima debe tener al menos 10 caracteres.',
            'caracteristicas.required' => 'Las características son obligatorias.',
            'caracteristicas.min' => 'Las características deben tener al menos 10 caracteres.',
            'flora.required' => 'La descripción de flora y fauna es obligatoria.',
            'flora.min' => 'La descripción de flora y fauna debe tener al menos 10 caracteres.',
            'infraestructura.required' => 'La descripción de infraestructura es obligatoria.',
            'infraestructura.min' => 'La descripción de infraestructura debe tener al menos 10 caracteres.',
            'recomendacion.required' => 'Las recomendaciones son obligatorias.',
            'recomendacion.min' => 'Las recomendaciones deben tener al menos 10 caracteres.',
            'portada.required' => 'La imagen de portada es obligatoria.',
            'portada.image' => 'El archivo de portada debe ser una imagen.',
            'portada.mimes' => 'La imagen de portada debe ser de tipo: jpg, jpeg, png o webp.',
            'portada.max' => 'La imagen de portada no debe pesar más de 4MB.',
            'clima_img.required' => 'La imagen del clima es obligatoria.',
            'clima_img.image' => 'El archivo del clima debe ser una imagen.',
            'clima_img.mimes' => 'La imagen del clima debe ser de tipo: jpg, jpeg, png o webp.',
            'clima_img.max' => 'La imagen del clima no debe pesar más de 4MB.',
            'caracteristicas_img.required' => 'La imagen de características es obligatoria.',
            'caracteristicas_img.image' => 'El archivo de características debe ser una imagen.',
            'caracteristicas_img.mimes' => 'La imagen de características debe ser de tipo: jpg, jpeg, png o webp.',
            'caracteristicas_img.max' => 'La imagen de características no debe pesar más de 4MB.',
            'flora_img.required' => 'La imagen de flora y fauna es obligatoria.',
            'flora_img.image' => 'El archivo de flora y fauna debe ser una imagen.',
            'flora_img.mimes' => 'La imagen de flora y fauna debe ser de tipo: jpg, jpeg, png o webp.',
            'flora_img.max' => 'La imagen de flora y fauna no debe pesar más de 4MB.',
            'infraestructura_img.required' => 'La imagen de infraestructura es obligatoria.',
            'infraestructura_img.image' => 'El archivo de infraestructura debe ser una imagen.',
            'infraestructura_img.mimes' => 'La imagen de infraestructura debe ser de tipo: jpg, jpeg, png o webp.',
            'infraestructura_img.max' => 'La imagen de infraestructura no debe pesar más de 4MB.',
        ]);

        $openDays = null;
        $openDaysRaw = $request->input('dias_abiertos');
        if (is_string($openDaysRaw)) {
            $decoded = json_decode($openDaysRaw, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $openDays = $decoded;
            }
        } elseif (is_array($openDaysRaw)) {
            $openDays = $openDaysRaw;
        }

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
            'contact_info' => $validated['contacto'] ?? null,
            'open_days' => $openDays,
            'opening_status' => $validated['estado_apertura'] ?? 'open',
            'cover' => $portada_path,
            'Weather_img' => $clima_path,
            'features_img' => $caracteristicas_path,
            'flora_img' => $flora_path,
            'estructure_img' => $infraestructura_path,
            'terminos' => true,
            'politicas' => true,
        ]);

        $place->label()->attach($validated['preferences']);

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
            'preferences' => 'required|array|min:1',
            'preferences.*' => 'integer|exists:preferences,id',
            'contacto' => 'nullable|string|max:500',
            'dias_abiertos' => 'nullable',
            'estado_apertura' => 'nullable|in:open,closed_temporarily,open_with_restrictions',
            
            'portada' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'clima_img' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'caracteristicas_img' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'flora_img' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'infraestructura_img' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ], [
            'nombre.required' => 'El nombre del sitio es obligatorio.',
            'nombre.max' => 'El nombre del sitio no debe tener más de 255 caracteres.',
            'slogan.required' => 'El slogan es obligatorio.',
            'slogan.max' => 'El slogan no debe tener más de 255 caracteres.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.min' => 'La descripción debe tener al menos 10 caracteres.',
            'localizacion.required' => 'La localización es obligatoria.',
            'localizacion.min' => 'La localización debe tener al menos 10 caracteres.',
            'lat.required' => 'La latitud es obligatoria. Por favor, selecciona una ubicación en el mapa.',
            'lat.numeric' => 'La latitud debe ser un número válido.',
            'lng.required' => 'La longitud es obligatoria. Por favor, selecciona una ubicación en el mapa.',
            'lng.numeric' => 'La longitud debe ser un número válido.',
            'clima.required' => 'La descripción del clima es obligatoria.',
            'clima.min' => 'La descripción del clima debe tener al menos 10 caracteres.',
            'caracteristicas.required' => 'Las características son obligatorias.',
            'caracteristicas.min' => 'Las características deben tener al menos 10 caracteres.',
            'flora.required' => 'La descripción de flora y fauna es obligatoria.',
            'flora.min' => 'La descripción de flora y fauna debe tener al menos 10 caracteres.',
            'infraestructura.required' => 'La descripción de infraestructura es obligatoria.',
            'infraestructura.min' => 'La descripción de infraestructura debe tener al menos 10 caracteres.',
            'recomendacion.required' => 'Las recomendaciones son obligatorias.',
            'recomendacion.min' => 'Las recomendaciones deben tener al menos 10 caracteres.',
            'portada.image' => 'El archivo de portada debe ser una imagen.',
            'portada.mimes' => 'La imagen de portada debe ser de tipo: jpg, jpeg, png o webp.',
            'portada.max' => 'La imagen de portada no debe pesar más de 4MB.',
            'clima_img.image' => 'El archivo del clima debe ser una imagen.',
            'clima_img.mimes' => 'La imagen del clima debe ser de tipo: jpg, jpeg, png o webp.',
            'clima_img.max' => 'La imagen del clima no debe pesar más de 4MB.',
            'caracteristicas_img.image' => 'El archivo de características debe ser una imagen.',
            'caracteristicas_img.mimes' => 'La imagen de características debe ser de tipo: jpg, jpeg, png o webp.',
            'caracteristicas_img.max' => 'La imagen de características no debe pesar más de 4MB.',
            'flora_img.image' => 'El archivo de flora y fauna debe ser una imagen.',
            'flora_img.mimes' => 'La imagen de flora y fauna debe ser de tipo: jpg, jpeg, png o webp.',
            'flora_img.max' => 'La imagen de flora y fauna no debe pesar más de 4MB.',
            'infraestructura_img.image' => 'El archivo de infraestructura debe ser una imagen.',
            'infraestructura_img.mimes' => 'La imagen de infraestructura debe ser de tipo: jpg, jpeg, png o webp.',
            'infraestructura_img.max' => 'La imagen de infraestructura no debe pesar más de 4MB.',
        ]);

        $openDays = null;
        $openDaysRaw = $request->input('dias_abiertos');
        if ($request->has('dias_abiertos')) {
            if (is_string($openDaysRaw)) {
                $decoded = json_decode($openDaysRaw, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $openDays = $decoded;
                }
            } elseif (is_array($openDaysRaw)) {
                $openDays = $openDaysRaw;
            }
        }

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
        if (array_key_exists('contacto', $validated)) {
            $place->contact_info = $validated['contacto'];
        }
        if ($request->has('dias_abiertos')) {
            $place->open_days = $openDays;
        }
        if (array_key_exists('estado_apertura', $validated)) {
            $place->opening_status = $validated['estado_apertura'] ?? $place->opening_status;
        }

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

        $place->label()->sync($validated['preferences']);

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
            $places = TuristicPlace::with('user')->where('user_id', $user->id)->get();
        } elseif ($user->role === 'admin') {
            $places = TuristicPlace::with('user')->get();
        } else {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        return response()->json($places);
    }
}
