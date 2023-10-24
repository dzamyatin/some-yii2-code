<?php
declare(strict_types=1);

namespace App\Blog\Ui\Response;

final class PostResponse
{
    public function __construct(
        public readonly string $header,
        public readonly string $text
    ) {}
}
