<?php

namespace Core\Routing;


class Route
{
    /**
     * @var string
     */
    protected $method;

    /**
     * @var string
     */
    protected $pattern;

    /**
     * @var string
     */
    protected $controller;

    /**
     * @var string
     */
    protected $action;

    /**
     * @var array
     */
    protected $middleware;

    /**
     * Route constructor.
     * @param string $method
     * @param string $pattern
     * @param array $middleware
     */
    public function __construct($method, $pattern, $controllerAction, $middleware = [])
    {
        $this->method = $method;
        $this->pattern = $pattern;
        $this->middleware = $middleware;
        list($this->controller, $this->action) = explode('@', $controllerAction);
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getPattern()
    {
        return $this->pattern;
    }

    /**
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return array
     */
    public function getMiddleware()
    {
        return $this->middleware;
    }

    /**
     * @param string $url
     * @param array $params
     * @return bool
     */
    public function match($url, &$params)
    {
        $patternMatched = preg_match($this->pattern, $url, $params);
        array_shift($params);

        $methodMatched = $this->method == $_SERVER['REQUEST_METHOD'];

        return $patternMatched && $methodMatched;
    }
}