<div class="container">
    <h3>Редактировать страницу</h3><br/>
    <form method="post">
        <div class="form-group">
            <label for="text">Название</label>
            <input type="text" name="title" class="form-control" value="<?= $page->title ?>">
        </div>
        <div class="form-group">
            <label for="text">Заголовок</label>
            <input type="text" name="header" class="form-control" value="<?= $page->header ?>">
        </div>
        <div class="form-group">
            <label for="content">Основной контент</label>
            <textarea name="content_main" id="content_main" class="form-control"><?= $page->content_main ?></textarea>
        </div>
        <div class="form-group">
            <label for="content">Дополнительй контент</label>
            <textarea name="content_additional" id="content_additional"
                      class="form-control"><?= $page->content_additional ?></textarea>
        </div>
        <input type="hidden" name="date_update" class="form-control" value="<?= $page->date_update ?>">
        <input id="submit" type="submit" class="btn btn-success" value="Сохранить">
    </form>
</div>
