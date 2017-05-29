<?php

namespace Core\Http;

class Redirect extends Response
{
    /**
     * Redirect constructor.
     * @param string $path
     */
    public function __construct($path)
    {
        parent::__construct(302);

        $url = "http://" . $_SERVER['SERVER_NAME'] . $path;
        $this->addHeader('Location', $url);
    }
}