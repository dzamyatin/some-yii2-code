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
        return 'list!';
    }

    /**
     * @return string
     */
    public function actionCreate()
    {
        return 'create!';
    }

    /**
     * @return string
     */
    public function actionUpdate()
    {
        return 'update!';
    }

    /**
     * @return string
     */
    public function actionDelete()
    {
        return 'delete!';
    }
}
