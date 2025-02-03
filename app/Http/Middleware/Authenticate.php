<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request)
    {
        return $request->segment(2) == 'api' ? [
            'code'  => 401,
            'key'   => 'fail',
            'msg'   => 'please login again',
        ] : route('login');
    }
}
