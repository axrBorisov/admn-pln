<div class="container">
    <h3>Новая страница</h3><br/>
    <form method="post">
        <div class="form-group">
            <label for="text">Название</label>
            <input type="text" name="title" class="form-control"
                   value="<?= $_POST['title']?? '' ?>">
        </div>
        <div class="form-group">
            <label for="text">Заголовок</label>
            <input type="text" name="header" class="form-control"
                   value="<?= (isset($_POST['header']) ? $_POST['header'] : '') ?>">
        </div>
        <div class="form-group">
            <label for="content">Основной контент</label>
            <textarea name="content_main" id="content_main"
                      class="form-control"><?= (isset($_POST['content_main']) ? $_POST['content_main'] : '') ?></textarea>
        </div>
        <div class="form-group">
            <label for="content">Дополнительй контент</label>
            <textarea name="content_additional" id="content_additional"
                      class="form-control"><?= (isset($_POST['content_additional']) ? $_POST['content_additional'] : '') ?></textarea>
        </div>
        <input id="submit" type="submit" class="btn btn-success" value="Добавить">
    </form>
</div>
