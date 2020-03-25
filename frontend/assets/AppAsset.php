<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/style.css',
        'css/responsive.css',
        'slick/slick.css',
        'vendors/css/jquery.fancybox.css',
        'vendors/css/select2.css',
        'vendors/css/nouislider.css',
    ];
    public $js = [
        'js/charts.js',
        'slick/slick.js',
        'vendors/js/select2.js',
        'vendors/js/jquery.fancybox.js',
        'vendors/js/nouislider.min.js',
        'vendors/js/wNumb.js',
        'js/scripts.js',
        'js/search.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];

    public function init()
    {
        parent::init();
        \Yii::$app->assetManager->bundles['yii\\bootstrap\\BootstrapAsset'] = [
            'css' => [],
            'js' => []
        ];
    }
}
