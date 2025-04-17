<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\EnsurePaymentIsDone;
use App\Http\Middleware\EnsurePaymentIsNotDone;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        $middleware->alias([
            'subscribed' => EnsurePaymentIsDone::class,
            'unsubscribed' => EnsurePaymentIsNotDone::class,
        ]);
       
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
