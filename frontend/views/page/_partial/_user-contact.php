<?
$phone = !empty($user->userInfo->broker_phone) ? $user->userInfo->broker_phone : $user->userInfo->phone;
$short = substr($phone, 0, 3);
?>

<div class="hide_btn_wrapp">
    <p><a href="#" class="link_2" data-popup-link="popup_1"><?= $role.' - '.$user->userInfo->name ?></a></p>
    <div class="tel_pill_wrapp">
        <div>
            <a href="tel:<?= $phone ?>" class="green_pill tel_pill tel_pill_2 tel_hide_pill" data-tel-pill = "tel_pill_2_<?= $user->user_id ?>">
                <i class="tel_icon_white"></i><span class="tel_number"><?= $short ?>х хххххххх</span><span class="show_tel">Показать</span>
            </a>
        </div>
        <div>
            <a href="tel:<?= $phone ?>" class="white_pill tel_pill tel_pill_2 tel_visible_pill" data-tel-pill = "tel_pill_2_<?= $user->user_id ?>">
                <i class="tel_icon"></i><span class="tel_number"><?= $phone ?></span><span class="hide_tel">Скрыть</span></a>
        </div>
    </div>
</div>


