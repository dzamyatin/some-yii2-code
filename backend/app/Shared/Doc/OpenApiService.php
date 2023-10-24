<?php
declare(strict_types=1);

namespace App\Shared\Doc;

use OpenApi\Generator;

final class OpenApiService
{
    /**
     * @param string[] $dirs
     */
    public function __construct(private array $dirs)
    {}

    public function build(): string
    {
        $openapi = Generator::scan($this->dirs);

        return $openapi->toJson();
    }
}
