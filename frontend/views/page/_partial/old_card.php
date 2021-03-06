<?php
use yii\helpers\Html;
use kriptograf\wishlist\widgets\WishlistButton;

$paramTarget = $target == 1 ? 'rent' : 'sell';
//$href = Url::to(['page/bc_item', 'slug' => $item->slug->slug, 'target' => $paramTarget]);
$href = '/' . $item->slug->slug . '?target=' . $paramTarget;
$itemName = getDefaultTranslate('name', $currentLanguage, $item);
if ($result == 'bc') {
    $city = $item->city->name;
    $district = $item->district ? $item->district->name . ' р-н' : '';
    $address = $item->address;
    $minmax = $item->minm2 != $item->maxm2 ? Yii::t('app', 'from') . ' ' . $item->minm2 . ' m² ...' . $item->maxm2 . ' m²' : $item->minm2 . ' m²';
    $minPrice = $item->minprice != 'z' ? Yii::t('app', 'from') . ' ' . $item->minprice . '++ ₴/m<sup>2</sup>/мес' : Yii::t('app', 'price con.');
    $itemPlaces = $item->getFilteredPlaces($places, $target);
    $placesInfo = $item->getPlacesInfo($itemPlaces);
    $itemSubway = !empty($item->subways[0]) ? $item->subways[0] : null;
    $itemClass = $item->class->name;
    $slides = !empty($item->slides) ? $item->slides : null;
    $itemComission = $item->percent_commission;
    $building = 'bc';
} else {
    //debug($item->slug->slug);
    //$href = '';
    if ($item->no_bc === 1) {
        $office = $item->bcitem;
    } else {
        $office = $item->bcitem;
    }
    $city = $office->city->name;
    $district = $office->district ? $office->district->name . ' р-н' : '';
    $address = $office->street;
    $minmax = !empty($item->m2minm2) ? Yii::t('app', 'from') . ' ' . $item->m2min . ' m² ...' . $item->m2 . ' m²' : $item->m2 . ' m²';
    //if(!empty($item->priceSqm->price)) debug($item->priceSqm->price);
    $minPrice = ($item->con_price != 1 && !empty($item->priceSqm->price)) ? Yii::t('app', 'from') . ' ' . $item->priceSqm->price . '++ ₴/m<sup>2</sup>/мес' : Yii::t('app', 'price con.');
    $itemPlaces = null;
    $placesInfo = null;
    $itemSubway = !empty($office->subways[0]) ? $office->subways[0] : null;
    $itemClass = $office->class->name;
    $slides = !empty($office->slides) ? $office->slides : null;
    if (!empty($item->slides)) {
        $slides = $item->slides;
    } elseif ($item->item_id !== 0 && !empty($office->slides)) {
        $slides = $office->slides;
    } else {
        $slides = null;
    }
    $itemComission = $office->percent_commission;
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

<div class="object_card" data-id="<?= $item->id ?>">
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
                                'model' => $item,
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
                                <a href="<?= $slide['big'] ?>" class="img_box" data-fancybox="card_1<?= $item->id ?>"
                                   data-imageurl="<?= $slide['thumb'] ?>"><img src="#" alt=""/></a>
                            </div>
                        <? endforeach; ?>
                    <? endif; ?>
                </div>
            </div>
            <div class="object_thumb_descript">
                <?= Html::a($itemName, [$href], ['class' => 'object_card_title', 'target' => '_blank']) ?>
                <div class="inline">
                    <div class="cl_pill_class">
                        <span class="item-type">Тип: </span>
                        <span class="item-type-name">Бизнес центр </span>
                        <span class="item-class"><?= $itemClass ?></span>
                        <span class="item-id">ID: <?= $item->id ?></span>
                    </div>
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
                        <div class="free_office">
                            <a href="<?= $href ?>"
                               class="green_pill"><?= Yii::t('app', 'Offices') . ': ' . count($itemPlaces) . ' - ' . $minPrice ?>
                            </a>
                        </div>
                    <? endif; ?>
                    <? if ($result == 'offices') : ?>
                        <div class="thumb_5_footer_col">
                            <p><?= $minmax ?></p>
                        </div>
                        <div class="thumb_5_footer_col">
                            <p><?= $minPrice ?>
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
                            <p>₴/м²</p>
                        </div>
                        <div class="table_cell">
                            <p>all in/мес</p>
                        </div>
                        <div class="table_cell">
                        </div>
                    </div>
                    <? if ($placesInfo): ?>
                        <? foreach ($placesInfo as $k => $place): ?>
                            <? //debug($place);
                            $pluses = '';
                            if (isset($place['for_m2']) && isset($place['all_for_m2']) && $place['for_m2'] < $place['all_for_m2']) $pluses = '<span class="pluses">++</span>';
                            ?>
                            <div class="table_row">
                                <div class="table_cell">
                                    <p><?= $place['m2'] ?></p>
                                </div>
                                <div class="table_cell">
                                    <p><?= $place['for_m2'] . $pluses ?></p>
                                </div>
                                <div class="table_cell">
                                    <p><?= $place['for_all'] ?></p>
                                </div>
                                <div class="table_cell">
                                    <? if (isset($place['img']) && count($place['img']) > 0) : ?>

                                        <a href="#" class="icon_link_2" data-photogallerylink="<?= $k ?>"><i
                                                class="photo"></i></a>
                                        <div class="images_paths_array" data-photogalleryindex="<?= $k ?>">
                                            <? foreach ($place['img'] as $img) : ?>
                                                <span data-imagepath="<?= $img ?>"></span>
                                            <? endforeach; ?>
                                        </div>
                                    <? endif; ?>
                                    <div class="star_place">
                                        <?= WishlistButton::widget([
                                            'model' => $place['model'],
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
