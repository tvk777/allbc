<?php
$currentLanguage = Yii::$app->language;
?>
<h2> <?= Yii::t('app', 'About Us') ?></h2>
<div class="text_box" id="slide_text" data-minheight="142">
    <div class="inner_height">
        <?= getDefaultTranslate('content', $currentLanguage, $model) ?>
    </div>
</div>
<div class="showmore_wrapp">
    <a href="#" class="green_link show_text" data-slidebox-id="slide_text">
        <i class="plus"></i>
        <span class="show"><?= Yii::t('app', 'Show more') ?></span>
        <span class="hide"><?= Yii::t('app', 'Collapse') ?></span>
    </a>
</div>

