<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

class BlogController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        return 'hello!';
    }
}
