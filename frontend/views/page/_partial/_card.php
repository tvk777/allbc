<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;

//debug($item->city);
$paramTarget = $target==1 ? 'rent' : 'sell';
//$href = Url::to(['page/bc_item', 'slug' => $item->slug->slug, 'target' => $paramTarget]);
if($result=='bc') {
    $href = '/' . $item->slug->slug . '?target=' . $paramTarget;
    $city = $item->city->name;
    $district = $item->district ? $item->district->name . ' р-н' : '';
    $street = $item->street;
    $minmax = $item->minm2 != $item->maxm2 ? Yii::t('app', 'from') . ' ' . $item->minm2 . ' m² ...' . $item->maxm2 . ' m²' : $item->minm2 . ' m²';
    $minPrice = $item->minprice != 'z' ? Yii::t('app', 'from') . ' ' . $item->minprice . ' ₴/m<sup>2</sup>' : Yii::t('app', 'price con.');
    $itemPlaces = $item->getFilteredPlaces($places, $target);
    $placesInfo = $item->getPlacesInfo($itemPlaces);
    $itemSubway = !empty($item->subways[0]) ? $item->subways[0] : null;
    $itemClass = $item->class->name;
    $slides = !empty($item->slides) ? $item->slides : null;
    $itemComission = $item->percent_commission;
} else {
    $href = '';
    $city = $item->bcitem->city->name;
    $district = $item->bcitem->district ? $item->bcitem->district->name . ' р-н' : '';
    $street = $item->bcitem->street;
    $minmax = !empty($item->m2minm2) ? Yii::t('app', 'from') . ' ' . $item->m2min . ' m² ...' . $item->m2 . ' m²' : $item->m2 . ' m²';
    $minPrice = $item->con_price != 1 ? Yii::t('app', 'from') . ' ' . $item->priceSqm->price . ' ₴/m<sup>2</sup>' : Yii::t('app', 'price con.');
    $itemPlaces = null;
    $placesInfo = null;
    $itemSubway = !empty($item->bcitem->subways[0]) ? $item->bcitem->subways[0] : null;
    $itemClass = $item->bcitem->class->name;
    $slides = !empty($item->bcitem->slides) ? $item->bcitem->slides : null;
    if(!empty($item->slides)){
        $slides = $item->slides;
    } elseif ($item->item_id!==0 && !empty($item->bcitem->slides)) {
        $slides = $item->bcitem->slides;
    } else {
        $slides = null;
    }
    $itemComission = $item->bcitem->percent_commission;
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
                    <div class="inline">
                        <div class="cl_pill">
                            <p><?= $itemClass ?></p>
                        </div>
                    </div>
                    <div class="inline">
                        <div class="black_circle_2">
                            <i class="star_icon_2"></i>
                        </div>
                    </div>
                </div>
                <div class="object_slider">
                    <? if (!empty($slides)) : ?>
                        <? foreach ($slides as $slide): ?>
                            <div class="slide">
                                <a href="<?= $slide['big'] ?>" class="img_box" data-fancybox="card_1"
                                   data-imageurl="<?= $slide['thumb'] ?>"><img src="#" alt=""/></a>
                            </div>
                        <? endforeach; ?>
                    <? endif; ?>
                </div>
            </div>
            <div class="object_thumb_descript">
                <div class="p_info red_p">
                    <p><?= Yii::t('app', 'Commission') . ': ' . $itemComission ?> %</p>
                </div>
                <?= Html::a($item->name, [$href], ['class' => 'object_card_title', 'target' => '_blank']) ?>
                <div class="two_cols_2">
                    <div class="two_cols_2_col">
                        <div class="adres">
                            <h5>г. <?= $city ?>, <?= $district ?></h5>
                            <p><?= $street ?></p>
                        </div>
                        <div class="metro_wrapp">
                            <p><?= $subway ?></p>
                        </div>
                    </div>
                    <? if($result=='bc') :?>
                    <div class="two_cols_2_col">
                        <div class="office_cont_wrapp">
                            <div class="office_cont">
                                <div class="col">
                                    <i class="room_2"></i>
                                </div>
                                <div class="col">
                                    <h5><?= count($itemPlaces) ?></h5>
                                </div>
                            </div>
                            <p><?= Yii::t('app', 'offices') ?></p>
                        </div>
                    </div>
                    <? endif; ?>
                </div>
                <div class="thumb_5_footer">
                    <div class="thumb_5_footer_col">
                        <p><?= $minmax ?></p>
                    </div>
                    <div class="thumb_5_footer_col">
                        <p><?= $minPrice ?>
                    </div>
                </div>
            </div>
        </div>
        <? if($result=='bc') :?>
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
                        <? $pluses = '';
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
                                <a href="#" class="icon_link_2"><i class="star_2"></i></a>
                            </div>
                        </div>
                    <? endforeach; ?>
                <? endif; ?>
            </div>
        </div>
        <? endif; ?>
    </div>
</div>
