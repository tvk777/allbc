<?php
$url = strpos($city_url, 'filter[') ? $city_url . '&filter[user]=' . $user->id : $city_url . '?filter[user]=' . $user->id;
?>
<div class="inner">
    <div class="author_wrapp">
        <? if (!empty($user->avatar->thumb260x260Src)) : ?>
            <div class="col">
                <div class="author_photo">
                    <img src="<? echo $user->avatar->thumb260x260Src ?>"
                         alt=""/>
                </div>
            </div>
        <? endif; ?>
        <div class="col">
            <h3><? echo $user->name ?></h3>
            <p class="desc_p_2"><b><?= $role ?></b><span
                    class="border_line_2"> |</span><?= $comission ?></p>
            <p><a href="<?= $url ?>"
                  class="green_link_3">Другие объявления автора</a></p>
        </div>
    </div>
    <? if (!empty($user->phone) || !empty($user->broker_phone)) : ?>
        <? $phone = !empty($user->broker_phone) ? $user->broker_phone : $user->phone;
        $short = substr($phone, 0, 3); ?>
        <div class="tel_pill_wrapp tel_pill_wrapp_resp">
            <div>
                <a href="tel:<?= $phone ?>" class="green_pill tel_pill tel_hide_pill"
                   data-tel-pill="tel_pill_<?= $user->id ?>"><i class="tel_icon_white"></i> <span
                        class="tel_number"><?= $short ?>х хххххххх</span><span
                        class="show_tel">Показать</span></a>
            </div>
            <div>
                <a href="tel:<?= $phone ?>" class="white_pill tel_pill tel_visible_pill"
                   data-tel-pill="tel_pill_<?= $user->id ?>"><i class="tel_icon"></i> <span
                        class="tel_number"><?= $phone ?></span><span
                        class="hide_tel">Скрыть</span></a>
            </div>
        </div>
    <? endif; ?>
</div>
