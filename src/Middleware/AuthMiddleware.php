<?php



use Core\Http\Middleware;
use Core\Http\Response;
use Core\Http\Request;

class MiddlewareController extends Middleware {


public function handle(Request $request, Closure $next): Response{
    $user = $request->getSession('user');
    if(!$user){
        header("Location: login");
        exit;
    }

    return next($request);
}
}