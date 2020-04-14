<?php
use yii\helpers\Html;

$currentLanguage = Yii::$app->language;
?>


<ul class="top-menu">
    <?php foreach ($menu as $item): ?>
        <?php $text = getDefaultTranslate('text', $currentLanguage, $item); ?>
        <li><?= Html::a($text, [$item->url]) ?></li>
    <?php endforeach; ?>
</ul>


			
