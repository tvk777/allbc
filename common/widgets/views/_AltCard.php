<?php
use yii\helpers\Url;
use yii\helpers\Html;
$paramTarget = $target==1 ? 'rent' : 'sell';
$href = '/'.$item->slug->slug.'?target='.$paramTarget;
$city = $item->city->name;
$district = $item->district ? $item->district->name . ' р-н' : '';
$street = $item->street;
$itemPlaces = $item->getFilteredPlaces($places, $target);
$minmax = $item->getMinMaxM2($itemPlaces);
$minmax = is_array($minmax) ? Yii::t('app', 'from') . ' ' . $minmax['min'] . ' m² ...' . $minmax['max'] . ' m²' : $minmax . ' m²';
$minPrice = $item->getMinPrice($itemPlaces)['price'];
$minPrice = $minPrice ? Yii::t('app', 'from') . ' ' . $minPrice . ' ₴/m<sup>2</sup>' : Yii::t('app', 'price con.');
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
    </div>
</div>
