<?php
declare(strict_types=1);

namespace app\controllers;

use App\Shared\Common\Ui\Response\AbstractResponseException;
use yii\web\ErrorHandler;
use yii\web\Response;

class ApiErrorHandler extends ErrorHandler
{
    protected function renderException($exception)
    {
        if (!$exception instanceof AbstractResponseException) {
            parent::renderException($exception);

            return;
        }

        $response = new Response();
        $response->setStatusCode($exception->getHttpCode());
        $response->headers->add('Content-Type', 'application/json');
        $response->content = json_encode($exception);
        $response->send();
    }
}
