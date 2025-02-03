<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Closure;
use Illuminate\Auth\AuthenticationException;

class AuthenticateApi extends Middleware
{
    /**
     * Handle unauthenticated requests.
     */
    protected function unauthenticated($request, array $guards)
    {
        throw new AuthenticationException(
            'Unauthenticated.',
            $guards,
            response()->json([
                'code'  => 401,
                'key'   => 'fail',
                'msg'   => 'please login again',
            ], 401)
        );
    }
}
