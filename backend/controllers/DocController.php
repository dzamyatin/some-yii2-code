<?php

namespace app\controllers;

use App\Shared\Doc\OpenApiService;
use yii\web\Controller;

class DocController extends Controller
{
    public function __construct(
        $id,
        $module,
        private OpenApiService $apiService
    ) {
        parent::__construct($id, $module);
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->apiService->build();
    }
}
