<?php
declare(strict_types=1);

namespace app\controllers;

use yii\web\Request;

final class TokenFromRequestExtractor
{
    public function extract(Request $request): string
    {
        $matches = [];
        preg_match('/Bearer (.+)/', $request->getHeaders()['Authorization'] ?? '', $matches);

        return (string) ($matches[1] ?? '');
    }
}
