<?php
use yii\helpers\Html;
use yii\helpers\Url;

$currentLanguage = Yii::$app->language;
?>
<h2><?= Yii::t('app', 'Alternative Offers') ?></h2>
<div class="slider_alt_wrapp">
    <div class="slider_controls_wrapp">
        <div class="col">
            <div class="slider_controls slider_alt_controls"></div>
        </div>
    </div>
    <div class="slider_alt">
        <?php foreach ($items as $one): ?>
            <?= $this->render('_AltCard', [
                'item' => $one,
                'target' => $target,
                'm2' => $m2,
                'places' => $places
            ]); ?>

        <?php endforeach; ?>
    </div>
</div>
