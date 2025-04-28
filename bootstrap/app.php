<?php

use App\Http\Middleware\MustBeLearner;
use App\Http\Middleware\MustBeMentor;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\HandleCors;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

<<<<<<< HEAD
        // $middleware->global([
        //     \Illuminate\Http\Middleware\HandleCors::class,
        // ]);
        $middleware->alias([
            'mustBeMentor' => MustBeMentor::class,
            'mustBeLearner' => MustBeLearner::class,
            \Illuminate\Http\Middleware\HandleCors::class,
=======
        $middleware->alias([
            'mustBeMentor' => MustBeMentor::class,
            'mustBeLearner' => MustBeLearner::class,
            \App\Http\Middleware\CorsMiddleware::class,
>>>>>>> 0ce48d9500d750a21fbdfbe832aad8bd20418cb4
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
