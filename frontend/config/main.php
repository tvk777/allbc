<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'defaultRoute'=> 'site',
    'sourceLanguage' => 'en',
    'language'=>'ua',
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
    ],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'i18n' => [
            'translations' => [
                'app' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    //'forceTranslation' => true,
                    'basePath' => '@common/messages',
                ],
            ],
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
            //'enableCsrfValidation' => false,
            'baseUrl' => '',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'class' => 'codemix\localeurls\UrlManager',
            'languages' => ['ua', 'ru', 'en'],
            'enableLanguageDetection' => false,
            'enableLanguagePersistence' => false,
            'rules' => [
                '' => 'site/index',
                'login' => 'site/login',
                'logout' => 'site/logout',
                'signup' => 'site/signup',
                'support' => 'site/support',
                'pages' => 'site/pages',
                'pages/sitemap' => 'site/sitemap',
                'pages/contacts' => 'site/contacts',
                'favorite' => 'page/favorite',
                '<controller:\w+>/<action:\w+>/' => '<controller>/<action>',
            ],
        ],
        'socialShare' => [
            'class' => \ymaker\social\share\configurators\Configurator::class,
            'enableIcons' => true,
            'icons' => [
                \ymaker\social\share\drivers\Twitter::class => 'social icon-twitter', // CSS class
                \ymaker\social\share\drivers\Facebook::class => 'social icon-facebook',  // CSS class
                \ymaker\social\share\drivers\Pinterest::class => 'social icon-pinterest',  // CSS class
                \ymaker\social\share\drivers\LinkedIn::class => 'social icon-linkedIn',  // CSS class
                \ymaker\social\share\drivers\Gmail::class => 'social icon-envelop',  // CSS class
            ],
            'socialNetworks' => [
                'facebook' => [
                    'class' => \ymaker\social\share\drivers\Facebook::class,
                ],
                'twitter' => [
                    'class' => \ymaker\social\share\drivers\Twitter::class,
                ],
                'pinterest' => [
                    'class' => \ymaker\social\share\drivers\Pinterest::class,
                ],
                'linkedIn' => [
                    'class' => \ymaker\social\share\drivers\LinkedIn::class,
                ],
                'gmail' => [
                    'class' => \ymaker\social\share\drivers\Gmail::class,
                ],
            ],
        ],
        'wishlist' => [
            'class' => 'kriptograf\wishlist\Wishlist'
        ],
    ],
    'modules' => [
        'wishlist' => [
            'class' => 'kriptograf\wishlist\Module',
            'dbDateExpired' => 'CURDATE() + INTERVAL 7 DAY', //дата истечения срока действия избранного в БД
            'cokieDateExpired' => time() + 86400 * 365, //Время жизни куки с токеном
        ],
    ],
    'params' => $params,
];
