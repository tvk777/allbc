<?php
$this->registerJsFile('/js/sliderResponsive.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('/css/sliderResponsive.css');
?>
<div class="promo-slider-bc" id="bgslider">
    <? foreach ($images as $img) : ?>
        <div style="background-image:url(<?= $img['url'] ?>)">
        </div>
    <? endforeach; ?>
</div>
<div class="slider-content row">
    <h1><?= $text[0] ?></h1>
    <h2><?= $text[1] ?></h2>
</div>





			
