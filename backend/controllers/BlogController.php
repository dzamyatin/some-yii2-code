<?php

namespace app\controllers;

use App\Blog\Ui\BlogApi;
use App\Blog\Ui\Request\PostCreateRequest;
use App\Blog\Ui\Request\PostDeleteRequest;
use App\Blog\Ui\Request\PostsShowRequest;
use App\Blog\Ui\Request\PostUpdateRequest;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use yii\web\Controller;
use yii\web\Request;
use yii\web\Response;

class BlogController extends Controller
{
    public $enableCsrfValidation = false;

    public function __construct(
        $id,
        $module,
        private BlogApi $blogApi,
        private NormalizerInterface $normalizer,
        private TokenFromRequestExtractor $tokenFromRequestExtractor,
        $config = [],
    ) {
        parent::__construct($id, $module, $config);
    }

    public function actionIndex(Request $request): Response
    {
        return $this->asJson(
            $this->normalizer->normalize(
                $this->blogApi->postsShow(
                    new PostsShowRequest(
                        (int) $request->get('offset', 0),
                        (int) $request->get('offset', 10)
                    )
                )
            )
        );
    }

    public function actionCreate(Request $request): Response
    {
        $body = json_decode($request->getRawBody(), true);

        $this->blogApi->postCreate(
            new PostCreateRequest(
                $this->tokenFromRequestExtractor->extract($request),
                (string) ($body['header'] ?? ''),
                (string) ($body['text'] ?? ''),
            )
        );

        return (new Response())->setStatusCode(201);
    }

    public function actionUpdate(Request $request): Response
    {
        $body = json_decode($request->getRawBody(), true);

        $this->blogApi->postUpdate(
            new PostUpdateRequest(
                $this->tokenFromRequestExtractor->extract($request),
                (string) ($body['postUid'] ?? ''),
                (string) ($body['header'] ?? ''),
                (string) ($body['text'] ?? ''),
            )
        );

        return new Response();
    }

    public function actionDelete(Request $request): Response
    {
        $body = json_decode($request->getRawBody(), true);

        $this->blogApi->postDelete(
            new PostDeleteRequest(
                $this->tokenFromRequestExtractor->extract($request),
                (string) ($body['postUid'] ?? ''),
            )
        );

        return new Response();
    }
}
