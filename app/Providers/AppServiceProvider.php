<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Fix for older MySQL versions with key length limit
        Schema::defaultStringLength(191);

        $frontendUrl = config('app.frontend_url', env('FRONTEND_URL', 'http://localhost:5173'));

        // Enlaces de recuperación de contraseña dirigidos al frontend
        ResetPassword::createUrlUsing(function ($user, string $token) use ($frontendUrl) {
            return rtrim($frontendUrl, '/') . '/reset-password?token=' . $token . '&email=' . urlencode($user->email);
        });

        // Enlaces de verificación dirigidos a la ruta API firmada que luego redirige al frontend
        VerifyEmail::createUrlUsing(function ($notifiable) {
            $expires = Config::get('auth.verification.expire', 60);
            return URL::temporarySignedRoute(
                'api.verification.verify',
                now()->addMinutes($expires),
                [
                    'id' => $notifiable->getKey(),
                    'hash' => sha1($notifiable->getEmailForVerification()),
                ]
            );
        });
    }
}
