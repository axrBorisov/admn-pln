<?php

class UserController extends BaseController
{

    private $login;
    private $password;
    private $userService;

    public function __construct()
    {
        $this->userService = new UserService();
        $this->login = '';
        $this->password = '';
    }

    public function action_login()
    {
        if ($this->userService->can('use')) {
            $this->redirect('/panel');
        } elseif (UserModel::instance()->get()) {
            $this->redirect('/');
        }

        $error = null;
        if (isset($_POST['submit'])) {
            $this->login = $_POST['login'];
            $this->password = $_POST['password'];

            if ($this->userService->login($this->login, $this->password)) {
                $this->redirect('/panel');
            } else {
                $error = 'Неверный логин или пароль';
            }
        }

        $this->menu = $this->template('views/editor/top_menu.php');
        $this->content = $this->template('views/user/login.php', [
            'login' => $this->login,
            'password' => $this->password,
            'error' => $error
        ]);
        $this->render();
    }

    public function action_logout()
    {
        $this->userService->logout();
        $this->redirect();
    }

    public function action_register()
    {
        if (!$this->userService->can('use')) {
            $this->redirect('/user/login');
        }

        $resultRegister = false;
        $error = '';

        if (isset($_POST['submit'])) {
            $this->login = $_POST['login'];
            $this->password = $_POST['password'];
            $confirm = $_POST['confirm'];
            try {
                $resultRegister = $this->userService->registration($this->login, $this->password, $confirm);
            } catch (Exception $exception) {
                $error = $exception->getMessage();
            }
        }

        $this->menu = $this->template('views/panel/top_menu.php');
        $this->content = $this->template('views/user/register.php', [
            'result_register' => $resultRegister,
            'error' => $error,
            'login' => $this->login,
            'password' => $this->password
        ]);
        $this->render();
    }
}