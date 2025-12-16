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

// ============ AUTH ROUTES (SPA) ============
Route::middleware('web')->group(function () {
    // Registro SPA con mapeo de rol al enum de MySQL
    Route::post('/register', function (Request $request) {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            // Accept legacy 'turist' from the frontend but map to MySQL enum
            'role' => 'required|in:turist,operator,user,admin',
            'country' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
        ]);

        // Map role to the MySQL enum values
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

    // Iniciar sesión
    Route::post('/login', function (Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return response()->json([
                'user' => Auth::user(),
                'message' => 'Inicio de sesión exitoso',
            ]);
        }

        return response()->json([
            'message' => 'Credenciales incorrectas',
        ], 401);
    });

    // Solicitar enlace de recuperación de contraseña
    Route::post('/forgot-password', function (Request $request) {
        $request->validate(['email' => 'required|email']);
        $status = Password::sendResetLink($request->only('email'));
        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['message' => __($status)]);
        }

        return response()->json(['message' => __($status)], 422);
    });

    // Restablecer contraseña con token
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

    // Protected routes (authenticated users)
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', function (Request $request) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return response()->json(['message' => 'Sesión cerrada']);
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
            return $request->user();
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
