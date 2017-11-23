<div class="container">
    <div class="box">
        <h2 align="center">Список страниц</h2>
        <a href="/page/create">
            <button class="btn btn-primary" style="margin-bottom: 10px">Добавить страницу</button>
        </a>
        <table class="table table-striped">
            <thead style="background-color: #e8e8e8; font-weight: bold;">
            <tr>
                <td>Название</td>
                <td>Заголовок</td>
                <td>Основной контент</td>
                <td>Дополнительй контент</td>
                <td>Дата создания</td>
                <td>Дата изменения</td>
                <td style="width: 5%;"></td>
                <td style="width: 8%;"></td>
            </thead>
            <tbody>
            <?php foreach ($content as $item): ?>
                <tr>
                    <td>
                        <a href="/page/view/<?= $item['id'] ?>"><?= $item['title'] ?></a>
                    </td>
                    <td><?= $item['header'] ?></td>
                    <td><?= $item['content_main'] ?></td>
                    <td><?= $item['content_additional'] ?></td>
                    <td><?= $item['date_create'] ?></td>
                    <td><?= $item['date_update'] ?></td>
                    <td>
                        <a href="/page/update/<?= $item['id'] ?>">
                            <button class="btn btn-sm btn-primary">изменить</button>
                        </a>
                    </td>
                    <td>
                        <a href="/page/delete/<?= $item['id'] ?>">
                            <button class="btn btn-sm btn-warning" onClick="return confirm('Удалить страницу?')">
                                удалить
                            </button>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
