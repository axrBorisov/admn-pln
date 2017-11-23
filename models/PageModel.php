<?php

class PageModel
{

    public static function tableName(): string
    {
        return 'pages';
    }

    public static function get(int $id)
    {
        return Db::getInstance()->Select("SELECT * FROM `pages` WHERE `id` = $id", 'object');
    }

    public static function getPages()
    {
        return Db::getInstance()->Select("SELECT * FROM `pages`");
    }

    /**
     * @param $title
     * @param $header
     * @param $content_main
     * @param $content_additional
     * @return bool
     */
    public static function create(
        string $title = null,
        string $header = null,
        string $content_main = null,
        string $content_additional = null
    ): bool
    {
        return DataModel::add(self::tableName(), [
            'title',
            'header',
            'content_main',
            'content_additional'
        ],
            [
                'title' => $title,
                'header' => $header,
                'content_main' => $content_main,
                'content_additional' => $content_additional
            ]
        );

    }

    public static function update(
        string $title = null,
        string $header = null,
        string $content_main = null,
        string $content_additional = null,
        int $id
    ): bool
    {
        return DataModel::edit(self::tableName(), [
            'title',
            'header',
            'content_main',
            'content_additional',
            'date_update'
        ],
            [
                'title' => $title,
                'header' => $header,
                'content_main' => $content_main,
                'content_additional' => $content_additional,
                'date_update' => (new DateTime())->format('Y-m-d h-m-s'),
            ]
            , $id);
    }

    public static function delete(int $id)
    {
        return Db::getInstance()->delete(self::tableName(), $id, 'id');

    }
}