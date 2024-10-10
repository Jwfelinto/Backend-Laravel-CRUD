<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     * @throws Throwable
     */
    public function report(Throwable $e): void
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     * @throws Throwable
     */
    public function render($request, Throwable $e): JsonResponse|Response
    {
        if ($e instanceof MethodNotAllowedHttpException) {
            return response()->json(['error' => 'Method not allowed'], 405);
        }

        if ($e instanceof NotFoundHttpException) {
            return response()->json(['error' => 'Route not found'], 404);
        }

        if ($e instanceof AccessDeniedHttpException) {
            return response()->json(['error' => 'Access denied'], 403);
        }

        if ($e instanceof ValidationException) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $e->errors(),
            ], 422);
        }

        return parent::render($request, $e);
    }

    /**
     * Handle unauthenticated users.
     */
    protected function unauthenticated($request, AuthenticationException $exception): \Illuminate\Http\Response|JsonResponse|RedirectResponse
    {
        if ($request->is('api/*')) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest(route('login'));
    }
}
