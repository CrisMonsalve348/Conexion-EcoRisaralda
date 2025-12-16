<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * For our SPA API endpoints, we manage authentication via Sanctum
     * and cookies, so we can safely exclude these routes to prevent
     * 419 errors during cross-origin requests from the frontend.
     */
    protected $except = [];
}
