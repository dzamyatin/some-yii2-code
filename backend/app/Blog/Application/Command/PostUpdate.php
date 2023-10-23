<?php
declare(strict_types=1);

namespace App\Blog\Application\Command;

use App\Blog\Application\Exception\PostUpdateException;
use App\Blog\Application\Exception\PostUpdatePostNotFoundException;
use App\Blog\Domain\Entity\Post;
use App\Blog\Domain\Repository\PostRepositoryInterface;
use App\Shared\Domain\Repository\UserTokenRepositoryInterface;
use App\Shared\Domain\Repository\UserTokenRepositoryException;

final class PostUpdate
{
    public function __construct(
        private PostRepositoryInterface $postRepository,
        private UserTokenRepositoryInterface $tokenRepository
    ) {}

    /**
     * @param PostUpdateCommand $postUpdateCommand
     * @return void
     *
     * @throws UserTokenRepositoryException
     * @throws PostUpdateException
     * @throws PostUpdatePostNotFoundException
     */
    public function __invoke(PostUpdateCommand $postUpdateCommand)
    {
        $token = $this->tokenRepository->decodeToken($postUpdateCommand->getUserToken());
        $post = $this->postRepository->getPost($postUpdateCommand->getPostUid());

        if (is_null($post)) {
            throw new PostUpdatePostNotFoundException('There is no such post to update');
        }

        if ($token->userUid !== $post->getUserUid()) {
            throw new PostUpdateException('Wrong post owner');
        }

        $this->postRepository->createPost(
            new Post(
                $postUpdateCommand->getPostUid(),
                $token->userUid,
                $postUpdateCommand->getHeader(),
                $postUpdateCommand->getText()
            )
        );
    }
}
