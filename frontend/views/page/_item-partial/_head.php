<?php
use yii\helpers\Html;

$logoImg = Html::a(Html::img('@web/img/logo_2.svg', ['alt' => 'Логотип', 'class' => 'logo_black']), ['/']);
$phone = !empty($user->broker_phone) ? $user->broker_phone : $user->phone;
$short = substr($phone, 0, 3);

//debug($user);
?>
<div id="filters" class="item-invis">
    <div class="filter_nav">
        <div class="row">
            <div class="left-head"><?= $name ?></div>
            <div class="center"><?= $logoImg ?></div>
            <div class="right-head">
                <div class="tel_pill_wrapp">
                    <div>
                        <a href="#contacts" class="scroll_to green_pill tel_pill tel_pill_2 tel_hide_pill" data-tel-pill = "tel_pill_2_<?= $user->id ?>">
                            <i class="tel_icon_white"></i><span class="tel_number"><?= $short ?>х хххххххх</span><span class="show_tel">Показать</span>
                        </a>
                    </div>
                    <div>
                        <a href="#contacts" class="scroll_to white_pill tel_pill tel_pill_2 tel_visible_pill" data-tel-pill = "tel_pill_2_<?= $user->id ?>">
                            <i class="tel_icon"></i><span class="tel_number"><?= $phone ?></span><span class="hide_tel">Скрыть</span></a>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
