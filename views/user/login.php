<?php

/** @var string $error */
/** @var string $login */
/** @var string $password */

?>

<div class="container"><br/>

    <?php if ($error !== null): ?>
        <div class="alert alert-warning">
            <?= $error; ?>
        </div>
    <?php endif; ?>

    <h2>Войти в админ-панель</h2><br/>
    <form method="post">
        <div class="form-group">
            <label for="login">Логин:</label>
            <input id="login" type="text" name="login" placeholder="Логин" class="form-control" required
                   value="<?= $login ?>"/>
        </div>
        <div class="form-group">
            <label for="password">Пароль:</label>
            <input id="password" type="password" name="password" placeholder="Пароль" class="form-control" required
                   value="<?= $password ?>"/>
        </div>
        <input id="submit_log" type="submit" name="submit" class="btn btn-success" value="Войти"/><br>
    </form>
</div>