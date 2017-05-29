<?php


namespace Core;


use Core\Http\Request;
use Core\Http\Response;

interface Middleware
{
    /**
     * @param Request $request
     * @param Callable $next
     * @return Response
     */
    public function handle(Request $request, $next);
}