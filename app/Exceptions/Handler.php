<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof PostTooLargeException) {
            return response()->json([
                'success' => false,
                'error' => 'Uploaded file is too large. Please upload a file smaller than 512MB.',
            ]);
        }

        if ($this->isHttpException($e)) {
            if ($e->getStatusCode() == 404) {
                return response()->view('dashboard.404', [], 404);
            }
            if ($e->getStatusCode() == 500) {
                return response()->view('dashboard.500', [], 500);
            }
        }

        return parent::render($request, $e);
    }

    public function unauthenticated($request, \Illuminate\Auth\AuthenticationException $exception)
    {
        return $request->expectsJson()
            ? response()->json([
                'code'  => 401,
                'key'   => 'fail',
                'msg'   => 'Invalid or missing authentication token.',
            ], 401)
            : redirect()->guest(route('login'));
    }

}
