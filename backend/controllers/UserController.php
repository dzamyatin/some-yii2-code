<?php

namespace app\controllers;

use App\Shared\User\Ui\Request\TokenProduceRequest;
use App\Shared\User\Ui\Request\TokenRefreshRequest;
use App\Shared\User\Ui\UserApi;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use yii\web\Controller;
use yii\web\Request;
use yii\web\Response;

class UserController extends Controller
{
    public $enableCsrfValidation = false;

    public function __construct(
        $id,
        $module,
        private UserApi $userApi,
        private NormalizerInterface $normalizer,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
    }

    public function actionRegister(Request $request): Response
    {
        $body = json_decode($request->getRawBody(), true);

        $this->normalizer->normalize(
            $this->userApi->tokenProduce(
                new TokenProduceRequest(
                    (string) ($body['login'] ?? ''),
                    (string) ($body['password'] ?? ''),
                )
            )
        );

        return (new Response())->setStatusCode(200);
    }

    public function actionToken(Request $request): Response
    {
        return $this->asJson(
            $this->normalizer->normalize(
                $this->userApi->tokenProduce(
                    new TokenProduceRequest(
                        (string) $request->getAuthUser(),
                        (string) $request->getAuthPassword(),
                    )
                )
            )
        );
    }

    public function actionRefresh(Request $request): Response
    {
        $matches = [];
        preg_match('/Bearer (.+)/', $request->getHeaders()['Authorization'] ?? '', $matches);

        return $this->asJson(
            $this->normalizer->normalize(
                $this->userApi->tokenRefresh(
                    new TokenRefreshRequest(
                        (string) ($matches[1] ?? '')
                    )
                )
            )
        );
    }
}
