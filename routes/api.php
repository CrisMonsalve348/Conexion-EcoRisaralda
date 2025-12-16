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
    return \App\Models\preference::all();
});

// Turistic places - read only (public)
Route::get('/places', [TuristicPlaceApiController::class, 'index']);
Route::get('/places/{id}', [TuristicPlaceApiController::class, 'show']);

// ============ AUTH ROUTES (SPA) - WITHOUT CSRF BUT WITH SESSION ============
// Estas rutas necesitan sesión pero omiten CSRF para el primer contacto del cliente SPA
Route::middleware('web')->group(function () {
    Route::post('/register', function (Request $request) {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:turist,operator,user,admin',
            'country' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
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

        Auth::login($user);

        if (method_exists($user, 'sendEmailVerificationNotification')) {
            $user->sendEmailVerificationNotification();
        }

        return response()->json([
            'user' => $user,
            'message' => 'Registro exitoso. Revisa tu correo para verificar la cuenta.',
        ]);
    });

    Route::post('/login', function (Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            
            // Generar Sanctum token para SPA
            $token = $user->createToken('api-token')->plainTextToken;
            
            return response()->json([
                'user' => $user,
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
            return response()->json(['message' => __($status)]);
        }

        return response()->json(['message' => __($status)], 422);
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
            return response()->json(['message' => __($status)]);
        }

        return response()->json(['message' => __($status)], 422);
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
                $userData['avatar_url'] = asset('storage/' . $user->image);
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
                $userData['avatar_url'] = asset('storage/' . $user->image);
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
            $userData['avatar_url'] = asset('storage/'.$path);

            return response()->json([
                'message' => 'Foto actualizada',
                'avatar_url' => asset('storage/'.$path),
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
                $userData['avatar_url'] = asset('storage/' . $user->image);
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

        // ============ TURISTIC PLACES - CREATE/UPDATE/DELETE ============
        Route::post('/places', [TuristicPlaceApiController::class, 'store']);
        Route::put('/places/{id}', [TuristicPlaceApiController::class, 'update']);
        Route::delete('/places/{id}', [TuristicPlaceApiController::class, 'destroy']);
        Route::get('/user-places', [TuristicPlaceApiController::class, 'userPlaces']);

        // ============ REVIEWS ============
        Route::post('/places/{id}/reviews', [ReviewApiController::class, 'store']);
        Route::delete('/reviews/{id}', [ReviewApiController::class, 'destroy']);

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
