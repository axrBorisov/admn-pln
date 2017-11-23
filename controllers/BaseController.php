<?php

abstract class BaseController extends Controller
{

    protected $title;
    protected $menu;
    protected $content;

    /**
     * Генерация шаблона до загрузки основного
     */
    protected function before(): void
    {
        $this->title = 'Сайт';
        $this->menu = '';
        $this->content = '';
    }

    /**
     *Генерация базового шаблона
     */
    public function render(): void
    {
        echo $this->template('views/layout/main.php', [
            'title' => $this->title,
            'menu' => $this->menu,
            'content' => $this->content,
        ]);
    }

    /**
     * Метод для редиректа
     * @param string $redirect
     */
    public function redirect($redirect = '/')
    {
        header("Location: $redirect");
        exit();
    }
}
