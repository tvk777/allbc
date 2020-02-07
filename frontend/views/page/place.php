<?php
$currentLanguage = Yii::$app->language;
//debug($model->characteristics);
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;

$city_url = $target == 2 ? $mainSell : $mainRent;
$city_id = 0;
$zoom = 13;

if (isset($item->city)) {
    $zoom = $item->city->zoom;
    $city_id = $item->city->id;
    $rentLable = Yii::t('app', 'Office rental in') . ' ' . getLangInflect($item->city, $currentLanguage);
    $sellLable = Yii::t('app', 'Office for sale in') . ' ' . getLangInflect($item->city, $currentLanguage);
    $city_url = $target == 2 ? $item->city->slug_sell . '?filter[result]=offices' : $item->city->slug . '?filter[result]=offices';
    $this->params['breadcrumbs'][] = [
        'label' => $target == 2 ? $sellLable : $rentLable,
        'url' => $city_url
    ];
}
if ($seoClass) {
    $this->params['breadcrumbs'][] = [
        'label' => $seoClass->name,
        'url' => $seoClass->slug->slug . '?filter[result]=offices'
    ];
}
$district = '';
$district_filter_href = $city_url;
if ($item->district) {
    $district = ', ' . $item->district->name . ' р-н';
    $district_filter_href .= '?filter[districts][]=' . $item->district->id . '&filter[result]=offices';
}

$comission = $item->percent_commission == 0 ? '<span class="red">' . Yii::t('app', 'no commission') . ' </span>' : '<span class="red"> ' . Yii::t('app', 'commission') . ' ' . $item->percent_commission . '%</span>';

$objectTitle = getDefaultTranslate('name', $currentLanguage, $model);
$firstImage = isset($model->images[0]) ? $model->images[0]->imgSrc : '';
$class = $item->class->short_name;



$this->title = getDefaultTranslate('title', $currentLanguage, $model);
$this->params['breadcrumbs'][] = $objectTitle;
$share_img_url = '';
$cityName = getDefaultTranslate('name', $currentLanguage, $item->city, true);

if($model->no_bc!==1){
    $itemName = getDefaultTranslate('name', $currentLanguage, $item);
    $targetLink = $target == 2 ? '?target=sell' : '?target=rent';
    $itemHref = $item->slug->slug.$targetLink;
    $itemHtml = '<p><a href="/'.$itemHref.'">'.$itemName.'</a></p>';
} else{
    $itemHtml = '';
}
$itemName = $model->no_bc==1 ? $objectTitle : getDefaultTranslate('name', $currentLanguage, $item);

$addres = $item->street;
$coord = [$item->lng, $item->lat];
$marker = [
    'coordinates' => $coord,
    'zoom' => $zoom
];
$this->registerJsVar('marker', $marker, $this::POS_HEAD);


//debug($item);
$plus = '';
$placePrices = $model->prices;
$prices = count($placePrices) > 0 ? $model->getPricePeriod($placePrices) : Yii::t('app', 'con.');
if (count($placePrices) > 0) {
    $uah = $prices['uah']['m2'];
    if($target == 1) {
        $m2_uah = $prices['uah']['m2_2'];
        if ($uah < $m2_uah) $plus = ' ++';
        $price = Yii::t('app', 'Price').': '.$uah.' '.Yii::t('app', '&#8372;/m²/month').$plus;
    } else {
        $value = $prices['uah']['value'];
        $full = $prices['uah']['full'];
        if ($value < $full) $plus = ' ++';
        $price = Yii::t('app', 'Price').': '.$uah.' '.Yii::t('app', '&#8372;/m²').$plus;
    }
} else {
    $price = Yii::t('app', 'con.');
}

?>

<section class="grey_bg">
    <?= $addres ?>
    <div class="row row_2">
        <div class="breadcrumbs_wrapp">
            <?= Breadcrumbs::widget([
                'itemTemplate' => "<li>{link}</li>\n",
                'homeLink' => [
                    'label' => Yii::t('app', 'Home'),
                    'url' => Yii::$app->homeUrl,
                ],
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                'options' => ['class' => 'breadcrumbs'],
            ]);
            ?>
        </div>

        <div class="object_center_templ clearfix">
            <div class="right">
                <div class="object_slider_wrapp">
                    <button type="button" class="scale_btn" data-slider-btn="object_slider_big"><img
                            src="/img/search_white.svg" alt=""/></button>
                    <div class="object_slider_big">
                        <? if ($model->images) : ?>
                            <? foreach ($model->images as $img) : ?>
                                <div class="slide">
                                    <a href="<?= $img->imgSrc ?>" class="img_box"
                                       style="background-image: url(<?= $img->imgSrc ?>);"
                                       data-fancybox="object_sl"></a>
                                </div>
                            <? endforeach; ?>
                        <? endif; ?>
                    </div>
                    <div class="object_slider_miniatures">
                        <? if ($model->images) : ?>
                            <? $share_img_url = $model->images[0]->imgSrc; ?>
                            <? foreach ($model->images as $img) : ?>
                                <div class="slide">
                                    <div class="img_box">
                                        <img src="<?= $img->imgSrc ?>" alt=""/>
                                    </div>
                                </div>
                            <? endforeach; ?>
                        <? endif; ?>

                    </div>
                </div>
                <div class="slides_info">
                    <?php
                    $created = !empty($model->created_at) ? Yii::$app->formatter->asDate($model->created_at, 'dd.MM.yyyy') :
                        Yii::$app->formatter->asDate($model->updated_at, 'dd.MM.yyyy');
                    $updated = Yii::$app->formatter->asDate($model->updated_at, 'dd.MM.yyyy');
                    ?>
                    <div class="col">
                        <p><?= Yii::t('app', 'Posted') ?>: <?= $created ?></p>
                    </div>
                    <div class="col">
                        <p><?= Yii::t('app', 'Updated') ?>: <?= $updated ?></p>
                    </div>
                    <div class="col">
                        <p><?= Yii::t('app', 'Views') ?>: <?= $model->countView->count_view ?></p>
                    </div>
                </div>

            </div>
            <div class="left">
                <div class="object_info">
                    <div class="inner">
                        <div class="object_title">
                            <div class="h3_wrapp">
                                <h3><?= $objectTitle; ?></h3>
                                <div class="star_checkbox like_star">
                                    <input type="checkbox" name="star_1" id="star_title">
                                    <label for="star_title"></label>
                                </div>
                            </div>
                            <div class="title_desc">
                                <div class="col">
                                    <p>Тип:</p>
                                </div>
                                <div class="col">
                                    <p><a href="<?= $city_url . '?filter[classes][]=' . $item->class->id ?>"
                                          class="green_link_3"><?= Yii::t('app', 'Business center') . ' ' . getDefaultTranslate('name', $currentLanguage, $item->class, true) ?> </a>
                                    </p>
                                </div>
                                <div class="col">
                                    <p>ID: <?= $model->id ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                        <div class="inner">
                            <div class="office_info">
                                <p><b><?= Yii::t('app', 'Office area').': '. $model->m2range ?> м²</b></p>
                                <p><b><?= $price ?></b></p>
                                <?= $itemHtml ?>
                            </div>
                        </div>

                    <div class="inner">
                        <div class="two_cols_2 two_cols_2_2">
                            <div class="two_cols_2_col">
                                <div class="adres">
                                    <h5>
                                        <a target="_blank"
                                           href="<?= $district_filter_href ?>"><?= $cityName . $district ?></a>
                                    </h5>
                                    <? if ($model->street) : ?>
                                        <p><?= $model->street ?></p>
                                    <? endif; ?>
                                </div>
                                <? if (count($item->subways) > 0) : ?>
                                    <? foreach ($item->subways as $sub) : ?>
                                        <? switch ($sub->subwayDetails->branch_id) {
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

                                        $subway = $subwayIco . '<a target="_blank" href="' . $city_url . '&filter[subway]=' . $sub->subway_id . '">' . $sub->subwayDetails->name . '</a> <span class="about">~</span> ' . $sub->walk_distance . ' м'; ?>
                                        <div class="metro_wrapp">
                                            <p><?= $subway; ?></p>
                                        </div>
                                    <? endforeach ?>
                                <? endif; ?>
                            </div>
                            <div class="two_cols_2_col">
                                <p class="map_link"><i class="map"></i><a href="#" class="dashed_link showOnmap">на карте</a></p>
                            </div>
                        </div>
                    </div>
                    <? if (count($item->owners) > 0) : ?>
                        <? foreach ($item->owners as $user) : ?>
                            <?= $this->render('_partial/_user-info', [
                                'user' => $user,
                                'city_url' => $city_url,
                                'comission' => $comission,
                                'role' => 'Собственник'
                            ]); ?>
                        <? endforeach; ?>
                    <? endif; ?>
                    <? if (count($item->brokers) > 0) : ?>
                        <? foreach ($item->brokers as $user) : ?>
                            <?= $this->render('_partial/_user-info', [
                                'user' => $user,
                                'city_url' => $city_url,
                                'comission' => $comission,
                                'role' => 'Брокер'
                            ]); ?>
                        <? endforeach; ?>
                    <? endif; ?>
                    <div class="inner">
                        <div class="pills_wrapp">
                            <div class="col">
                                <a target="_blank"
                                   href="<?= Url::toRoute(['page/pdf', 'id' => $model->id, 'target' => $target]) ?>"
                                   class="grey_pill">Скачать.pdf</a>
                            </div>
                            <div class="col">
                                <a href="javascript:(print());" class="grey_pill">Распечатать</a>
                            </div>
                        </div>
                        <ul class="socials_list">
                            <? //echo yii\helpers\Url::current([], true); ?>
                            <?= \ymaker\social\share\widgets\SocialShare::widget([
                                'configurator' => 'socialShare',
                                'url' => yii\helpers\Url::current([], true),
                                'title' => $this->title,
                                'description' => 'Description of the page...',
                                'imageUrl' => \yii\helpers\Url::to($share_img_url, true),
                            ]); ?>
                            <!--<li><a href="#"><img src="img/pinterest_2.svg" alt=""/></a></li>
                            <li><a href="#"><img src="img/twitter_2.svg" alt=""/></a></li>
                            <li><a href="#"><img src="img/envelop_2.svg" alt=""/></a></li>
                            <li><a href="#"><img src="img/facebook_2.svg" alt=""/></a></li>
                            <li class="hide_soc"><a href="#"><img src="img/pinterest_2.svg" alt=""/></a></li>
                            <li class="hide_soc"><a href="#"><img src="img/twitter_2.svg" alt=""/></a></li>
                            <li class="hide_soc"><a href="#"><img src="img/envelop_2.svg" alt=""/></a></li>
                            <li class="hide_soc"><a href="#"><img src="img/facebook_2.svg" alt=""/></a></li>
                            <li class="slide_socials more_socials"><a href="#"><img src="/img/plus_2.svg" alt=""/></a>
                            </li>
                            <li class="slide_socials less_socials"><a href="#"><img src="/img/minus_btn.svg" alt=""/></a>
                            </li>-->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<? if (!empty($content = getDefaultTranslate('comment', $currentLanguage, $model))) : ?>
<section class="sect_7_2">
    <div class="row row_2">
            <h2><?= Yii::t('app', 'Description') ?></h2>
            <div class="text_box" id="slide_text" data-minheight="142">
                <div class="inner_height">
                    <?= $content ?>
                </div>
            </div>
            <div class="showmore_wrapp">
                <a href="#" class="green_link show_text" data-slidebox-id="slide_text">
                    <i class="plus"></i>
                    <span class="show"><?= Yii::t('app', 'Show more') ?></span>
                    <span class="hide"><?= Yii::t('app', 'Collapse') ?></span>
                </a>
            </div>
    </div>
</section>
<? endif; ?>





<section class="sect_7_bc">
    <div class="row">
        <?= \common\widgets\AltOffersWidget::widget(['item' => $item, 'target' => $target]) ?>
        <?= common\widgets\ServicesWidget::widget(); ?>
    </div>
</section>
<section class="sect_7_2_bc">
    <div class="row">
        <?= common\widgets\DistrictsStatWidget::widget(['target' => $target, 'city' => $city_id]); ?>
    </div>
</section>

<section class="sect_7_2_bc">
    <div id="item_map"></div>
</section>

<?
$this->registerCssFile('https://api.tiles.mapbox.com/mapbox-gl-js/v1.2.0/mapbox-gl.css');
$this->registerJsFile('https://api.tiles.mapbox.com/mapbox-gl-js/v1.2.0/mapbox-gl.js');
$this->registerJsFile('https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-language/v0.10.1/mapbox-gl-language.js');
$this->registerJsFile('/js/item-mapbox.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>

