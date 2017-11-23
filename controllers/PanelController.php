<?php

class PanelController extends BaseController
{

    private $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function action_index()
    {
        if (!$this->userService->can('use')) {
            $this->redirect('/user/login');
        }

        $this->menu = $this->template('views/panel/top_menu.php');
        $this->content = $this->template('views/panel/index.php');

        $this->render();
    }

}
