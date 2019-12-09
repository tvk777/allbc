<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
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
                'pages' => 'site/pages',
                'pages/sitemap' => 'site/sitemap',
                'pages/contacts' => 'site/contacts',
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
    ],
    'params' => $params,
];
