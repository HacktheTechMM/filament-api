<?php

use App\Http\Middleware\MustBeLearner;
use App\Http\Middleware\MustBeMentor;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        // $middleware->global([
        //     \Illuminate\Http\Middleware\HandleCors::class,
        // ]);
        $middleware->alias([
            'mustBeMentor' => MustBeMentor::class,
            'mustBeLearner' => MustBeLearner::class,
            \Illuminate\Http\Middleware\HandleCors::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
