<?php

namespace Middleware;


use Core\Http\Request;
use Core\Http\Response;

class SessionMiddleware
{
    /**
     * @param Request $request
     * @param Callable $next
     * @return Response
     */
    public function handle(Request $request, $next)
    {
        session_start();
        return $next($request, $next);
    }
}