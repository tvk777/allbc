<?php
$script = <<< JS
var $tablId = $("#$tablId").stupidtable();
$tablId.on("aftertablesort", function (event, data) {
        var th = $(this).find("th.thm2");
        th.find(".arrow").remove();
        var dir = $.fn.stupidtable.dir;

        var arrow = data.direction === dir.ASC ? 
            '<span class="green">&uarr;</span>&darr;' : 
            '&uarr;<span class="green">&darr;</span>';
        th.append('<span class="arrow">' + arrow +'</span>');
      });

JS;
$this->registerJs($script, $this::POS_READY, 'stupidtable'.$tablId);
?>

<section>
    <div class="row row_2">
        <div class="inner_box">
            <div class="title_wrapp_3">
                <h2><?= $blockTitle ?></h2>
            </div>
            <div class="two_cols_3 two_cols_3_2 clearfix">
                <div class="right">
                    <div class="galleries_wrapp" data-galleries="<?= $galleryId ?>">
                        <? foreach ($places as $index => $place) : ?>
                            <div class="office_gallery" data-officegallery-index="<?= $index ?>">
                                <div class="gallery_2">
                                    <? if (count($place->images) > 0) : ?>
                                        <? $hidden = ''; ?>
                                        <? foreach ($place->images as $k => $img) : ?>
                                            <? if($k>2) $hidden='hidden'; ?>
                                            <a href="<?= $img->imgSrc ?>" class="img_box <?= $hidden ?>"
                                               style="background-image: url(<?= $img->imgSrc ?>);"
                                               data-fancybox="gallery_<?= $index ?>"></a>
                                        <? endforeach; ?>
                                    <? endif; ?>
                                </div>

                                <div class="slidedown_box">
                                    <div class="prev_content">
                                        <p>2Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                                            tempor incididunt ut labore et dolore magna aliqua. <a href="#"
                                                                                                   class="green_link slideLink slidedown_link"><i
                                                    class="plus"></i><span class="show">Показать больше</span></a>&nbsp;&nbsp;<a
                                                href="#contacts" class="green_link scroll_link">Смотреть
                                                контакты</a>
                                        </p>
                                    </div>
                                    <div class="show_content">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim
                                            veniam,
                                            quis nostrud.</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim
                                            veniam,
                                            quis nostrud.</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim
                                            veniam,
                                            quis nostrud.</p>
                                        <a href="#" class="green_link slideLink slideup_link"><span class="hide">Свернуть</span></a>&nbsp;&nbsp;<a
                                            href="#contacts" class="green_link scroll_link">Смотреть контакты</a>
                                    </div>
                                </div>
                            </div>
                        <? endforeach; ?>
                    </div>
                </div>
                <div class="left">
                    <div class="scroll_x">
                        <table id="<?= $tablId ?>" class="table_5 places_table"
                               data-galleries-table="<?= $galleryId ?>">
                            <thead>
                            <tr class="table_row head">
                                <th data-sort="int" class="table_cell thm2">
                                    <h4>м²</h4><span class="arrow">&uarr;&darr;</span>
                                </th>
                                <th class="table_cell">
                                    <h4>BOMA</h4>
                                </th>
                                <th class="table_cell">
                                    <div class="custom_select_wrapp custom_select_wrapp_3">
                                        <div class="custom_select">
                                            <div>
                                                <input type="hidden" class="select_res currency" value="uah">
                                                <p class="select_input"><span class="sel_val">₴/m²</span></p>
                                            </div>
                                            <div class="dropdown_select change-currency">
                                                <div class="select_item">
                                                    <span data-currid="uah">₴/m²</span>
                                                </div>
                                                <div class="select_item">
                                                    <span data-currid="usd">$/m²</span>
                                                </div>
                                                <div class="select_item">
                                                    <span data-currid="eur">€/m²</span>
                                                </div>
                                                <div class="select_item">
                                                    <span data-currid="rub">₽/m²</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                                <th class="table_cell">
                                    <h4>ОРЕХ</h4>
                                </th>
                                <th class="table_cell">
                                    <div class="custom_select_wrapp custom_select_wrapp_3">
                                        <div class="custom_select">
                                            <div>
                                                <input type="hidden" class="select_res period" value="month">
                                                <p class="select_input"><span class="sel_val">All in/мес</span></p>
                                            </div>
                                            <div class="dropdown_select change-period">
                                                <div class="select_item">
                                                    <span data-period="month">all in/мес</span>
                                                </div>
                                                <div class="select_item">
                                                    <span data-period="m2">all in/m2</span>
                                                </div>
                                                <div class="select_item">
                                                    <span data-period="year">all in/год</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                                <th class="table_cell">
                                    <!-- <div class="star_checkbox">
                                        <input type="radio" name="strar_1" id="star_1">
                                        <label for="star_1"></label>
                                    </div> -->
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <? foreach ($places as $index => $place) : ?>
                                <?
                                $plus = '';
                                $placePrices = $place->prices;
                                $prices = count($placePrices) > 0 ? $place->getPricePeriod($placePrices) : Yii::t('app', 'con.');
                                if (count($placePrices) > 0) {
                                    $uah = $prices['uah']['m2'];
                                    $month_uah = $prices['uah']['month'];
                                    $year_uah = $prices['uah']['year'];
                                    $m2_uah = $prices['uah']['m2_2'];

                                    if ($uah < $m2_uah) $plus = '+';

                                    $usd = $prices['usd']['m2'];
                                    $month_usd = $prices['usd']['month'];
                                    $year_usd = $prices['usd']['year'];
                                    $m2_usd = $prices['usd']['m2_2'];

                                    $eur = $prices['eur']['m2'];
                                    $month_eur = $prices['eur']['month'];
                                    $year_eur = $prices['eur']['year'];
                                    $m2_eur = $prices['eur']['m2_2'];

                                    $rub = $prices['rub']['m2'];
                                    $month_rub = $prices['rub']['month'];
                                    $year_rub = $prices['rub']['year'];
                                    $m2_rub = $prices['rub']['m2_2'];
                                } else {
                                    $uah = $usd = $eur = $rub = Yii::t('app', 'con.');
                                    $month_uah = $month_usd = $month_eur = $month_rub = Yii::t('app', 'con.');
                                    $year_uah = $year_usd = $year_eur = $year_rub = Yii::t('app', 'con.');
                                    $m2_uah = $m2_usd = $m2_eur = $m2_rub = Yii::t('app', 'con.');
                                }
                                $sortValue = $place->m2min > 0 ? $place->m2min : $place->m2;
                                ?>

                                <tr class="table_row" data-officegallery-index="<?= $index ?>" id="place<?= $place->id ?>">
                                    <td class="table_cell" data-sort-value="<?= $sortValue ?>">
                                        <p><?= $place->m2range ?></p>
                                    </td>
                                    <td class="table_cell">
                                        <p><?= $place->tax > 0 ? $place->tax . '%' : '' ?></p>
                                    </td>
                                    <td class="table_cell m2"
                                        data-usd="<?= $usd ?>"
                                        data-uah="<?= $uah ?>"
                                        data-eur="<?= $eur ?>"
                                        data-rub="<?= $rub ?>"
                                    >
                                        <p><?= $uah . $plus ?></p>
                                    </td>
                                    <td class="table_cell">
                                        <p><?= $place->opex > 0 ? $place->opex . '+' : '' ?></p>
                                    </td>
                                    <td class="table_cell period"
                                        data-month_usd="<?= $month_usd ?>"
                                        data-month_uah="<?= $month_uah ?>"
                                        data-month_eur="<?= $month_eur ?>"
                                        data-month_rub="<?= $month_rub ?>"
                                        data-year_usd="<?= $year_usd ?>"
                                        data-year_uah="<?= $year_uah ?>"
                                        data-year_eur="<?= $year_eur ?>"
                                        data-year_rub="<?= $year_rub ?>"
                                        data-m2_usd="<?= $m2_usd ?>"
                                        data-m2_uah="<?= $m2_uah ?>"
                                        data-m2_eur="<?= $m2_eur ?>"
                                        data-m2_rub="<?= $m2_rub ?>"
                                    >
                                        <input id="period" type="hidden" value="1"/>
                                        <p><?= $month_uah ?></p>
                                    </td>
                                    <td class="table_cell">
                                        <a href="#" class="photo_link"></a>
                                        <div class="star_checkbox">
                                            <input type="checkbox" name="star_<?= $index ?>" id="star_<?= $index ?>">
                                            <label for="star_<?= $index ?>"></label>
                                        </div>
                                    </td>
                                </tr>
                            <? endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
</section>
