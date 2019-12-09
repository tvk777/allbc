<?php
use yii\helpers\Html;
?>

<h2><?= Yii::t('app', 'Our Partners') ?></h2>
<div class="thumbnails_2 slider_partners">
    <?php foreach ($images as $img): ?>
        <a href="#" class="thumb_2">
            <?= Html::img($img, ['alt' => '']) ?>
        </a>
    <?php endforeach; ?>
</div>

			
