<?php

/* @var $this yii\web\View */

$currentLanguage = Yii::$app->language;


$this->title = getDefaultTranslate('title', $currentLanguage, $model);
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="content-sect">
    <div class="row">
        <h1><?= getDefaultTranslate('name', $currentLanguage, $model); ?></h1>

        <?= getDefaultTranslate('content', $currentLanguage, $model); ?>
    </div>
</section>
