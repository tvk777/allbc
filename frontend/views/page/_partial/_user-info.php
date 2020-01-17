<div class="inner">
    <div class="author_wrapp">
        <? if (!empty($user->userInfo->avatar->thumb260x260Src)) : ?>
            <div class="col">
                <div class="author_photo">
                    <img src="<? echo $user->userInfo->avatar->thumb260x260Src ?>"
                         alt=""/>
                </div>
            </div>
        <? endif; ?>
        <div class="col">
            <h3><? echo $user->userInfo->name ?></h3>
            <p class="desc_p_2"><b><?= $role ?></b><span
                    class="border_line_2"> |</span><?= $comission ?></p>
            <p><a href="<?= $city_url . '?filter[user]=' . $user->user_id ?>"
                  class="green_link_3">Другие объявления автора</a></p>
        </div>
    </div>
    <? if (!empty($user->userInfo->phone) || !empty($user->userInfo->broker_phone)) : ?>
        <? $phone = !empty($user->userInfo->broker_phone) ? $user->userInfo->broker_phone : $user->userInfo->phone;
        $short = substr($phone, 0, 3); ?>
        <div class="tel_pill_wrapp tel_pill_wrapp_resp">
            <div>
                <a href="tel:<?= $phone ?>" class="green_pill tel_pill tel_hide_pill"
                   data-tel-pill="tel_pill_<?= $user->user_id ?>"><i class="tel_icon_white"></i> <span
                        class="tel_number"><?= $short ?>х хххххххх</span><span
                        class="show_tel">Показать</span></a>
            </div>
            <div>
                <a href="tel:<?= $phone ?>" class="white_pill tel_pill tel_visible_pill"
                   data-tel-pill="tel_pill_<?= $user->user_id ?>"><i class="tel_icon"></i> <span
                        class="tel_number"><?= $phone ?></span><span
                        class="hide_tel">Скрыть</span></a>
            </div>
        </div>
    <? endif; ?>
</div>
