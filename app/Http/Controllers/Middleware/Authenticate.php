<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        // Admin routes
        if ($request->is('admin/*')) {
            return route('admin.login');
        }

        // Normal users
        return route('admin.login');
    }
}