<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
$currentLanguage = Yii::$app->language;
//debug($model);
$this->title = 'Service';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= getDefaultTranslate('name', $currentLanguage, $model) ?></h1>

    <p>This is the service page <?= $model->id ?></p>

</div>
