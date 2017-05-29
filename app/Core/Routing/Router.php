<?php

namespace Core\Routing;


use Core\Exceptions\NotFoundException;
use Core\Http\Request;
use Core\Http\Response;
use ReflectionClass;

class Router
{
    /**
     * @var array
     */
    protected $routes = [];

    /**
     * @var array
     */
    protected $controllers = [];

    /**
     * @var array
     */
    protected $middleware = [];

    /**
     * @return array
     */
    public function getMiddleware()
    {
        return $this->middleware;
    }

    /**
     * @param array $middleware
     */
    public function setMiddleware($middleware)
    {
        $this->middleware = $middleware;
    }

    /**
     * @param string $pattern
     * @param string $method
     * @param string $controllerAction
     * @param array $middleware
     * @throws NotFoundException
     */
    public function route($pattern, $method, $controllerAction, $middleware = [])
    {
        list($controller, $action) = explode('@', $controllerAction);

        if (!class_exists($controller)) {
            throw new NotFoundException("Class $controller does not exist");
        }

        if (!isset($this->controllers[$controller])) {
            $controllerReflection = new ReflectionClass($controller);
            $this->controllers[$controller] = $controllerReflection->newInstanceArgs();
        }

        if (!method_exists($this->controllers[$controller], $action)) {
            throw new NotFoundException(
                "Action $action does not exist in controller $controller"
            );
        }

        if ($method != 'GET' && $method != 'POST') {
            throw new NotFoundException(
                "Http method $method is not supported."
            );
        }

        $pattern = '/^' . str_replace('/', '\/', $pattern) . '$/';

        $this->routes[] = new Route($method, $pattern, $controllerAction, $middleware);
    }

    /**
     * @param $pattern
     * @param $controllerAction
     * @param array $middleware
     */
    public function get($pattern, $controllerAction, $middleware = [])
    {
        $this->route($pattern, 'GET', $controllerAction, $middleware);
    }

    /**
     * @param $pattern
     * @param $controllerAction
     * @param array $middleware
     */
    public function post($pattern, $controllerAction, $middleware = [])
    {
        $this->route($pattern, 'POST', $controllerAction, $middleware);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function execute(Request $request)
    {
        $urlParams = [];
        $route = $this->findRoute($request->uri(), $urlParams);

        $middleware = array_merge($this->getMiddleware(), $route->getMiddleware());

        $stack = $this->middlewareStack(
            $middleware,
            $route->getController(),
            $route->getAction(),
            $urlParams,
            $request
        );

        $response = $stack();


        return $response;
    }

    /**
     * @param string $url
     * @param array $params
     * @return Route
     * @throws NotFoundException
     */
    protected function findRoute($url, &$params)
    {
        foreach ($this->routes as $route) {
            if ($route->match($url, $params)) {
                return $route;
            }
        }

        throw new NotFoundException("Route $url is not found");
    }

    /**
     * @param array $middleware
     * @param string $controller
     * @param string $action
     * @param array $urlParams
     * @param Request $request
     * @return \Closure
     */
    protected function middlewareStack($middleware, $controller, $action, $urlParams, $request)
    {
        $controllerParams = array_merge([$request], $urlParams);
        $next = function () use ($controller, $action, $controllerParams) {
            return call_user_func_array([$this->controllers[$controller], $action], $controllerParams);
        };

        for ($i = count($middleware) - 1; $i >= 0 ; $i--) {
            $middlewareReflection = new ReflectionClass($middleware[$i]);
            $middlewareInstance = $middlewareReflection->newInstanceArgs();

            $frame = function () use ($middlewareInstance, $request, $next) {
                return call_user_func_array([$middlewareInstance, 'handle'], [$request, $next]);
            };

            $next = $frame;
        }

        return $next;
    }
}