<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\SetLocale;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            SetLocale::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {

        $exceptions->render(function (
            ThrottleRequestsException $e,
                                      $request
        ) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Забагато запитів. Спробуйте пізніше.'
                ], Response::HTTP_TOO_MANY_REQUESTS);
            }

            return response()->view(
                'errors.too_many_requests',
                [
                    'retryAfter' => $e->getHeaders()['Retry-After'] ?? 60,
                ],
                429
            );
        });

    })
    ->create();
