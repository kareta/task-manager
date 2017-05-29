<?php

namespace Core\Exceptions;


use Core\Http\Request;
use Core\Http\Response;
use \Exception;

interface ExceptionHandler
{
    /**
     * @param Request $request
     * @param Exception $exception
     * @return Response
     */
    public function handle(Request $request, Exception $exception);
}