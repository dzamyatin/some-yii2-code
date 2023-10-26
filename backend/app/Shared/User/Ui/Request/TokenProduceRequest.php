<?php
declare(strict_types=1);

namespace App\Shared\User\Ui\Request;

use OpenApi\Attributes as OA;

#[
    OA\Schema(
        schema: 'TokenProduceRequest',
        required: ['login', 'password'],
        properties: [
            new OA\Property(
                property: 'login',
                type: 'string',
                example: 'Header',
                nullable: false,
            ),
            new OA\Property(
                property: 'password',
                type: 'string',
                example: 'Text',
                nullable: false,
            ),
        ],
        type: 'object',
        nullable: false,
    )
]
class TokenProduceRequest
{
    public function __construct(
        public readonly string $login,
        public readonly string $password,
    ) {}
}
