<?php

class ErrorController extends BaseController
{

    private $message;

    public function __construct($message = null)
    {
        $this->message = $message;
    }

    public function error()
    {
        header('HTTP/1.x 404 Not Found');
        echo $this->template('views/editor/404.php', ['message' => $this->message]);
    }
}
