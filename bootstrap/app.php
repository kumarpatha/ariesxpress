<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            // Redirect unauthenticated admin requests to admin login
            // But exclude the login page itself to prevent redirect loops
            // if (($request->is('admin/*') || $request->is('admin')) && !$request->is('admin/login')) {
            //     return redirect()->route('admin.login');
            // }
            $middleware->alias([
                'auth' => Authenticate::class,
            ]);
        });
    })->create();
