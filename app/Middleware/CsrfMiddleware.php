<?php

namespace Middleware;


use Core\Http\Request;
use Core\Http\Response;
use Core\Middleware;

class CsrfMiddleware implements Middleware
{
    /**
     * @param Request $request
     * @param Callable $next
     * @return Response
     * @throws \Exception
     */
    public function handle(Request $request, $next)
    {
        $csrfToken = $request->input('csrf_token');
        if (!$csrfToken || !hash_equals($_SESSION['csrf_token'], $csrfToken)) {
            throw new \Exception('Incorrect csrf_token');
        }

        return $next($request, $next);
    }
}