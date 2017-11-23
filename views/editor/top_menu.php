<nav class="navbar navbar-default ">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="/">Главная</a>
        </div>
        <ul class="nav navbar-nav">
            <?php if ((new UserService())->can('use')): ?>
                <li><a href="/panel/index">Админ-панель</a></li>
            <?php endif; ?>
            <?php if (!UserModel::instance()->get()): ?>
                <li><a href="/user/login">Вход</a></li>
            <?php endif; ?>
            <?php if (UserModel::instance()->get()): ?>
                <li><a href="/user/logout">Выход</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

