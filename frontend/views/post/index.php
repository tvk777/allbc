<?php
use yii\helpers\Html;
$currentLanguage = Yii::$app->language;
//debug($posts);
?>

<div class="post-index">

    <h1><?= Yii::t('app', 'Список постов') ?></h1>

    <?php foreach ($posts as $post) {
        //debug($post->translations);
        ?>
        <div class="content_ru">
            <h3><?= getDefaultTranslate('title', $currentLanguage, $post) ?></h3>
            <h4><?= getDefaultTranslate('content', $currentLanguage, $post) ?></h4>
        </div>
    <?php } ?>
</div>