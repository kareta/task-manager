<?php

use Core\Application;
use Monolog\Logger;

class AppBootstrap
{
    /**
     * @return Application
     */
    public function bootstrap()
    {
        $config = require ROOT_DIR . 'config/config.php';

        Application::$config = $config;

        Application::$log = new Logger('app');

        $logPath = ROOT_DIR . 'storage/logs/app.log';

        Application::$log->pushHandler(
            new \Monolog\Handler\StreamHandler($logPath, \Monolog\Logger::DEBUG)
        );

        return new Application();
    }
}