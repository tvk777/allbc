<?php
use yii\helpers\Html;
use yii\helpers\Url;

$dropdowmClass = '';
if (Yii::$app->controller->id != 'site' && Yii::$app->controller->action->id != 'index') {
    $dropdowmClass = 'dropdowm_wrapp_2';
}

?>
<div class="dropdowm_wrapp <?= $dropdowmClass ?> currency_switch">
    <div class="dropdown_title">
        <p class="p_width">₴</p>
        <input type="text" name="" placeholder="₴" readonly/>
    </div>
    <div class="dropdown_menu">
        <ul>
            <li class="active"><a href="#">₴</a></li>
            <li><a href="#">$</a></li>
            <li><a href="#">€</a></li>
            <li><a href="#">₽</a></li>
        </ul>
    </div>
</div>