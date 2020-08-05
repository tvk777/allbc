<?php
use yii\helpers\Url;
use yii\helpers\Html;
use kriptograf\wishlist\widgets\WishlistButton;
$currentLanguage = Yii::$app->language;

$currency = 1;

//debug($item->slug);
$paramTarget = $target == 1 ? 'rent' : 'sell';
$slug = !empty($item->slug) ? $item->slug->slug : '';
$href = '/'. $slug . '?target=' . $paramTarget;
$city = $item->city->name;
$district = $item->district ? $item->district->name . ' р-н' : '';
$address = $item->address;
$itemPlaces = $item->getFilteredPlaces($places, $target);

$minmax = $item->getMinMaxM2($itemPlaces);
$minmax = is_array($minmax) && count($minmax)===2 ? $minmax['min'] . '-' . $minmax['max'] . 'м²' : $minmax . 'м²';
debug($minmax);
$minPrice = $item->getMinPrice($itemPlaces)['price'].getCurrencyText($currency);
$minPrice = $minPrice ? $minPrice : Yii::t('app', 'price con.');

$countItemPlaces = count($itemPlaces);
if ($countItemPlaces > 1) {
    $priceInfo = Yii::t('app', 'from') . ' ' . $minPrice;
    $squareInfo = $countItemPlaces . ' - '. $minmax;
} elseif ($countItemPlaces==1) {
    $priceInfo = $minPrice;
    $squareInfo = $minmax;
}


$placesInfo = $item->getPlacesInfo($itemPlaces);

$slides = !empty($item->slides) ? $item->slides : null;
$itemClass = getDefaultTranslate('name', $currentLanguage, $item->class, true);
$itemSubway = !empty($item->subways[0]) ? $item->subways[0] : null;




if (isset($itemSubway)) {
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

<div class="object_card">
    <div class="border_wrapp">
        <div class="inner_wrapp">
            <div class="object_slider_wrapp">
                <div class="object_slider_header">
                    <? if (!Yii::$app->user->isGuest) : ?>
                        <div class="inline p_info blue_p">
                            <span
                                class="blue_span"><?= Yii::t('app', 'Commission') . ': </span><span class="red_span">' . $item->percent_commission ?>
                                %</span>
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
                                'building' => 'bc'
                            ]); ?>
                        </div>
                    </div>

                </div>
                <div class="object_slider">
                    <? if (!empty($slides)) : ?>
                        <? foreach ($slides as $slide): ?>
                            <div class="slide">
                                <a href="<?= $slide['big'] ?>" class="img_box"
                                   data-fancybox="card_1<?= $item->id ?>"
                                   data-imageurl="<?= $slide['thumb'] ?>"><img src="#" alt=""/></a>
                            </div>
                        <? endforeach; ?>
                    <? endif; ?>
                </div>
            </div>
            <div class="object_thumb_descript">
                <?= Html::a($item->name, [$href], ['class' => 'object_card_title', 'target' => '_blank']) ?>
                <div class="cl_pill_class">
                    <span class="item-type">
                        <span class="item-class"><?= $itemClass ?></span>
                    </span>
                    <span class="item-id">ID: <?= $item->id ?></span>
                </div>
                <div class="card-address">
                    <div class="adres">
                        <p><?= $address ?></p>
                        <h5><?= $district ?>, г. <?= $city ?></h5>
                    </div>
                    <div class="metro_wrapp">
                        <p><?= $subway ?></p>
                    </div>
                </div>

                <div class="thumb_5_footer">
                    <div class="free_office">
                        <a href="<?= $href ?>"
                           class="scroll_to green_pill tel_pill tel_hide_pill"><?= Yii::t('app', 'Free Offices') . ': ' . count($itemPlaces) . ' - ' . $minPrice ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
