<?php

namespace Core;


use Core\Http\Response;

abstract class Controller
{
    /**
     * @var View
     */
    protected $view;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->view = new View();
    }

    /**
     * @param string $viewName
     * @param array $params
     * @return Response
     */
    public function render($viewName, $params = [])
    {
        $response = new Response();

        $content = $this->view->render($viewName, $params);
        $response->setContent($content);

        return $response;
    }


}