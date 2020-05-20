<?php

namespace WorkWechat\Exception;

class NotfindException extends \Exception
{
    private $url;

    public function __construct($message = "", $code = 0, $url = '')
    {
        $this->message = $message;
        $this->code = $code;
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }
}