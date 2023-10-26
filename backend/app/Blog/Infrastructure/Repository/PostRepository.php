<?php

namespace App\Blog\Infrastructure\Repository;

use App\Blog\Domain\Dto\PostRequest;
use App\Blog\Domain\Entity\Post;
use App\Blog\Domain\Repository\PostRepositoryInterface;
use yii\db\Query;

class PostRepository implements PostRepositoryInterface
{
    public function getPosts(PostRequest $postRequest): array
    {
        return array_map(
            fn(array $row) => $this->denarmalizePost($row),
            $this->getPostQuery()
                ->offset($postRequest->offset)
                ->limit($postRequest->limit)
                ->orderBy(['createdAt' => SORT_DESC])
                ->all()
        );
    }

    public function createPost(Post $post): void
    {
        (new Query())
            ->createCommand()
            ->insert(
                'blog_post',
                $this->normalizePost($post),
            )
            ->execute();
    }

    public function updatePost(Post $post): void
    {
        (new Query())
            ->createCommand()
            ->update(
                'blog_post',
                $this->normalizePost($post),
                ['uid' => $post->getUid()],
            )
            ->execute();
    }

    public function deletePost(string $postUid): void
    {
        (new Query())
            ->createCommand()
            ->delete('blog_post', ['uid' => $postUid])
            ->execute();
    }

    public function getPost(string $postUid): ?Post
    {
        $raw = $this->getPostQuery()->one();

        if (!$raw) {
            return null;
        }

        return $this->denarmalizePost($raw);
    }

    private function getPostQuery(): Query
    {
        return (new Query())
            ->select(['uid', 'userUid', 'header', 'text', 'createdAt'])
            ->from('blog_post');
    }

    private function denarmalizePost(array $raw): Post
    {
        return new Post(
            (string) $raw['uid'],
            (string) $raw['userUid'],
            (string) $raw['header'],
            (string) $raw['text'],
            (int) strtotime($raw['createdAt']),
        );
    }

    private function normalizePost(Post $post): array
    {
        return [
            'uid' => $post->getUid(),
            'userUid' => $post->getUserUid(),
            'header' => $post->getHeader(),
            'text' => $post->getText(),
            'createdAt' => date("Y-m-d H:i:s", $post->getCreatedAt())
        ];
    }
}
