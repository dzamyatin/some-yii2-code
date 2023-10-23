<?php
declare(strict_types=1);

namespace App\Blog\Application\Query;

use App\Blog\Domain\Repository\PostRepositoryInterface;

final class ShowPostsQuery
{
    public function __construct(public readonly int $offset, public readonly int $limit)
    {}
}
