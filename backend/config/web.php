<?php

use App\Blog\Application\Command\PostCreate;
use App\Blog\Application\Command\PostDelete;
use App\Blog\Application\Command\PostUpdate;
use App\Blog\Application\Query\PostsShow;
use App\Blog\Domain\Repository\PostRepositoryInterface;
use App\Blog\Infrastructure\Repository\PostRepository;
use App\Blog\Ui\BlogApi;
use app\controllers\ApiErrorHandler;
use app\controllers\TokenFromRequestExtractor;
use App\Shared\Doc\OpenApiService;
use App\Shared\User\Application\Command\UserRegister;
use App\Shared\User\Application\Query\UserTokenProduce;
use App\Shared\User\Application\Query\UserTokenRefresh;
use App\Shared\User\Domain\Repository\PasswordRepositoryInterface;
use App\Shared\User\Domain\Repository\UserRepositoryInterface;
use App\Shared\User\Domain\Repository\UserTokenRepositoryInterface;
use App\Shared\User\Domain\Repository\UuidRepositoryInterface;
use App\Shared\User\Infrastructure\Repository\PasswordRepository;
use App\Shared\User\Infrastructure\Repository\UserRepository;
use App\Shared\User\Infrastructure\Repository\UserTokenRepository;
use App\Shared\User\Infrastructure\Repository\UuidRepository;
use App\Shared\User\Ui\UserApi;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\JsonSerializableNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'Jh_enreHxbjZrp71eKL8F36nPsLglloX',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'class' => ApiErrorHandler::class,
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'POST user/register' => 'user/register',
                'POST user/token' => 'user/token',
                'POST user/refresh' => 'user/refresh',

                'GET blog' => 'blog/index',
                'POST blog' => 'blog/create',
                'PUT blog/<uid>' => 'blog/update',
                'DELETE blog/<uid>' => 'blog/delete',
            ],
        ],
    ],
    'params' => $params,
    'container' => [
        'singletons' => [
            TokenFromRequestExtractor::class => TokenFromRequestExtractor::class,
            OpenApiService::class => static fn() =>  new OpenApiService(
                [
                    __DIR__ . '/../app/Blog/Ui',
                    __DIR__ . '/../app/Shared/User/Ui',
                ]
            ),

            //Serializer
            SerializerInterface::class => static fn() => new Serializer(
                [
                    new GetSetMethodNormalizer(),
                    new ArrayDenormalizer(),
                    new PropertyNormalizer(),
                    new JsonSerializableNormalizer()
                ],
                [
                    new JsonEncoder()
                ]
            ),
            NormalizerInterface::class => SerializerInterface::class,
            DenormalizerInterface::class => SerializerInterface::class,

            //Repositories
            PostRepositoryInterface::class => static fn() => new PostRepository(),
            UuidRepositoryInterface::class => static fn() => new UuidRepository(),
            UserTokenRepositoryInterface::class => static fn() => new UserTokenRepository(),
            UserRepositoryInterface::class => static fn() => new UserRepository(),
            PasswordRepositoryInterface::class => static fn() => new PasswordRepository(),

            //Command
            PostsShow::class => static fn() => new PostsShow(
                Yii::$container->get(PostRepositoryInterface::class)
            ),
            PostCreate::class => static fn() => new PostCreate(
                Yii::$container->get(PostRepositoryInterface::class),
                Yii::$container->get(UuidRepositoryInterface::class),
                Yii::$container->get(UserTokenRepositoryInterface::class),
            ),
            PostDelete::class => static fn() => new PostDelete(
                Yii::$container->get(PostRepositoryInterface::class),
                Yii::$container->get(UserTokenRepositoryInterface::class),
            ),
            PostUpdate::class => static fn() => new PostUpdate(
                Yii::$container->get(PostRepositoryInterface::class),
                Yii::$container->get(UserTokenRepositoryInterface::class),
            ),
            UserRegister::class => static fn() => new UserRegister(
                Yii::$container->get(UserRepositoryInterface::class),
                Yii::$container->get(UuidRepositoryInterface::class),
                Yii::$container->get(PasswordRepositoryInterface::class),
            ),
            UserTokenProduce::class => static fn() => new UserTokenProduce(
                Yii::$container->get(UserRepositoryInterface::class),
                Yii::$container->get(UserTokenRepositoryInterface::class),
                Yii::$container->get(PasswordRepositoryInterface::class),
            ),
            UserTokenRefresh::class => static fn() => new UserTokenRefresh(
                Yii::$container->get(UserRepositoryInterface::class),
                Yii::$container->get(UserTokenRepositoryInterface::class),
            ),

            //Ui
            BlogApi::class => static fn() => new BlogApi(
                Yii::$container->get(PostCreate::class),
                Yii::$container->get(PostDelete::class),
                Yii::$container->get(PostUpdate::class),
                Yii::$container->get(PostsShow::class),
            ),
            UserApi::class => static fn() => new UserApi(
                Yii::$container->get(UserRegister::class),
                Yii::$container->get(UserTokenProduce::class),
                Yii::$container->get(UserTokenRefresh::class),
            ),
        ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
