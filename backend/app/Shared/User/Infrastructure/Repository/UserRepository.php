<?php

namespace App\Shared\User\Infrastructure\Repository;

use App\Shared\User\Domain\Repository\UserRepositoryInterface;
use App\Shared\User\Domain\Entity\User;
use yii\db\Query;

final class UserRepository implements UserRepositoryInterface
{
    public function getUserByLogin(string $login): ?User
    {
        $row = $this->getUserQuery()
            ->where(['login' => $login])
            ->one();

        if (!$row) {
            return null;
        }

        return new User(
            $row['uid'],
            $row['login'],
            $row['password'],
        );
    }

    public function getUserByUid(string $uid): ?User
    {
        $row = $this->getUserQuery()
            ->where(['uid' => $uid])
            ->one();

        if (!$row) {
            return null;
        }

        return new User(
            $row['uid'],
            $row['login'],
            $row['password'],
        );
    }

    public function createUser(User $user): void
    {
        (new Query())
            ->createCommand()
            ->insert(
                'user',
                [
                    'uid' => $user->getUid(),
                    'login' => $user->getLogin(),
                    'password' => $user->getEncodedPassword(),
                ]
            )
            ->execute();
    }

    private function getUserQuery(): Query
    {
        return (new Query())
            ->select(
                [
                    'uid',
                    'login',
                    'password',
                ]
            )
            ->from('user');
    }
}
