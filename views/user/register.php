<?php

/** @var boolean $result_register */
/** @var string $error */
/** @var string $login */
/** @var string $password */

?>

<div class="container">
    <?php if ($result_register) : ?>
        <div class="alert alert-success">
            Пользователь зарегистрирован!
        </div>
    <?php else: ?>
    <?php if ($error): ?>
        <div class="alert alert-warning">
            <?= $error ?>
        </div>
    <?php endif; ?>
    <h2>Регистрация</h2><br/>
    <form method="post">
        <div class="form-group">
            <label for="login">Логин:</label><br>
            <input id="login" type="login" name="login" placeholder="Логин" class="form-control" required
                   value="<?= $login ?>"/>
        </div>
        <div class="form-group">
            <label for="password">Пароль:</label><br>
            <input id="password" type="password" name="password" placeholder="Пароль" class="form-control" required
                   value="<?= $password ?>"/>
        </div>
        <div class="form-group">
            <label for="password">Подтверждение пароля:</label><br>
            <input id="password" type="password" name="confirm" placeholder="Пароль" class="form-control" required/>
        </div>
        <input id="submit_reg" type="submit" name="submit" class="btn btn-success"
               value="Зарегистрировать"/><br>
    </form>
</div>
<?php endif; ?>
</div>