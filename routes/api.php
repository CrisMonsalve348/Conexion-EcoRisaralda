<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TuristicPlace;
use App\Models\reviews;
use App\Models\PlaceEvent;
use App\Http\Controllers\Api\TuristicPlaceApiController;
use App\Http\Controllers\Api\ReviewApiController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

Route::get('/health', function() {
    return response()->json(['status' => 'ok']);
});

// DEV: Quick Mailtrap test endpoint (remove in production)
Route::get('/dev/test-mail', function() {
    Mail::raw('Prueba de Mailtrap desde EcoRisaralda', function ($message) {
        $message->to('test@example.com')
                ->subject('Test Mailtrap');
    });
    return response()->json(['sent' => true]);
});

// DEV: List users from current database connection (SQLite by default)
Route::get('/dev/users', function() {
    return DB::table('users')->select('id','name','email','email_verified_at','created_at')->orderBy('id','desc')->get();
});

// DEV: Normalize roles to MySQL enum values
Route::get('/dev/fix-roles', function() {
    $countTurist = DB::table('users')->where('role','turist')->update(['role' => 'user']);
    $countNull = DB::table('users')->whereNull('role')->orWhere('role','')->update(['role' => 'user']);
    return response()->json(['turist_to_user' => $countTurist, 'null_to_user' => $countNull]);
});

// ============ PUBLIC ENDPOINTS ============
Route::get('/preferences', function () {
    if (\App\Models\preference::count() === 0) {
        $defaults = [
            ['name' => 'Senderismo', 'image' => 'hiking', 'color' => 'FF6B6B'],
            ['name' => 'Avistamiento de aves', 'image' => 'birdwatching', 'color' => 'FFA500'],
            ['name' => 'Ciclismo de montaña', 'image' => 'biking', 'color' => '4ECDC4'],
            ['name' => 'Escalada o rappel', 'image' => 'climbing', 'color' => 'FFD93D'],
            ['name' => 'Fauna y voluntariado', 'image' => 'wildlife', 'color' => '6BCB77'],
            ['name' => 'Reservas naturales', 'image' => 'reserves', 'color' => '8B6F47'],
            ['name' => 'Kayak o canoa', 'image' => 'kayaking', 'color' => '4D96FF'],
            ['name' => 'Baños de bosque', 'image' => 'forest_bathing', 'color' => '52B788'],
        ];

        foreach ($defaults as $item) {
            \App\Models\preference::firstOrCreate(
                ['name' => $item['name']],
                ['image' => $item['image'], 'color' => $item['color']]
            );
        }
    }

    return \App\Models\preference::all();
});

// Servir archivos desde storage (avatares, imágenes, etc)
Route::get('/files/{type}/{filename}', function ($type, $filename) {
    $path = storage_path("app/public/{$type}/{$filename}");
    
    // Validar que el archivo existe
    if (!file_exists($path)) {
        return response()->json(['message' => 'Archivo no encontrado'], 404);
    }
    
    // Retornar el archivo
    return response()->file($path);
})->where('filename', '.*');

// Estas rutas necesitan sesión pero omiten CSRF para el primer contacto del cliente SPA
Route::middleware('web')->group(function () {
    // Turistic places - read only (public but session-aware)
    Route::get('/places', [TuristicPlaceApiController::class, 'index']);
    Route::get('/places/{id}', [TuristicPlaceApiController::class, 'show']);
    
    Route::post('/register', function (Request $request) {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                'string',
                'min:8',
                'max:15',
                'regex:/[a-z]/',      // al menos una minúscula
                'regex:/[A-Z]/',      // al menos una mayúscula
                'regex:/[0-9]/',      // al menos un dígito
            ],
            'role' => 'required|in:turist,operator,user,admin',
            'country' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date|before:-16 years',
        ], [
            'birth_date.before' => 'Debes ser mayor de 16 años para registrarte',
            'password.min' => 'La contraseña debe tener entre 8 y 15 caracteres',
            'password.max' => 'La contraseña debe tener entre 8 y 15 caracteres',
            'password.regex' => 'La contraseña debe incluir al menos una mayúscula, una minúscula y un dígito',
        ]);

        $role = $data['role'];
        if ($role === 'turist') { $role = 'user'; }
        if (! in_array($role, ['user','operator','admin'])) { $role = 'user'; }

        $user = User::create([
            'name' => $data['name'],
            'last_name' => $data['last_name'] ?? null,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $role,
            'Country' => $data['country'] ?? null,
            'date_of_birth' => $data['birth_date'] ?? null,
        ]);

        if (method_exists($user, 'sendEmailVerificationNotification')) {
            $user->sendEmailVerificationNotification();
        }

        return response()->json([
            'message' => 'Registro exitoso. Revisa tu correo para verificar la cuenta.',
        ]);
    });

    Route::post('/login', function (Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            // Verificar si el email está verificado
            if (!$user->hasVerifiedEmail()) {
                Auth::logout();
                return response()->json([
                    'message' => 'Debes verificar tu correo electrónico antes de iniciar sesión. Revisa tu bandeja de entrada.',
                ], 403);
            }
            
            $request->session()->regenerate();
            
            // Generar Sanctum token para SPA
            $token = $user->createToken('api-token')->plainTextToken;
            
            $userData = $user->toArray();
            if ($user->image) {
                $imagePath = str_replace('\\', '/', $user->image);
                $userData['avatar_url'] = url('/api/files/' . $imagePath);
            }
            
            return response()->json([
                'user' => $userData,
                'token' => $token,
                'message' => 'Inicio de sesión exitoso',
            ]);
        }

        return response()->json([
            'message' => 'Credenciales incorrectas',
        ], 401);
    });

    Route::post('/forgot-password', function (Request $request) {
        $request->validate(['email' => 'required|email']);
        $status = Password::sendResetLink($request->only('email'));
        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['message' => __('passwords.sent')]);
        }

        return response()->json(['message' => __('passwords.user')], 422);
    });

    Route::post('/reset-password', function (Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return response()->json(['message' => __('passwords.reset')]);
        }

        return response()->json(['message' => __('passwords.token')], 422);
    });
});

// ============ AUTHENTICATED ROUTES ============
Route::middleware(['web', 'auth:sanctum'])->group(function () {
        Route::post('/logout', function (Request $request) {
            // Revocar todos los tokens Sanctum del usuario
            try {
                $request->user()->tokens()->delete();
            } catch (\Exception $e) {
                // Ignorar si no hay tokens
            }
            
            // Cerrar sesión web si existe
            try {
                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
            } catch (\Exception $e) {
                // Ignorar errores de sesión
            }
            
            return response()->json(['message' => 'Sesión cerrada']);
        });

        // Perfil: obtener perfil actual
        Route::get('/profile', function (Request $request) {
            $user = $request->user();
            $userData = $user->toArray();
            // Agregar URL completa del avatar si existe
            if ($user->image) {
                $imagePath = str_replace('\\', '/', $user->image);
                $userData['avatar_url'] = url('/api/files/' . $imagePath);
            }
            return response()->json($userData);
        });

        // Perfil: actualizar datos básicos
        Route::put('/profile', function (Request $request) {
            $user = $request->user();
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'last_name' => 'nullable|string|max:255',
                'email' => 'required|email|unique:users,email,'.$user->id,
            ]);

            $user->name = $data['name'];
            $user->last_name = $data['last_name'] ?? null;
            $user->email = $data['email'];
            $user->save();

            // Incluir avatar_url en la respuesta
            $userData = $user->toArray();
            if ($user->image) {
                $imagePath = str_replace('\\', '/', $user->image);
                $userData['avatar_url'] = url('/api/files/' . $imagePath);
            }

            return response()->json(['user' => $userData, 'message' => 'Perfil actualizado']);
        });

        // Perfil: cambiar contraseña
        Route::post('/profile/password', function (Request $request) {
            $user = $request->user();
            $data = $request->validate([
                'current_password' => 'required|string',
                'password' => 'required|string|min:8|confirmed',
            ]);

            if (! Hash::check($data['current_password'], $user->password)) {
                return response()->json(['message' => 'La contraseña actual es incorrecta'], 422);
            }

            $user->password = Hash::make($data['password']);
            $user->setRememberToken(Str::random(60));
            $user->save();

            $request->session()->regenerate();

            return response()->json(['message' => 'Contraseña actualizada']);
        });

        // Perfil: eliminar cuenta
        Route::post('/profile/delete', function (Request $request) {
            $user = $request->user();
            $data = $request->validate([
                'current_password' => 'required|string',
            ]);

            if (! Hash::check($data['current_password'], $user->password)) {
                return response()->json(['message' => 'La contraseña actual es incorrecta'], 422);
            }

            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }

            // Mantener reseñas, pero desvincular al usuario
            reviews::where('user_id', $user->id)->update(['user_id' => null]);

            try {
                $user->tokens()->delete();
            } catch (\Exception $e) {
                // Ignorar si no hay tokens
            }

            try {
                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
            } catch (\Exception $e) {
                // Ignorar errores de sesión
            }

            $user->delete();

            return response()->json(['message' => 'Cuenta eliminada']);
        });

        // Perfil: subir foto
        Route::post('/profile/avatar', function (Request $request) {
            $request->validate([
                'avatar' => 'required|image|max:2048',
            ]);

            $user = $request->user();
            $path = $request->file('avatar')->store('avatars', 'public');

            // Guardamos en la columna image
            $user->image = $path;
            $user->save();

            // Preparar respuesta con avatar_url incluido
            $userData = $user->toArray();
            $imagePath = str_replace('\\', '/', $path);
            $userData['avatar_url'] = url('/api/files/' . $imagePath);

            return response()->json([
                'message' => 'Foto actualizada',
                'avatar_url' => url('/api/files/' . $imagePath),
                'user' => $userData,
            ]);
        });

        // Perfil: eliminar foto (restaurar avatar por defecto)
        Route::delete('/profile/avatar', function (Request $request) {
            $user = $request->user();

            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }

            $user->image = null;
            $user->save();

            $userData = $user->toArray();
            $userData['avatar_url'] = null;

            return response()->json([
                'message' => 'Foto eliminada',
                'avatar_url' => null,
                'user' => $userData,
            ]);
        });

        // Reenviar verificación de email
        Route::post('/email/verification-notification', function (Request $request) {
            if ($request->user()->hasVerifiedEmail()) {
                return response()->json(['message' => 'El correo ya está verificado']);
            }

            $request->user()->sendEmailVerificationNotification();

            return response()->json(['message' => 'Enlace de verificación enviado']);
        })->middleware('throttle:6,1');

        Route::get('/user', function (Request $request) {
            $user = $request->user();
            $userData = $user->toArray();
            // Agregar URL completa del avatar si existe
            if ($user->image) {
                $imagePath = str_replace('\\', '/', $user->image);
                $userData['avatar_url'] = url('/api/files/' . $imagePath);
            }
            return response()->json($userData);
        });

        // ============ USER PREFERENCES ============
        Route::get('/user/preferences', function (Request $request) {
            return $request->user()->preferences()->get();
        });
        Route::post('/user/preferences', function (Request $request) {
            $validated = $request->validate([
                'preferences' => 'required|array|min:1',
                'preferences.*' => 'integer|exists:preferences,id',
            ]);
            $request->user()->preferences()->sync($validated['preferences']);
            // Marcar que ya pasó por preferencias
            $request->user()->update(['first_time_preferences' => false]);
            return response()->json(['message' => 'Preferencias actualizadas']);
        });
        Route::get('/user/first-time-preferences', function (Request $request) {
            return response()->json([
                'first_time' => $request->user()->first_time_preferences
            ]);
        });

        // Recomendaciones basadas en preferencias del usuario
        Route::get('/recommendations', function (Request $request) {
            $user = $request->user();
            $preferenceIds = $user->preferences()->pluck('preferences.id')->toArray();

            if (count($preferenceIds) === 0) {
                return response()->json([]);
            }

            $places = TuristicPlace::with('label')
                ->whereHas('label', function ($query) use ($preferenceIds) {
                    $query->whereIn('preferences.id', $preferenceIds);
                })
                ->latest()
                ->take(12)
                ->get();

            return response()->json($places);
        });

        // ============ FAVORITOS ============
        Route::get('/favorites', function (Request $request) {
            return $request->user()->favoritePlaces()->get();
        });

        Route::post('/places/{id}/favorite', function (Request $request, $id) {
            $place = TuristicPlace::findOrFail($id);
            $request->user()->favoritePlaces()->syncWithoutDetaching([$place->id]);

            return response()->json(['message' => 'Agregado a favoritos']);
        });

        Route::delete('/places/{id}/favorite', function (Request $request, $id) {
            $request->user()->favoritePlaces()->detach($id);
            return response()->json(['message' => 'Eliminado de favoritos']);
        });

        // ============ HISTORIAL (TURISTA) ============
        Route::post('/places/{id}/visit', function (Request $request, $id) {
            $user = $request->user();
            $place = TuristicPlace::findOrFail($id);
            $now = now();

            $exists = DB::table('user_place_visits')
                ->where('user_id', $user->id)
                ->where('place_id', $place->id)
                ->exists();

            if ($exists) {
                DB::table('user_place_visits')
                    ->where('user_id', $user->id)
                    ->where('place_id', $place->id)
                    ->update([
                        'visited_at' => $now,
                        'updated_at' => $now,
                    ]);
            } else {
                DB::table('user_place_visits')->insert([
                    'user_id' => $user->id,
                    'place_id' => $place->id,
                    'visited_at' => $now,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }

            return response()->json(['message' => 'Visita registrada']);
        });

        Route::get('/user/history', function (Request $request) {
            $limit = (int) $request->query('limit', 8);
            $limit = $limit > 0 ? $limit : 8;

            $items = DB::table('user_place_visits')
                ->where('user_place_visits.user_id', $request->user()->id)
                ->join('turistic_places', 'user_place_visits.place_id', '=', 'turistic_places.id')
                ->select(
                    'user_place_visits.id',
                    'user_place_visits.place_id',
                    'user_place_visits.visited_at',
                    'turistic_places.name as place_name',
                    'turistic_places.localization as place_localization'
                )
                ->orderByDesc('user_place_visits.visited_at')
                ->limit($limit)
                ->get()
                ->map(function ($row) {
                    return [
                        'id' => $row->id,
                        'visited_at' => $row->visited_at,
                        'place' => [
                            'id' => $row->place_id,
                            'name' => $row->place_name,
                            'localization' => $row->place_localization,
                        ],
                    ];
                });

            return response()->json($items);
        });

        Route::get('/user/reviews', function (Request $request) {
            $limit = (int) $request->query('limit', 8);
            $limit = $limit > 0 ? $limit : 8;

            $items = reviews::with(['place:id,name'])
                ->where('user_id', $request->user()->id)
                ->orderBy('created_at', 'desc')
                ->limit($limit)
                ->get();

            return response()->json($items);
        });

        Route::get('/events/next', function () {
            $expiredEvents = PlaceEvent::where('starts_at', '<', now())->get();
            foreach ($expiredEvents as $expiredEvent) {
                if ($expiredEvent->image) {
                    Storage::disk('public')->delete($expiredEvent->image);
                }
                $expiredEvent->delete();
            }
            $event = PlaceEvent::with('place:id,name')
                ->where('starts_at', '>=', now())
                ->orderBy('starts_at', 'asc')
                ->first();

            return response()->json([
                'event' => $event,
            ]);
        });

        Route::get('/events/upcoming', function (Request $request) {
            $expiredEvents = PlaceEvent::where('starts_at', '<', now())->get();
            foreach ($expiredEvents as $expiredEvent) {
                if ($expiredEvent->image) {
                    Storage::disk('public')->delete($expiredEvent->image);
                }
                $expiredEvent->delete();
            }
            $limit = (int) $request->query('limit', 5);
            $limit = $limit > 0 ? $limit : 5;

            $events = PlaceEvent::with('place:id,name')
                ->where('starts_at', '>=', now())
                ->orderBy('starts_at', 'asc')
                ->limit($limit)
                ->get();

            return response()->json([
                'events' => $events,
            ]);
        });

        // ============ TURISTIC PLACES - CREATE/UPDATE/DELETE ============
        Route::post('/places', [TuristicPlaceApiController::class, 'store']);
        Route::put('/places/{id}', [TuristicPlaceApiController::class, 'update']);
        Route::delete('/places/{id}', [TuristicPlaceApiController::class, 'destroy']);
        Route::get('/user-places', [TuristicPlaceApiController::class, 'userPlaces']);

        // ============ REVIEWS ============
        Route::post('/places/{id}/reviews', [ReviewApiController::class, 'store']);
        Route::put('/reviews/{id}', [ReviewApiController::class, 'update']);
        Route::delete('/reviews/{id}', [ReviewApiController::class, 'destroy']);
        Route::post('/reviews/{id}/react', [ReviewApiController::class, 'react']);

        // ============ OPERATOR REVIEW MODERATION ============
        Route::middleware('role:operator')->prefix('operator')->group(function () {
            Route::post('/reviews/{id}/restrict', function (Request $request, $id) {
                $data = $request->validate([
                    'reason' => 'required|in:insultos,spam',
                ]);

                $review = reviews::with('place')->findOrFail($id);
                if (! $review->place || $review->place->user_id !== $request->user()->id) {
                    return response()->json(['message' => 'No autorizado'], 403);
                }

                $review->update([
                    'is_restricted' => true,
                    'restricted_by_role' => 'operator',
                    'restriction_reason' => $data['reason'],
                ]);

                return response()->json([
                    'message' => 'Reseña restringida exitosamente',
                    'review' => $review,
                ]);
            });

            Route::post('/reviews/{id}/unrestrict', function (Request $request, $id) {
                $review = reviews::with('place')->findOrFail($id);
                if (! $review->place || $review->place->user_id !== $request->user()->id) {
                    return response()->json(['message' => 'No autorizado'], 403);
                }

                $review->update([
                    'is_restricted' => false,
                    'restricted_by_role' => null,
                    'restriction_reason' => null,
                ]);

                return response()->json([
                    'message' => 'Reseña desrestringida exitosamente',
                    'review' => $review,
                ]);
            });
        });

        // ============ ADMIN ROUTES ============
        Route::middleware('role:admin')->prefix('admin')->group(function () {
            // Dashboard con estadísticas
            Route::get('/dashboard', function () {
                $totalUsers = User::count();
                $totalOperators = User::where('role', 'operator')->count();
                $pendingOperators = User::where('role', 'operator')->where('status', 'pending')->count();
                $totalTuristas = User::where('role', 'user')->count();
                $totalPlaces = DB::table('turistic_places')->count();

                return response()->json([
                    'total_users' => $totalUsers,
                    'total_operators' => $totalOperators,
                    'pending_operators' => $pendingOperators,
                    'total_turistas' => $totalTuristas,
                    'total_places' => $totalPlaces,
                ]);
            });

            // Listar todos los usuarios
            Route::get('/users', function (Request $request) {
                $query = User::query();
                
                // Filtros opcionales
                if ($request->has('role')) {
                    $query->where('role', $request->role);
                }
                if ($request->has('status')) {
                    $query->where('status', $request->status);
                }
                
                $users = $query->orderBy('created_at', 'desc')->get();
                return response()->json($users);
            });

            // Crear operador (admin crea credenciales)
            Route::post('/users', function (Request $request) {
                $data = $request->validate([
                    'name' => 'required|string|max:255',
                    'last_name' => 'nullable|string|max:255',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required|string|min:8',
                    'role' => 'required|in:user,operator,admin',
                    'country' => 'nullable|string|max:255',
                    'birth_date' => 'nullable|date',
                ]);

                $user = User::create([
                    'name' => $data['name'],
                    'last_name' => $data['last_name'] ?? null,
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                    'role' => $data['role'],
                    'Country' => $data['country'] ?? null,
                    'date_of_birth' => $data['birth_date'] ?? null,
                    'status' => $data['role'] === 'operator' ? 'approved' : 'active',
                    'email_verified_at' => now(), // Admin-created accounts are pre-verified
                ]);

                return response()->json([
                    'user' => $user,
                    'message' => 'Usuario creado exitosamente',
                ], 201);
            });

            // Obtener un usuario específico
            Route::get('/users/{id}', function ($id) {
                $user = User::findOrFail($id);
                return response()->json($user);
            });

            // Actualizar usuario (cambiar rol, status, etc.)
            Route::put('/users/{id}', function (Request $request, $id) {
                $user = User::findOrFail($id);
                
                $data = $request->validate([
                    'name' => 'sometimes|string|max:255',
                    'last_name' => 'sometimes|string|max:255',
                    'email' => 'sometimes|email|unique:users,email,'.$id,
                    'role' => 'sometimes|in:user,operator,admin',
                    'status' => 'sometimes|in:pending,approved,rejected,active',
                    'country' => 'nullable|string|max:255',
                    'birth_date' => 'nullable|date',
                ]);

                $user->update($data);

                return response()->json([
                    'user' => $user,
                    'message' => 'Usuario actualizado exitosamente',
                ]);
            });

            // Eliminar usuario
            Route::delete('/users/{id}', function ($id) {
                $user = User::findOrFail($id);
                
                // Prevenir que el admin se elimine a sí mismo
                if ($user->id === auth()->id()) {
                    return response()->json([
                        'message' => 'No puedes eliminar tu propia cuenta',
                    ], 403);
                }

                $user->delete();

                return response()->json([
                    'message' => 'Usuario eliminado exitosamente',
                ]);
            });

            // Operadores pendientes de aprobación
            Route::get('/operators/pending', function () {
                $pendingOperators = User::where('role', 'operator')
                    ->where('status', 'pending')
                    ->orderBy('created_at', 'desc')
                    ->get();
                
                return response()->json($pendingOperators);
            });

            // Aprobar/rechazar operador
            Route::post('/operators/{id}/approve', function ($id) {
                $operator = User::findOrFail($id);
                
                if ($operator->role !== 'operator') {
                    return response()->json(['message' => 'Este usuario no es un operador'], 400);
                }

                $operator->update(['status' => 'approved']);

                return response()->json([
                    'user' => $operator,
                    'message' => 'Operador aprobado exitosamente',
                ]);
            });

            Route::post('/operators/{id}/reject', function ($id) {
                $operator = User::findOrFail($id);
                
                if ($operator->role !== 'operator') {
                    return response()->json(['message' => 'Este usuario no es un operador'], 400);
                }

                $operator->update(['status' => 'rejected']);

                return response()->json([
                    'user' => $operator,
                    'message' => 'Operador rechazado',
                ]);
            });

            // Gestión de sitios turísticos (todos los sitios)
            Route::get('/places', [TuristicPlaceApiController::class, 'index']);
            Route::delete('/places/{id}', [TuristicPlaceApiController::class, 'destroy']);

            // Gestión de reseñas (admin)
            Route::get('/reviews', function () {
                return \App\Models\reviews::with([
                        'user:id,name',
                        'place:id,name'
                    ])
                    ->orderBy('created_at', 'desc')
                    ->get();
            });

            // Restringir reseña (admin)
            Route::post('/reviews/{id}/restrict', function ($id) {
                $review = \App\Models\reviews::findOrFail($id);
                $review->update([
                    'is_restricted' => true,
                    'restricted_by_role' => 'admin',
                    'restriction_reason' => null,
                ]);
                
                return response()->json([
                    'message' => 'Reseña restringida exitosamente',
                    'review' => $review,
                ]);
            });

            // Desrestringir reseña (admin)
            Route::post('/reviews/{id}/unrestrict', function ($id) {
                $review = \App\Models\reviews::findOrFail($id);
                $review->update([
                    'is_restricted' => false,
                    'restricted_by_role' => null,
                    'restriction_reason' => null,
                ]);
                
                return response()->json([
                    'message' => 'Reseña desrestringida exitosamente',
                    'review' => $review,
                ]);
            });
        });

        // ============ ADMIN: ETIQUETAS ============
        Route::middleware('role:admin')->prefix('admin')->group(function () {
            Route::get('/preferences', function () {
                return \App\Models\preference::orderBy('name')->get();
            });

            Route::post('/preferences', function (Request $request) {
                $data = $request->validate([
                    'name' => 'required|string|max:255',
                    'image' => 'nullable|string|max:255',
                    'color' => 'required|string|max:20',
                ]);

                if (empty($data['image'])) {
                    $data['image'] = Str::slug($data['name'], '_');
                }

                $pref = \App\Models\preference::create($data);

                return response()->json(['preference' => $pref, 'message' => 'Etiqueta creada']);
            });

            Route::put('/preferences/{id}', function (Request $request, $id) {
                $pref = \App\Models\preference::findOrFail($id);
                $data = $request->validate([
                    'name' => 'required|string|max:255',
                    'image' => 'nullable|string|max:255',
                    'color' => 'required|string|max:20',
                ]);

                if (empty($data['image'])) {
                    $data['image'] = Str::slug($data['name'], '_');
                }

                $pref->update($data);

                return response()->json(['preference' => $pref, 'message' => 'Etiqueta actualizada']);
            });

            Route::delete('/preferences/{id}', function ($id) {
                $pref = \App\Models\preference::findOrFail($id);
                $pref->delete();

                return response()->json(['message' => 'Etiqueta eliminada']);
            });
        });
    });

// Verificar email (enlace firmado) y redirigir al frontend
Route::middleware('web')->get('/email/verify/{id}/{hash}', function (Request $request) {
    $user = User::findOrFail($request->route('id'));

    if (! hash_equals(sha1($user->getEmailForVerification()), (string) $request->route('hash'))) {
        abort(403);
    }

    if (! $user->hasVerifiedEmail()) {
        $user->markEmailAsVerified();
        event(new Verified($user));
    }

    $frontend = config('app.frontend_url', env('FRONTEND_URL', 'http://localhost:5173'));
    return redirect()->away(rtrim($frontend, '/') . '/email-verified?verified=1');
})->name('api.verification.verify')->middleware('throttle:6,1');
