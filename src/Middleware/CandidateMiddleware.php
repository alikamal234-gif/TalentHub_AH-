<?php

namespace App\Middleware;

use Core\Error\Error;
use Core\Http\Middleware;
use Core\Http\Response;
use Core\Http\Request;
use Closure;

class CandidateMiddleware extends Middleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->getUser();

        if (!$user?->getRole()->isCandidate()) {
            return Error::abort(403);
        }

        return $next($request);

    }
}