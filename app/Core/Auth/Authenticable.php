<?php

namespace Core\Auth;


use Core\Http\Request;

interface Authenticable
{
    /**
     * @return Authenticable
     */
    public static function getAuthenticable(Request $request);
}