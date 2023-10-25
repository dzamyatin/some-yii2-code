<?php
declare(strict_types=1);

namespace App\Shared\User\Ui;

use App\Shared\User\Application\Command\UserRegister;
use App\Shared\User\Application\Command\UserRegisterCommand;
use App\Shared\User\Application\Query\UserTokenProduce;
use App\Shared\User\Application\Query\UserTokenProduceQuery;
use App\Shared\User\Application\Query\UserTokenRefresh;
use App\Shared\User\Application\Query\UserTokenRefreshQuery;
use App\Shared\User\Ui\Request\TokenProduceRequest;
use App\Shared\User\Ui\Request\TokenRefreshRequest;
use App\Shared\User\Ui\Request\UserRegisterRequest;
use App\Shared\User\Ui\Response\TokenProduceResponse;

final class UserApi
{
    public function __construct(
        private UserRegister $userRegister,
        private UserTokenProduce $tokenProduce,
        private UserTokenRefresh $tokenRefresh,
    ) {}

    public function userRegister(UserRegisterRequest $request): void
    {
        $this->userRegister->__invoke(
            new UserRegisterCommand(
                $request->login,
                $request->password,
            )
        );
    }

    public function tokenProduce(TokenProduceRequest $request): TokenProduceResponse
    {
        return new TokenProduceResponse(
            $this->tokenProduce->produce(
                new UserTokenProduceQuery($request->login, $request->password)
            )
        );
    }

    public function tokenRefresh(TokenRefreshRequest $request): TokenProduceResponse
    {
        return new TokenProduceResponse(
            $this->tokenRefresh->produce(
                new UserTokenRefreshQuery($request->token)
            )
        );
    }
}
