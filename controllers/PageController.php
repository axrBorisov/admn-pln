<?php

class PageController extends BaseController
{

    private $pageService;
    private $userService;

    public function __construct()
    {
        $this->pageService = new PageService();
        $this->userService = new UserService();
    }

    public function action_index()
    {
        if (!$this->userService->can('use')) {
            $this->redirect('/user/login');
        }

        $this->menu = $this->template('views/panel/top_menu.php');
        $this->content = $this->template('views/editor/list.php', [
            'content' => PageModel::getPages(),
        ]);

        $this->render();
    }

    public function action_view($id)
    {
        if ($this->userService->can('use')) {
            $this->menu = $this->template('views/panel/top_menu.php');
        } else {
            $this->menu = $this->template('views/editor/top_menu.php');
        }

        $this->content = $this->template('views/editor/view.php', [
            'page' => PageModel::get($id),
        ]);
        $this->render();
    }

    public function action_create()
    {
        if (!$this->userService->can('use')) {
            $this->redirect('/user/login');
        }

        $this->menu = $this->template('views/panel/top_menu.php');
        if (!empty($post = $_POST)) {
            $this->pageService->createPage($post);
            $this->redirect('/page');
        }
        $this->content = $this->template('views/editor/create.php');
        $this->render();
    }

    public function action_update($id)
    {
        if (!$this->userService->can('use')) {
            $this->redirect('/user/login');
        }

        $this->menu = $this->template('views/panel/top_menu.php');
        if (!empty($post = $_POST)) {
            $this->pageService->updatePage($id, $post);
            $this->redirect('/page');
        }

        $page = $this->pageService->updatePage($id);
        $this->content = $this->template('views/editor/edit.php', [
            'page' => $page,
        ]);

        $this->render();
    }

    public function action_delete($id)
    {
        if (!$this->userService->can('use')) {
            $this->redirect('/user/login');
        }

        $this->menu = $this->template('views/panel/top_menu.php');
        $this->pageService->deletePage($id);
        $this->redirect('/page');
    }
}
