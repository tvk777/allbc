<?php
use yii\helpers\Html;
use kriptograf\wishlist\widgets\WishlistButton;

$paramTarget = $target == 1 ? 'rent' : 'sell';
//$href = Url::to(['page/bc_item', 'slug' => $item->slug->slug, 'target' => $paramTarget]);
//$href = '/' . $item->slug->slug . '?target=' . $paramTarget;
//$itemName = getDefaultTranslate('name', $currentLanguage, $item);
//echo 'text='.getCurrencyText ($currency);
if ($result == 'bc') {
    $cardItem = $item['bc'];
    $id = $cardItem->id;
    $modelWishlist = $cardItem->bcitem;
    $href = '/' . $cardItem->bcitem->slug->slug . '?target=' . $paramTarget;
    $itemName = getDefaultTranslate('name', $currentLanguage, $cardItem->bcitem, true);
    $city = $cardItem->bcitem->city->name;
    $district = $cardItem->bcitem->district ? $cardItem->bcitem->district->name . ' р-н' : '';
    $address = $cardItem->bcitem->address;
    $plus = getPlusForBC($item['places']) ? '++' : '';
    $minPrice = getBcMinPrice($item, $currency, $rate);
    //$minPrices = getBcMinPrices($item, $currency, $rate);
    //$minPrice = $type == 1 ? getBcMinPrice($item, $currency, $rate) : getBcMinPriceAll($item, $currency, $rate);
    $itemPlaces = $item['places'];
    $itemSubway = !empty($cardItem->bcitem->subways[0]) ? $cardItem->bcitem->subways[0] : null;
    $itemClass = $cardItem->bcitem->class->name;
    $slides = !empty($cardItem->bcitem->slides) ? $cardItem->bcitem->slides : null;
    $itemComission = $cardItem->bcitem->percent_commission;
    $building = 'bc';
    /*debug($minPrices);
    [forM2] => 3500 ₴/м²/міс $/м²/міс
    [forAll] => 315000 ₴/міс
    filter[type] = 1 || 3
    */
} else {
    $cardItem = $item->place->bcitem; //bc
    $placeItem = $item->place; //place
    $id = $placeItem->id;
    //debug($item); die();
    $itemPlaces = null;
    $modelWishlist = $placeItem;
    $itemName = getDefaultTranslate('name', $currentLanguage, $placeItem, true);
    $href = '/' . $placeItem->slug->slug . '?target=' . $paramTarget;
    $city = $cardItem->city->name;
    $district = $cardItem->district ? $cardItem->district->name . ' р-н' : '';
    $address = $cardItem->street;
    $minmax = !empty($placeItem->m2min) ? $item->m2min . ' m² - ' . $item->m2 . ' m²' : $item->m2 . ' m²';
    $placePrices = getPlacePrices($item, $currency, $rate);
    $minPrice = $placePrices['forM2'];
    $itemPlaces = null;
    $placesInfo = null;
    $itemSubway = !empty($cardItem->subways[0]) ? $cardItem->subways[0] : null;
    $itemClass = $cardItem->class->name;
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

if (!empty($itemSubway)) {
    switch ($itemSubway->subwayDetails->branch_id) {
        case 1:
            $subwayIco = '<i class="red_metro"></i>';
            break;
        case 2:
            $subwayIco = '<i class="green_metro"></i>';
            break;
        case 3:
            $subwayIco = '<i class="blue_metro"></i>';
            break;
        default:
            $subwayIco = '<i class="metro"></i>';
    }

    $subway = $subwayIco . $itemSubway->subwayDetails->name . ' <span class="about">~</span> ' . $itemSubway->walk_distance . ' м';

} else {
    $subway = '';
}
?>

<div class="object_card" data-id="<?= $cardItem->id ?>">
    <div class="border_wrapp">
        <div class="inner_wrapp">
            <div class="object_slider_wrapp">
                <div class="object_slider_header">
                    <div class="inline p_info red_p">
                        <p><?= Yii::t('app', 'Commission') . ': ' . $itemComission ?> %</p>
                    </div>

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
                                <a href="<?= $slide['big'] ?>" class="img_box"
                                   data-fancybox="card_1<?= $cardItem->id ?>"
                                   data-imageurl="<?= $slide['thumb'] ?>"><img src="#" alt=""/></a>
                            </div>
                        <? endforeach; ?>
                    <? endif; ?>
                </div>
            </div>
            <div class="object_thumb_descript">
                <?= Html::a($itemName, [$href], ['class' => 'object_card_title', 'target' => '_blank']) ?>

                <div class="cl_pill_class">
                    <span class="item-type">
                        <span class="item-type-name">Бизнес центр </span>
                        <span class="item-class"><?= $itemClass ?></span>
                    </span>
                    <span class="item-id">ID: <?= $id ?></span>
                </div>
                <div class="card-address">
                    <div class="adres">
                        <h5><?= $district ?>, г. <?= $city ?></h5>
                        <p>(<?= $address ?>)</p>
                    </div>
                    <div class="metro_wrapp">
                        <p><?= $subway ?></p>
                    </div>
                </div>
                <div class="thumb_5_footer">

                    <? if ($result == 'bc') : ?>
                        <div class="offices-info">
                            <p><span><?= Yii::t('app', 'Rent') ?>:</span> <?= Yii::t('app', 'from') . ' ' . $minPrice ?>
                            </p>
                            <p><span><?= Yii::t('app', 'Offices') ?>
                                    :</span> <?= count($itemPlaces) . ' - ' . Yii::t('app', 'from') . ' ' . $cardItem->minM2 . 'м²' ?>
                            </p>
                        </div>
                    <? endif; ?>
                    <? if ($result == 'offices') : ?>
                        <div class="offices-info">
                            <p><span><?= Yii::t('app', 'Rent') ?>:</span> <?= $minPrice ?></p>
                            <p><span><?= Yii::t('app', 'Square') ?>:</span> <?= $minmax ?></p>
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
                            <p><?= getCurrencyText($currency)[0] ?></p>
                        </div>
                        <div class="table_cell">
                            <p>all in/мес</p>
                        </div>
                        <div class="table_cell">
                        </div>
                    </div>
                    <? if ($itemPlaces): ?>
                        <? foreach ($itemPlaces as $k => $place): ?>
                            <?
                            $prices = getPlacePrice($place, $rate);
                            ?>
                            <div class="table_row">
                                <div class="table_cell">
                                    <p><?= $place->m2 ?></p>
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
