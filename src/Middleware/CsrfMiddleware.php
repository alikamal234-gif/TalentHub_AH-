<?php



use Core\Http\Middleware;
use Core\Http\Response;
use Core\Http\Request;

class CsrfMiddlewareController extends Middleware {


public function handle(Request $request, Closure $next): Response{
    return next($request);
}
}