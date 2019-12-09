<?php
$currentLanguage = Yii::$app->language;
?>
<h2> <?= Yii::t('app', 'News') ?></h2>
<div class="slider_4_wrapp">
    <div class="slider_controls_wrapp">
        <div class="col">
            <a href="#" class="green_pill"><?= Yii::t('app', 'All News') ?></a>
        </div>
        <div class="col">
            <div class="slider_controls slider_4_controls"></div>
        </div>
    </div>
    <div class="slider_4">
     <? if (count($model)>0) : ?>  
         <? foreach($model as $one) : ?>
        <div class="slide">
            <a href="<?= $one->slug->slug ?>" class="thumb_6">
                <div class="thumb_6_img_box">
                    <img src="<?= $one->image->imgSrc ?>" alt="" />
                </div>
                <div class="descript">
                    <p class="date"><?= Yii::$app->formatter->asDate($one->published_at, 'long'); ?></p>
                    <h3><?= getDefaultTranslate('name', $currentLanguage, $one) ?></h3>
                </div>
            </a>
        </div>
             <? endforeach; ?>
        <? endif; ?>

    </div>
</div>
