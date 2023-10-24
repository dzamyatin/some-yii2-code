<?php
declare(strict_types=1);

namespace App\Blog\Domain\Dto;

final class PostRequest
{
    public function __construct(
        readonly int $offset,
        readonly int $limit,
    ) {}
}
