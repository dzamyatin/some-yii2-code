<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

class UserController extends Controller
{
    /**
     * @return string
     */
    public function actionRegister()
    {
        return 'register!';
    }

    /**
     * @return string
     */
    public function actionLogin()
    {
        return 'login!';
    }

    /**
     * @return string
     */
    public function actionRefresh()
    {
        return 'refresh!';
    }
}
