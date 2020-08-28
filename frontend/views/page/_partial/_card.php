<?php
use yii\helpers\Html;
use kriptograf\wishlist\widgets\WishlistButton;

$paramTarget = $target == 1 ? 'rent' : 'sell';
//$href = Url::to(['page/bc_item', 'slug' => $item->slug->slug, 'target' => $paramTarget]);
//$href = '/' . $item->slug->slug . '?target=' . $paramTarget;
//$itemName = getDefaultTranslate('name', $currentLanguage, $item);
//echo 'text='.getCurrencyText ($currency);
//debug($item['bc']);

if ($result == 'bc') {
    $cardItem = $item['bc'];
    $id = $cardItem->id;
    $modelWishlist = $cardItem->bcitem;
    $href = '/' . $cardItem->bcitem->slug->slug . '?target=' . $paramTarget;
    $itemName = getDefaultTranslate('name', $currentLanguage, $cardItem->bcitem, true);
    $city = $cardItem->bcitem->city->name;
    $district = $cardItem->bcitem->district ? $cardItem->bcitem->district->name . ' р-н' : '';
    $address = $cardItem->bcitem->address;
    $plus = getPlusForBC($item['places'], $target) ? '++' : '';
    $minPrice = getBcMinPrice($item, $currency, $rates[$currency], $target);
    //$priceForAll = '';
    $itemPlaces = $item['places'];
    $itemSubway = !empty($cardItem->bcitem->subways[0]) ? $cardItem->bcitem->subways[0] : null;
    $itemClass = getDefaultTranslate('name', $currentLanguage, $cardItem->bcitem->class, true);
    $slides = !empty($cardItem->bcitem->slides) ? $cardItem->bcitem->slides : null;
    $itemComission = $cardItem->bcitem->percent_commission;
    $building = 'bc';
    $priceInfo = '';
    $squareInfo = '';
    $countItemPlaces = count($itemPlaces);
    if ($countItemPlaces > 1) {
        $priceInfo = Yii::t('app', 'from') . ' ' . $minPrice;
        $squareInfo .= 'от '.$cardItem->minM2 . ' до ' . $cardItem->maxM2 . ' м²';
    } elseif ($countItemPlaces == 1) {
        $priceInfo = $minPrice;
        $itemPlace = $itemPlaces[0];
        $squareInfo .= $itemPlace->m2min ? 'от '.$itemPlace->m2min . ' до ' . $itemPlace->m2 . ' м²' : $itemPlace->m2 . ' м²';
    }
} else {
    $cardItem = $item->place->bcitem; //bc
    $placeItem = $item->place; //place
    $id = $placeItem->id;
    $itemPlaces = null;
    $modelWishlist = $placeItem;
    $itemName = getDefaultTranslate('name', $currentLanguage, $placeItem, true);
    $href = '/' . $placeItem->slug->slug . '?target=' . $paramTarget;
    $city = $cardItem->city->name;
    $district = $cardItem->district ? $cardItem->district->name . ' р-н' : '';
    $address = $placeItem->hide_bc == 1 ? $cardItem->street : $cardItem->address;
    $minmax = !empty($placeItem->m2min) ? $item->m2min . ' m² - ' . $item->m2 . ' m²' : $item->m2 . ' m²';
    $placePrices = getPlacePrices($item, $currency, $rates, $taxes, $target);
    $minPrice = $placePrices['forM2'];
    //$priceForAll = $placePrices['forAll'];
    $itemPlaces = null;
    $placesInfo = null;
    $itemSubway = !empty($cardItem->subways[0]) ? $cardItem->subways[0] : null;
    $itemClass = getDefaultTranslate('name', $currentLanguage, $cardItem->class, true);
    $slides = !empty($cardItem->slides) ? $cardItem->slides : null;
    if (!empty($item->slides)) {
        $slides = $item->slides;
    } elseif ($item->item_id !== 0 && !empty($cardItem->slides)) {
        $slides = $cardItem->slides;
    } else {
        $slides = null;
    }
    $itemComission = $cardItem->percent_commission;
    $building = 'office';
}
$date =Yii::$app->formatter->asDate($cardItem->updated_at, 'php:d mm');
if (!empty($itemSubway)) {
    switch ($itemSubway->subwayDetails->branch_id) {
        case 1:
            $subwayIco = '<i class="card red_metro"></i>';
            break;
        case 2:
            $subwayIco = '<i class="card green_metro"></i>';
            break;
        case 3:
            $subwayIco = '<i class="card blue_metro"></i>';
            break;
        default:
            $subwayIco = '<i class="card metro"></i>';
    }

    $subway = $subwayIco . $itemSubway->subwayDetails->name . ' <span class="about">~</span> ' . $itemSubway->walk_distance . ' м';

} else {
    $subway = '';
}
?>

<div class="object_card" data-id="<?= $id ?>">
    <div class="border_wrapp">
        <div class="inner_wrapp">
            <div class="object_slider_wrapp">
                <div class="object_slider_header">
                    <? if (!Yii::$app->user->isGuest) : ?>
                        <div class="p_info red_p">
                            <p><?= Yii::t('app', 'Commission') . ': ' . $itemComission ?>%</p>
                        </div>
                    <? endif; ?>
                    <div class="inline">
                        <div class="black_circle_2">
                            <?= WishlistButton::widget([
                                'model' => $modelWishlist,
                                'anchorActive' => '<i class="star_icon_2 rem"></i>',
                                'anchorUnactive' => '<i class="star_icon_2"></i>',
                                'cssClass' => 'card out-wish',
                                'cssClassInList' => 'in-wish',
                                'building' => $building
                            ]); ?>
                        </div>
                    </div>
                </div>
                <div class="object_slider">
                    <? if (!empty($slides)) : ?>
                        <? foreach ($slides as $slide): ?>
                            <div class="slide">
                                <div class="img_box" data-imageurl="<?= $slide['thumb'] ?>"><img src="#" alt=""/></div>
                            </div>
                        <? endforeach; ?>

                    <? endif; ?>
                </div>
                <p class="object_card_date"><?= $date ?></p>
            </div>
            <div class="object_thumb_descript">
                <div class="object_card_title_wrapp">
                    <?= Html::a($itemName, [$href], ['class' => 'object_card_title', 'target' => '_blank']) ?>
                </div>
                <div class="card_descript_inner">
                    <div class="id_row">
                        <p><?= $itemClass ?> <span class="sl"></span> ID: <?= $id ?></p>
                    </div>
                    <div class="two_cols_2">
                        <div class="two_cols_2_col">
                            <div class="adres">
                                <h4><?= $address ?></h4>
                                <p><?= $city ?>, <?= $district ?></p>
                            </div>
                            <div class="metro_wrapp">
                                <p><?= $subway ?></p>
                            </div>
                        </div>
                        <? if ($result == 'bc') : ?>
                        <div class="two_cols_2_col">
                            <div class="office_cont_wrapp">
                                <div class="office_cont">
                                    <div class="col">
                                        <i class="room_2"></i>
                                    </div>
                                    <div class="col">
                                        <h5><?= $countItemPlaces ?></h5>
                                    </div>
                                </div>
                                <p>офисов</p>
                            </div>
                        </div>
                        <? endif; ?>
                    </div>
                </div>

                <div class="thumb_5_footer">
                    <? if ($result == 'offices') : ?>
                        <div class="thumb_5_footer_col">
                            <p><?= Yii::t('app', 'Square') ?>: <?= $minmax ?></p>
                        </div>
                        <div class="thumb_5_footer_col">
                            <p><?= Yii::t('app', 'Price') ?>: <?= $minPrice ?></p>
                        </div>
                    <? endif; ?>
                    <? if ($result == 'bc') : ?>
                            <div class="thumb_5_footer_inner">
                                <p><?= Yii::t('app', 'Square') ?>: <?= $squareInfo ?></p>
                            </div>
                    <? endif; ?>
                </div>

            </div>
        </div>
        <? if ($result == 'bc') : ?>
            <div class="hover_box">
                <div class="object_table">
                    <div class="table_row table_header">
                        <div class="table_cell">
                            <p>м²</p>
                        </div>
                        <div class="table_cell">
                            <p><?= $target == 1 ? getCurrencyText($currency)[0] : getCurrencySellText($currency)[0] ?></p>
                        </div>
                        <div class="table_cell">
                            <p><?= $target == 1 ? 'all in/мес' : 'all in' ?></p>
                        </div>
                        <div class="table_cell">
                        </div>
                    </div>
                    <? if ($itemPlaces): ?>
                        <? foreach ($itemPlaces as $k => $place): ?>
                            <?
                            $prices = getPlacePrice($place, $currency, $rates, $taxes, $target);
                            ?>
                            <div class="table_row">
                                <div class="table_cell">
                                    <? $squ = $place->m2min ? $place->m2min . '-' . $place->m2 : $place->m2 ?>
                                    <p><?= $squ ?></p>
                                </div>
                                <div class="table_cell">
                                    <p><?= $prices['forM2'] ?></p>
                                </div>
                                <div class="table_cell">
                                    <p><?= $prices['forAll'] ?></p>
                                </div>
                                <div class="table_cell">
                                    <? //debug($place->place->images) ?>
                                    <? if (isset($place->place->images) && count($place->place->images) > 0) : ?>

                                        <a href="#" class="icon_link_2" data-photogallerylink="<?= $place->pid ?>">
                                            <i class="photo"></i>
                                        </a>
                                        <div class="images_paths_array" data-photogalleryindex="<?= $place->pid ?>">
                                            <? foreach ($place->place->images as $img) : ?>
                                                <span data-imagepath="<?= $img->imgSrc ?>"></span>
                                            <? endforeach; ?>
                                        </div>
                                    <? endif; ?>
                                    <div class="star_place">
                                        <?= WishlistButton::widget([
                                            'model' => $place->place,
                                            'anchorActive' => '<i class="star_icon_2 rem"></i>',
                                            'anchorUnactive' => '<i class="star_icon_2"></i>',
                                            'cssClass' => 'out-wish',
                                            'cssClassInList' => 'in-wish'
                                        ]); ?>
                                    </div>
                                </div>
                            </div>
                        <? endforeach; ?>
                    <? endif; ?>
                </div>
            </div>
        <? endif; ?>
    </div>
</div>
