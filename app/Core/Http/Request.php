<?php

namespace Core\Http;


use Core\Auth\Authenticable;

class Request
{
    /**
     * @var Authenticable
     */
    protected $user;

    /**
     * @param string $name
     * @param mixed $default
     * @return string
     */
    public function input($name, $default = null)
    {
        if (isset($_GET[$name])) {
            return $_GET[$name];
        }

        if (isset($_POST[$name])) {
            return $_POST[$name];
        }

        return $default;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function has($name)
    {
        return isset($_GET[$name]) || isset($_POST[$name]);
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function file($name)
    {
        return $_FILES[$name];
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasFile($name)
    {
        return isset($_FILES[$name]);
    }

    /**
     * @return string
     */
    public function uri()
    {
        return strtok($_SERVER["REQUEST_URI"],'?');
    }

    /**
     * @param Authenticable $user
     */
    public function setUser(Authenticable $user)
    {
        $this->user = $user;
    }

    /**
     * @return Authenticable
     */
    public function user()
    {
        return $this->user;
    }
}