<?php
use yii\helpers\Html;
use yii\helpers\Url;

$currentLanguage = Yii::$app->language;
?>
<h2><?= Yii::t('app', 'Additional services') ?></h2>
<div class="thumbnails_3 offset_ziro">
    <?php foreach ($model as $one): ?>
        <a href="<?= Url::to(['page/services', 'slug' =>$one->slug->slug]); ?>" class="thumb_3">
            <?= Html::img($one->img->imgSrc, ['alt' => $one->name]) ?>
            <div class="descript">
                <h3><?= getDefaultTranslate('name', $currentLanguage, $one) ?></h3>
            </div>
        </a>
    <?php endforeach; ?>

</div>

