<?php
declare(strict_types=1);

namespace App\Blog\Application\Command;

use App\Blog\Application\Command\Exception\PostUpdateException;
use App\Blog\Domain\Repository\PostRepositoryInterface;
use App\Shared\Domain\Repository\UserTokenRepositoryInterface;
use App\Shared\Domain\Repository\UserTokenRepositoryException;

final class PostDelete
{
    public function __construct(
        private PostRepositoryInterface $postRepository,
        private UserTokenRepositoryInterface $tokenRepository
    ) {}

    /**
     * @param PostDeleteCommand $postDeleteCommand
     * @return void
     *
     * @throws UserTokenRepositoryException
     * @throws PostUpdateException
     */
    public function __invoke(PostDeleteCommand $postDeleteCommand)
    {
        $token = $this->tokenRepository->decodeToken($postDeleteCommand->getUserToken());
        $post = $this->postRepository->getPost($postDeleteCommand->getPostUid());

        if (is_null($post)) {
            return;
        }

        if ($token->userUid !== $post->getUserUid()) {
            throw new PostUpdateException('Wrong post owner');
        }

        $this->postRepository->deletePost(
            $postDeleteCommand->getPostUid()
        );
    }
}
