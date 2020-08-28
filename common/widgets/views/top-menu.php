<?php
use yii\helpers\Html;
use yii\helpers\Url;
$currentLanguage = Yii::$app->language;
?>


<ul>
    <?php foreach ($menu as $item): ?>
        <?php
        $text = getDefaultTranslate('text', $currentLanguage, $item);
        $class = Url::current()===$item->url ? 'active' : null;
        ?>
        <li><?= Html::a($text, [$item->url], ['class' => $class]) ?></li>
    <?php endforeach; ?>
</ul>


			
