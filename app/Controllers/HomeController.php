<?php

namespace Controllers;


use Core\Http\Redirect;
use Core\Http\Request;

class HomeController
{
    /**
     * @param Request $request
     * @return Redirect
     */
    public function index(Request $request)
    {
        return new Redirect('/tasks');
    }
}