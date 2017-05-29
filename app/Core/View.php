<?php

namespace Core;


class View
{
    /**
     * @return string
     */
    public function basePath()
    {
        return Application::$config['views_path'];
    }

    /**
     * @return string
     */
    public function csrfToken()
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(openssl_random_pseudo_bytes(32));
        }

        $token = $_SESSION['csrf_token'];

        return "<input type='hidden' name='csrf_token' value='$token'/>";
    }

    /**
     * @param $string
     * @return string
     */
    public function escape($string)
    {
        return htmlspecialchars($string);
    }

    /**
     * @param string $viewName
     * @param array $params
     * @return string
     */
    public function render($viewName, $params = [])
    {
        ob_start();

        extract($params);

        require($this->basePath() . $viewName . '.php');

        return ob_get_clean();
    }
}