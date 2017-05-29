<?php

namespace Models;


use Core\Auth\Authenticable;
use Core\Http\Request;
use Core\Orm\ActiveRecord;

class User extends ActiveRecord implements Authenticable
{
    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * @return Authenticable|null
     */
    public static function getAuthenticable(Request $request)
    {
        $name = $request->input('name');
        $password = $request->input('password');

        $user = self::selectFirst('WHERE name = :name', [':name' => $name]);

        if (password_verify($password, $user->password)) {
            return $user;
        }

        return null;
    }
}