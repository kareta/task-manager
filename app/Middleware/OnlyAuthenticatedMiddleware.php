<?php

namespace Middleware;


use Core\Exceptions\UnauthenticatedException;
use Core\Http\Request;
use Core\Http\Response;
use Core\Middleware;

class OnlyAuthenticatedMiddleware implements Middleware
{

    /**
     * @param Request $request
     * @param Callable $next
     * @return Response
     * @throws UnauthenticatedException
     */
    public function handle(Request $request, $next)
    {
        if (!$request->user()) {
            throw new UnauthenticatedException('User should be authenticated');
        }

        return $next($request, $next);
    }
}