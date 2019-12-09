<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;

//debug($item);
$paramTarget = $target==1 ? 'rent' : 'sell';
//$href = Url::to(['page/bc_item', 'slug' => $item->slug->slug, 'target' => $paramTarget]);
$href = '/'.$item->slug->slug.'?target='.$paramTarget;
$city = $item->city->name;
$district = $item->district ? $item->district->name . ' р-н' : '';
$street = $item->street;
$minmax = $item->minm2!=$item->maxm2 ? Yii::t('app', 'from') . ' ' . $item->minm2 . ' m² ...' . $item->maxm2 . ' m²' : $item->minm2 . ' m²';
$minPrice = $item->minprice!='z' ? Yii::t('app', 'from') . ' ' . $item->minprice . ' ₴/m<sup>2</sup>' : Yii::t('app', 'price con.');
$itemPlaces = $item->getFilteredPlaces($places, $target);
$placesInfo = $item->getPlacesInfo($itemPlaces);

if (isset($item->subways[0])) {
    switch ($item->subways[0]->subwayDetails->branch_id) {
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

    $subway = $subwayIco . $item->subways[0]->subwayDetails->name . ' <span class="about">~</span> ' . $item->subways[0]->walk_distance . ' м';

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
                            <p><?= $item->class->name ?></p>
                        </div>
                    </div>
                    <div class="inline">
                        <div class="black_circle_2">
                            <i class="star_icon_2"></i>
                        </div>
                    </div>
                </div>
                <div class="object_slider">
                    <? if ($item->slides) : ?>
                        <? foreach ($item->slides as $slide): ?>
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
                    <p><?= Yii::t('app', 'Commission') . ': ' . $item->percent_commission ?> %</p>
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
    </div>
</div>
