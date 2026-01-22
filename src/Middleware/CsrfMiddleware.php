<?php


namespace App\Middleware;

use Core\Http\Middleware;
use Core\Http\Response;
use Core\Http\Request;
use Closure;

class CsrfMiddleware extends Middleware
{
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }
}