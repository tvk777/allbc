<?php
use yii\helpers\Html;
use kriptograf\wishlist\widgets\WishlistButton;
$paramTarget = $target == 1 ? 'rent' : 'sell';

$id = $item->id;
$itemComission = $item->bcitem->percent_commission;
$building = 'office';
$slides = !empty($item->slides) ? $item->slides : null;
if (!empty($item->slides)) {
    $slides = $item->slides;
} elseif ($item->item_id !== 0 && !empty($item->bcitem->slides)) {
    $slides = $item->bcitem->slides;
} else {
    $slides = null;
}
$itemName = getDefaultTranslate('name', $currentLanguage, $item, true);
$href = '/' . $item->slug->slug . '?target=' . $paramTarget;
$city = $item->bcitem->city->name;
$district = $item->bcitem->district ? $item->bcitem->district->name . ' р-н' : '';
$address = $item->hide_bc == 1 ? $item->bcitem->street : $item->bcitem->address;
$minmax = !empty($item->m2min) ? $item->m2min . ' m² - ' . $item->m2 . ' m²' : $item->m2 . ' m²';
$placePrice = getPlaceUahPrice($item, $currency, $rates, $target);
debug($placePrice);
$minPrice = $placePrice;
$itemSubway = !empty($item->bcitem->subways[0]) ? $item->bcitem->subways[0] : null;
$itemClass = getDefaultTranslate('name', $currentLanguage, $item->bcitem->class, true);

$date =Yii::$app->formatter->asDate($item->bcitem->updated_at, 'php:d.m');

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

<div class="object_card">
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
                    </div>
                </div>
                <div class="thumb_5_footer">
                    <div class="thumb_5_footer_col">
                        <p><?= Yii::t('app', 'Square') ?>: <?= $minmax ?></p>
                    </div>
                    <div class="thumb_5_footer_col">
                        <p><?= Yii::t('app', 'Price') ?>: <?= $minPrice ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

