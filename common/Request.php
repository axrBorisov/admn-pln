<?php

class Request
{
    private $_controller;
    private $_method;
    private $_args;

    /**
     * Request constructor.
     */
    public function __construct()
    {
        $parts = explode('/', $_SERVER['REQUEST_URI']);
        $parts = array_filter($parts);
        $this->_controller = ($c = array_shift($parts)) ? $c : 'Index';
        $this->_method = ($c = array_shift($parts)) ? $c : 'index';
        $this->_args = isset($parts[0]) ? $parts : array();
    }

    /**
     * @return mixed|string
     */
    public function getController()
    {
        return $this->_controller;
    }

    /**
     * @return mixed|string
     */
    public function getMethod()
    {
        return $this->_method;
    }

    /**
     * @return array
     */
    public function getArgs(): array
    {
        return $this->_args;
    }
}
