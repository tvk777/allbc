<?php
$this->registerJsFile( '/js/sliderResponsive.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('/css/sliderResponsive.css');
?>
<div class="promo-slider" id="bgslider">
<? foreach($images as $img) : ?>
    <div style="background-image:url(<?= $img['url']?>)">
      <a href="<?= $img['href'] ?>"><?= $img['title'] ?></a>
    </div>
<? endforeach; ?>
    </div>




			
