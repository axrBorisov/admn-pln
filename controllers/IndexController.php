<?php

class IndexController extends BaseController
{

    public function action_index()
    {
        $this->menu = $this->template('views/editor/top_menu.php');
        $this->content = $this->template('views/editor/index.php', [
            'content' => PageModel::getPages(),
        ]);

        $this->render();
    }

}
