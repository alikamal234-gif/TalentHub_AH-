<?php

declare(strict_types=1);

namespace Core\Http;

use Closure;

abstract class Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    abstract public function handle(Request $request, Closure $next): Response;
}
