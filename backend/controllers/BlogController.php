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
        $config = [],
    ) {
        parent::__construct($id, $module);
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
                $request->getHeaders()['Authorization'] ?? '',
                $body['header'] ?? '',
                $body['text'] ?? '',
            )
        );

        return (new Response())->setStatusCode(201);
    }

    public function actionUpdate(Request $request): Response
    {
        $body = json_decode($request->getRawBody(), true);

        $this->blogApi->postUpdate(
            new PostUpdateRequest(
                $request->getHeaders()['Authorization'] ?? '',
                $body['postUid'],
                $body['header'],
                $body['text'],
            )
        );

        return new Response();
    }

    public function actionDelete(Request $request): Response
    {
        $body = json_decode($request->getRawBody(), true);

        $this->blogApi->postDelete(
            new PostDeleteRequest(
                $request->getHeaders()['Authorization'] ?? '',
                $body['postUid'],
            )
        );

        return new Response();
    }
}
