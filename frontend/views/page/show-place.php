<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
$currentLanguage = Yii::$app->language;
//debug($model);
$this->title = 'Place';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><? echo $model->stage_name ?></h1>

    <p><? echo getDefaultTranslate('comment', $currentLanguage, $model) ?></p>

    <? //debug($model->images); ?>

</div>
