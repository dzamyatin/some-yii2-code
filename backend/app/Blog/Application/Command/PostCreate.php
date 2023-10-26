<?php
declare(strict_types=1);

namespace App\Blog\Application\Command;

use App\Blog\Domain\Entity\Post;
use App\Blog\Domain\Repository\PostRepositoryInterface;
use App\Shared\User\Domain\Repository\UserTokenRepositoryInterface;
use App\Shared\User\Domain\Repository\UuidRepositoryInterface;
use App\Shared\User\Domain\Repository\UserTokenRepositoryException;

final class PostCreate
{
    public function __construct(
        private PostRepositoryInterface $postRepository,
        private UuidRepositoryInterface $uuidRepository,
        private UserTokenRepositoryInterface $tokenRepository
    ) {}

    /**
     * @throws UserTokenRepositoryException
     */
    public function __invoke(PostCreateCommand $postCreateCommand)
    {
        $token = $this->tokenRepository->decodeToken($postCreateCommand->getUserToken());

        $this->postRepository->createPost(
            new Post(
                $this->uuidRepository->create(),
                $token->userUid,
                $postCreateCommand->getHeader(),
                $postCreateCommand->getText()
            )
        );
    }
}
