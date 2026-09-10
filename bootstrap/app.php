<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\EnsureUserIsStaff::class,
            'member.active' => \App\Http\Middleware\EnsureMemberActive::class,
        ]);

        $middleware->prepend(\App\Http\Middleware\ForceHttps::class);
        $middleware->prepend(\App\Http\Middleware\SetSecurityHeaders::class);

        // Appended to the web group (after StartSession/CSRF) so the session
        // store is available: blocks eligible privileged users with enabled
        // 2FA from staff/privileged areas until their session holds
        // 2fa.verified === true. Does not replace the 'admin' middleware.
        $middleware->web(append: [
            \App\Http\Middleware\RequireTwoFactor::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
