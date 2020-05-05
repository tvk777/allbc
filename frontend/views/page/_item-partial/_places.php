<?php
use kriptograf\wishlist\widgets\WishlistButton;
use yii\helpers\Url;
use yii\helpers\Html;

?>
<section  class="grey_bg">
    <div class="row row_2">
        <div class="col-xs-12">
            <div class="title_places" id="places">
                <h2><?= $blockTitle ?></h2>
            </div>

            <? foreach ($places as $index => $place) : ?>
                <? //debug($place->slug) ?>

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

                <div class="col-xs-12 place-card">
                    <div class="col-md-4 col-sm-12 img">
                        <div class="favor-star">
                            <div class="black_circle_2">
                                <?= WishlistButton::widget([
                                    'model' => $place,
                                    'anchorActive' => '<i class="star_icon_2 rem"></i>',
                                    'anchorUnactive' => '<i class="star_icon_2"></i>',
                                    'cssClass' => 'card out-wish',
                                    'cssClassInList' => 'in-wish',
                                    //'building' => $building
                                ]); ?>
                            </div>
                        </div>
                        <? if (!empty($place->slides)) : ?>
                            <div class="object_slider">
                                <? foreach ($place->slides as $slide): ?>
                                    <div class="slide">
                                        <a href="<?= $slide['big'] ?>" class="img_box place"
                                           data-fancybox="card_1<?= $place->id ?>"
                                           data-imageurl="<?= $slide['big'] ?>"><img src="#" alt=""/></a>
                                    </div>
                                <? endforeach; ?>
                            </div>
                        <? else: ?>
                            <div class="slide-empty">&nbsp;</div>
                        <? endif; ?>
                    </div>
                    <div class="object_content left col-md-4 col-sm-12">
                        <div class="row bold">
                            <div class="col-xs-6 header-item__name"><p>Площа:</p></div>
                            <div class="col-xs-6 header-item__value"><p><?= $place->m2range ?> м2</p></div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 header-item__name"><p>Коефіцієнт загальних площ:</p></div>
                            <div class="col-xs-6 header-item__value"><p>+15%</p></div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 header-item__name"><p>Поверх:</p></div>
                            <div class="col-xs-6 header-item__value"><p><?= $place->stage_name ?></p></div>
                        </div>

                        <div class="row">
                            <div class="col-xs-6 header-item__name"><p>Стан приміщення:</p></div>
                            <div class="col-xs-6 header-item__value"><p><?= $place->status->name ?></p></div>
                        </div>

                    </div>
                    <div class="object_content col-md-4 col-sm-12">
                        <div class="row bold">
                            <div class="col-xs-6 header-item__name"><p>Оренда:</p></div>
                            <div class="col-xs-6 header-item__value text__select">
                                <div class="header-item__value">
                                    <div class="table_cell m2"
                                         data-usd="<?= $usd ?>"
                                         data-uah="<?= $uah ?>"
                                         data-eur="<?= $eur ?>"
                                         data-rub="<?= $rub ?>"
                                    >
                                        <p><?= $uah . $plus ?></p>
                                    </div>
                                </div>
                                <div class="custom_select">
                                    <div>
                                        <input type="hidden" class="select_res currency" value="uah">
                                        <p class="select_input"><span class="sel_val">₴/m²</span></p>
                                    </div>
                                    <div class="dropdown_select change-currency-single">
                                        <div class="select_item">
                                            <span data-currid="uah">₴/m²/мес</span>
                                        </div>
                                        <div class="select_item">
                                            <span data-currid="usd">$/m²/мес</span>
                                        </div>
                                        <div class="select_item">
                                            <span data-currid="eur">€/m²/мес</span>
                                        </div>
                                        <div class="select_item">
                                            <span data-currid="rub">₽/m²/мес</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 header-item__name"><p>Податки:</p></div>
                            <div class="col-xs-6 header-item__value"><p>вкл НДФЛ</p></div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 header-item__name"><p>OPEX:</p></div>
                            <div class="col-xs-6 header-item__value"><p><?= $place->opex ?> ₴/m²/мес + НДС</p></div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 header-item__name"><p>Комунальнi:</p></div>
                            <div class="col-xs-6 header-item__value"><p>+ опалення, вода, эл/эн</p></div>
                        </div>

                    </div>

                    <div class="col-sm-12 button">
                        <div class="col-md-4"></div>
                        <div class="col-md-4 col-sm-12 link-more">
                            <a href="/<?= $place->slug->slug ?>" class="green_pill">
                                <?= Yii::t('app', 'See More') ?>
                            </a>
                        </div>

                        <div class="col-md-4 col-sm-12">
                            <div class="all-in bold">
                                <div class="col-xs-6 header-item__name"><p>Все включено:</p></div>
                                <div class="col-xs-6 header-item__value text__select">
                                    <div class="header-item__value">
                                        <div class="table_cell period"
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
                                        </div>
                                    </div>
                                    <div class="header-item__name">
                                        <div class="custom_select_wrapp custom_select_wrapp_3">
                                            <div class="custom_select">
                                                <div>
                                                    <input type="hidden" class="select_res period" value="month">
                                                    <p class="select_input"><span class="sel_val">All in/мес</span></p>
                                                </div>
                                                <div class="dropdown_select change-period-single">
                                                    <div class="select_item">
                                                        <span data-period="month">₴/мес</span>
                                                    </div>
                                                    <div class="select_item">
                                                        <span data-period="m2">₴/m2</span>
                                                    </div>
                                                    <div class="select_item">
                                                        <span data-period="year">₴/год</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            <? endforeach; ?>
        </div>
    </div>
</section>

