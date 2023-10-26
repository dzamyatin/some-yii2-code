<?php
declare(strict_types=1);

namespace App\Shared\User\Ui;

use App\Shared\Common\Ui\Response\BadRequestResponseException;
use App\Shared\User\Application\Command\UserRegister;
use App\Shared\User\Application\Command\UserRegisterCommand;
use App\Shared\User\Application\Command\UserRegisterException;
use App\Shared\User\Application\Query\UserTokenProduce;
use App\Shared\User\Application\Query\UserTokenProduceException;
use App\Shared\User\Application\Query\UserTokenProduceQuery;
use App\Shared\User\Application\Query\UserTokenRefresh;
use App\Shared\User\Application\Query\UserTokenRefreshException;
use App\Shared\User\Application\Query\UserTokenRefreshQuery;
use App\Shared\User\Domain\Repository\UserTokenRepositoryException;
use App\Shared\User\Ui\Request\TokenProduceRequest;
use App\Shared\User\Ui\Request\TokenRefreshRequest;
use App\Shared\User\Ui\Request\UserRegisterRequest;
use App\Shared\User\Ui\Response\TokenProduceResponse;
use OpenApi\Attributes as OA;

#[
    OA\SecurityScheme(
        securityScheme: 'user_token',
        type: 'http',
        scheme: 'basic',
    )
]
final class UserApi
{
    public function __construct(
        private UserRegister $userRegister,
        private UserTokenProduce $tokenProduce,
        private UserTokenRefresh $tokenRefresh,
    ) {}

    #[
        OA\Post(
            path: '/user/register',
            description: 'Register a new user',
            requestBody: new OA\RequestBody(
                content: new OA\JsonContent(ref: '#/components/schemas/UserRegisterRequest')
            ),
            tags: ['User'],
            responses: [
                new OA\Response(
                    response: 200,
                    description: 'Success',
                ),
            ],
        )
    ]
    public function userRegister(UserRegisterRequest $request): void
    {
        try {
            $this->userRegister->__invoke(
                new UserRegisterCommand(
                    $request->login,
                    $request->password,
                )
            );
        } catch (UserRegisterException $exception) {
            throw new BadRequestResponseException($exception->getMessage(), $exception);
        }
    }

    #[
        OA\Post(
            path: '/user/token',
            description: 'Get user token',
            security: [
                ['user_token' => []]
            ],
            requestBody: new OA\RequestBody(
                content: new OA\JsonContent(ref: '#/components/schemas/TokenProduceRequest')
            ),
            tags: ['User'],
            responses: [
                new OA\Response(
                    response: 200,
                    description: 'Success',
                ),
            ],
        )
    ]
    /**
     * @throws BadRequestResponseException
     */
    public function tokenProduce(TokenProduceRequest $request): TokenProduceResponse
    {
        try {
            return new TokenProduceResponse(
                $this->tokenProduce->produce(
                    new UserTokenProduceQuery($request->login, $request->password)
                )
            );
        } catch (UserTokenProduceException $exception) {
            throw new BadRequestResponseException($exception->getMessage(), $exception);
        }
    }

    #[
        OA\Post(
            path: '/user/refresh',
            description: 'Refresh user token',
            security: [
                ['user_auth' => []]
            ],
            tags: ['User'],
            responses: [
                new OA\Response(
                    response: 200,
                    description: 'Success',
                ),
            ],
        )
    ]
    /**
     * @throws BadRequestResponseException
     */
    public function tokenRefresh(TokenRefreshRequest $request): TokenProduceResponse
    {
        try {
            return new TokenProduceResponse(
                $this->tokenRefresh->produce(
                    new UserTokenRefreshQuery($request->token)
                )
            );
        } catch (UserTokenRefreshException|UserTokenRepositoryException $exception) {
            throw new BadRequestResponseException($exception->getMessage(), $exception);
        }
    }
}
