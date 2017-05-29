<?php

namespace Core;


use Core\Exceptions\ExceptionHandler;
use Core\Http\Request;
use Core\Http\Response;
use Core\Routing\Router;
use \Exception as Exception;
use Monolog\Logger;

class Application
{
    /**
     * @var array
     */
    public static $config;

    /**
     * @var Logger
     */
    public static $log;

    /**
     * @var Router
     */
    protected $router;

    /**
     * Application constructor.
     */
    public function __construct()
    {
        $this->router = require self::$config['routes_path'];
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function run(Request $request, ExceptionHandler $handler)
    {
        try {
            return $this->router->execute($request);
        } catch (Exception $exception) {
            return $handler->handle($request, $exception);
        }
    }
}