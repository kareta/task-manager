<?php

namespace Core\Http;


class Response
{
    /**
     * @var array
     */
    protected $headers = [];

    /**
     * @var string
     */
    protected $content;

    /**
     * @var int
     */
    protected $code;

    /**
     * Response constructor.
     * @param int $code
     * @param string $content
     */
    public function __construct($code = 200, $content = '')
    {
        $this->code = $code;
        $this->content = $content;
    }

    /**
     * @param string $name
     * @param string $value
     */
    public function addHeader($name, $value)
    {
        $this->headers[$name] = $value;
    }

    /**
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param int $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    public function send()
    {
        http_response_code($this->code);

        foreach ($this->headers as $name => $value) {
            header("$name: $value");
        }

        echo $this->content;
    }
}