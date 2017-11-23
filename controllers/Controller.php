<?php

abstract class Controller
{

    /**
     * Генерация шаблона до загрузки основного
     */
    abstract protected function before(): void;

    /**
     *Генерация базового шаблона
     */
    abstract protected function render(): void;

    /**
     * @param $action
     * @param null $id
     */
    public function request($action, $id = null): void
    {
        $this->before();
        if (count($id) > 1) {
            $this->$action($id);
        }
        $this->$action($id[0]);
    }

    /**
     * Генерация HTML шаблона в строку.
     * @param $fileName
     * @param array $vars
     * @return string
     */
    protected function template($fileName, array $vars = []): string
    {
        foreach ($vars as $k => $v) {
            $$k = $v;
        }

        ob_start();
        include "{$fileName}";
        return ob_get_clean();
    }

    public function __call($name, $params)
    {
        $controller = new ErrorController;
        $controller->error();
    }


}
