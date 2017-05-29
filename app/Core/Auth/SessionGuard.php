<?php

namespace Core\Auth;


use Core\Http\Request;

class SessionGuard
{
    /**
     * @param Authenticable|null $authenticable
     */
    public function authenticate(Authenticable $authenticable = null)
    {
        if ($authenticable == null) {
            return;
        }

        $_SESSION['user'] = $authenticable;
    }

    public function unauthenticate()
    {
        if (isset($_SESSION['user'])) {
            unset($_SESSION['user']);
        }
    }

    /**
     * @param Request $request
     */
    public function setUser(Request $request)
    {
        if (isset($_SESSION['user'])) {
            $request->setUser($_SESSION['user']);
        }
    }
}