<?php

namespace App\Middleware;

use Core\Http\Middleware;
use Core\Http\Redirect;
use Core\Http\Response;
use Core\Http\Request;
use Closure;

class AuthMiddleware extends Middleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->getUser();
        if (!$user) {
            Redirect::to('/auth');
        }

        return $next($request);
    }
}