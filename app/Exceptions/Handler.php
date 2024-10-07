<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontReport = [
        AuthorizationException::class,
        ThrottleRequestsException::class,
    ];

    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    public function render($request, Throwable $exception): Response
    {
        // Handle authorization exceptions
        if ($exception instanceof AuthorizationException) {
            return response()->json([
                'message' => 'You do not have permission to perform this action.',
                'status' => 403,
            ], 403);
        }

        // Handle throttling exceptions
        if ($exception instanceof ThrottleRequestsException) {
            return response()->json([
                'message' => 'Too many attempts. Please try again later.',
                'status' => 429,
            ], 429);
        }

        return parent::render($request, $exception);
    }
}
