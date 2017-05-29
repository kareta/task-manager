<?php

namespace Core;


use Core\Exceptions\ExceptionHandler;
use Core\Http\Request;
use Core\Http\Response;
use \Exception as Exception;

class AppExceptionHandler implements ExceptionHandler
{

    /**
     * @param Request $request
     * @param Exception $exception
     * @return Response
     */
    public function handle(Request $request, \Exception $exception)
    {
        Application::$log->error($exception->getMessage());
        Application::$log->error($exception->getTraceAsString());

        $view = new View();

        return new Response(404, $view->render('errors/404'));
    }
}