<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . "/../routes/web.php",
        api: __DIR__ . "/../routes/api.php",
        commands: __DIR__ . "/../routes/console.php",
        health: "/up",
    )
    ->withMiddleware(function (Middleware $middleware): void {

        // --- [WAJIB ADA] TAMBAHKAN BARIS INI! ---
        // Tanpa ini, Laravel mengabaikan Cloudflare & Coolify
        $middleware->trustProxies(at: '*');
        // ----------------------------------------

        // Configure authentication to return JSON for API requests instead of redirecting
        $middleware->redirectGuestsTo(
            fn(Request $request) => $request->expectsJson() ||
            $request->is("api/*")
                ? null
                : "/login",
        );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Handle unauthenticated requests for API to return JSON instead of redirecting
        $exceptions->respond(function ($response, $exception, $request) {
            if (
                $request->is("api/*") &&
                $exception instanceof \Illuminate\Auth\AuthenticationException
            ) {
                return response()->json(
                    [
                        "message" => "Unauthenticated.",
                    ],
                    401,
                );
            }
            return $response;
        });
    })
    ->create();
