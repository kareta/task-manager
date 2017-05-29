<?php

namespace Core;


use Core\Http\Request;

interface Validator
{
    /**
     * @param Request $request
     * @return array
     */
    public function validate(Request $request);
}