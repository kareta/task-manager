<?php

namespace Middleware;


use Core\Auth\SessionGuard;
use Core\Http\Request;
use Core\Http\Response;
use Core\Middleware;

class AuthMiddleware implements Middleware
{
    /**
     * @param Request $request
     * @param Callable $next
     * @return Response
     */
    public function handle(Request $request, $next)
    {
        $sessionGuard = new SessionGuard;
        $sessionGuard->setUser($request);

        return $next($request, $next);
    }
}