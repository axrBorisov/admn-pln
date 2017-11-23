<?php

class PageService
{
    /**
     * @param array $post
     * @return bool
     */
    public function createPage(array $post): bool
    {
        $dataArray = $this->cleanPost($post);
        return PageModel::create(
            $dataArray['title'],
            $dataArray['header'],
            $dataArray['content_main'],
            $dataArray['content_additional']
        );
    }

    /**
     * @param int $id
     * @param array $post
     * @return mixed
     */
    public function updatePage(int $id, array $post = null)
    {
        if (!empty($post)) {
            $page = new PageModel();
            $dataArray = $this->cleanPost($post);
            $page->update(
                $dataArray['title'],
                $dataArray['header'],
                $dataArray['content_main'],
                $dataArray['content_additional'],
                $id
            );
        }

        $page = new PageModel();
        return $page->get($id);
    }

    public function deletePage(int $id)
    {
        try {
            if (!PageModel::delete($id)) {
                throw new RuntimeException('Страница не найдена!');
            }
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    private function cleanPost(array $post)
    {
        $dataArray = $post;
        array_walk($post, function ($item, $key) use (&$dataArray) {
            $dataArray[$key] = GuardModel::cleanQuery($item);
        });
        return $dataArray;
    }

}
