<?php
use yii\helpers\Html;
use yii\helpers\Url;

$currentLanguage = Yii::$app->language;
?>
<h2><?= Yii::t('app', 'Alternative Offers') ?></h2>
<div class="text_box" id="slide_alt" data-minheight="400">
<div class="objects_cards objects_cards_2 inner_height">
        <?php foreach ($items as $one): ?>
            <?= $this->render('@frontend/views/page/_partial/_card', [
                'item' => $one,
                'target' => $target,
                'm2' => $m2,
                'places' => $places
            ]); ?>

        <?php endforeach; ?>
</div>
</div>
<div class="showmore_wrapp">
    <a href="#" class="green_link show_text" data-slidebox-id = "slide_alt"><i class="plus"></i><span class="show">Показать больше</span><span class="hide">Свернуть</span></a>
</div>

