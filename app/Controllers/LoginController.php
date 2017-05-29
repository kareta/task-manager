<?php

namespace Controllers;


use Core\Auth\SessionGuard;
use Core\Controller;
use Core\Http\Redirect;
use Core\Http\Request;
use Models\User;

class LoginController extends Controller
{
    /**
     * @param Request $request
     * @return \Core\Http\Response
     */
    public function showLogin(Request $request)
    {
        return $this->render('auth/login', compact('request'));
    }

    /**
     * @param Request $request
     * @return Redirect
     */
    public function login(Request $request)
    {
        $sessionGuard = new SessionGuard();

        $user = User::getAuthenticable($request);

        if (empty($user)) {
            $_SESSION['login_error'] = 'Name or password is incorrect';
            return new Redirect('/auth/login');
        }

        $sessionGuard->authenticate($user);

        return new Redirect('/tasks');
    }

    /**
     * @param Request $request
     * @return Redirect
     */
    public function logout(Request $request)
    {
        $sessionGuard = new SessionGuard();
        $sessionGuard->unauthenticate();

        return new Redirect('/auth/login');
    }
}