<?php
use yii\helpers\Html;
?>

<div class="post-index">

    <h1><?= Yii::t('app','Список постов')?></h1>

    <?php foreach ($posts as $post) { ?>
        <div class="content">
            <?php $lang_data = $post->getDataPosts(); ?>

            <h3><?= $lang_data->title ?></h3>
            <h4><?= $lang_data->text ?></h4>
            <p><?= $post->author ?></p>
        </div>
        <?= Html::a(Yii::t('app','Читать далее'), ['post/view', 'url' => $post->url]) ?>
    <?php } ?>

</div>