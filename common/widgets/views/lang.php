<?php
use yii\helpers\Html;
use yii\helpers\Url;
$dropdowmClass = '';
if (Yii::$app->controller->id != 'site' && Yii::$app->controller->action->id != 'index') {
    $dropdowmClass = 'dropdowm_wrapp_2';
}

?>
<div class="dropdowm_wrapp <?= $dropdowmClass ?> lang_switch">
    <div class="dropdown_title">
        <p class="p_width"><?= $currentLable ?></p>
        <input type="text" name="" placeholder="<?= $currentLable ?>" readonly/>
    </div>
    <div class="dropdown_menu">
        <ul>
            <? foreach ($array_lang as $lable => $lang) : ?>
                <? if ($lang !== $currentLanguage): ?>
                 <li><?= Html::a($lable, Url::current(['language' => $lang]));?></li>
                <? else: ?>
                <li class="active">
                    <?= Html::a($lable, Url::current(['language' => $lang]), ['class' => 'active']);?></li>
                <? endif; ?>
            <? endforeach; ?>
        </ul>
    </div>
</div>