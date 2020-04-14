<?php
//echo 'fav='.\Yii::$app->wishlist->getUserWishlistAmount();
//debug(\Yii::$app->wishlist->getUserWishList());

$this->registerJsFile('/js/stupidtable.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

$currentLanguage = Yii::$app->language;
//debug($model->characteristics);
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kriptograf\wishlist\widgets\WishlistButton;

$this->registerJsFile('/js/jquery.mCustomScrollbar.concat.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('/css/jquery.mCustomScrollbar.css');


$places = $target == 2 ? $model->placesSell : $model->places;
$placesRent = $model->places;
$placesSell = $model->placesSell;
$placesRentArhive = $model->archivePlaces;
$placesSellArhive = $model->archivePlacesSell;

$city_url = $target == 2 ? $mainSell : $mainRent;
$city_url .='?filter[result]=bc';
$city_id = 0;
$zoom = 13;
//debug(count($model->district->items));

if (isset($model->city)) {
    $zoom = $model->city->zoom;
    $city_id = $model->city->id;
    $rentLable = Yii::t('app', 'Office rental in') . ' ' . getLangInflect($model->city, $currentLanguage);
    $sellLable = Yii::t('app', 'Office for sale in') . ' ' . getLangInflect($model->city, $currentLanguage);
    $city_url = $target == 2 ? $model->city->slug_sell : $model->city->slug;
    $city_url .='?filter[result]=bc';
    $this->params['breadcrumbs'][] = [
        'label' => $target == 2 ? $sellLable : $rentLable,
        'url' => $city_url
    ];
}

if ($city_id !== 0) {
    $sellHref = $model->city->slug_sell;
    $rentHref = $model->city->slug;
} else {
    $sellHref = $mainSell;
    $rentHref = $mainRent;
}


if ($seoClass) {
    $this->params['breadcrumbs'][] = [
        'label' => $seoClass->name,
        'url' => $seoClass->slug->slug.'?filter[result]=bc'
    ];
}
$district = '';
$district_filter_href = $city_url;
if ($model->district) {
    $district = ', ' . $model->district->name . ' р-н';
    $district_filter_href .= '&filter[districts][]=' . $model->district->id;
}
$comission = $model->percent_commission == 0 ? '<span class="red">' . Yii::t('app', 'no commission') . ' </span>' : '<span class="red"> ' . Yii::t('app', 'commission') . ' ' . $model->percent_commission . '%</span>';

$objectTitle = getDefaultTranslate('name', $currentLanguage, $model);
$addres = ''; //$model->address;
$coord = [$model->lng, $model->lat];
$firstImage = isset($model->images[0]) ? $model->images[0]->imgSrc : '';
$class = $model->class->short_name;

$marker = [
    'coordinates' => $coord,
    'zoom' => $zoom
];
$this->registerJsVar('marker', $marker, $this::POS_HEAD);


$this->title = getDefaultTranslate('title', $currentLanguage, $model);
$this->params['breadcrumbs'][] = $objectTitle;
$share_img_url = '';
$cityName = getDefaultTranslate('name', $currentLanguage, $model->city, true);

$script = <<< JS
var city = $city_id, 
    cityTitle = $(".choose-city .dropdown_title p"), 
    cities = $(".choose-city li a");
cities.removeClass('active');
if(city!=0) {
   cities.each(function () {
    if ($(this).data('id') == city) {
     $(this).addClass('active');
     cityTitle.text($(this).text());
     }
    });
 }
JS;
$this->registerJs($script, $this::POS_READY, 'city-handler');

$minPrice = !empty($model->getMinPrice($places)) ? Yii::t('app', 'from') . ' ' . $model->getMinPrice($places)['price'] . ' ₴/m<sup>2</sup>' : Yii::t('app', 'price con.');
?>
<section class="grey_bg">

    <?= $this->render('_item-partial/_head', [
        'user' => $broker,
        'name' => $objectTitle,
    ]); ?>

    <form action="" id="main_form">
        <input name="city_link" type="hidden" id="city_link" value="<?= $rentHref ?>"
               data-valuesell="<?= $sellHref ?>">
        <input name="main_type" type="hidden" id="main_type" value="<?= $target ?>">
        <input id="submit_main_form" type="hidden">
    </form>

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
                                <div class="star_checkbox like_star item_info">
                                    <?= WishlistButton::widget([
                                        'model' => $model,
                                        'anchorActive' => '<i class="fav rem"></i>',
                                        'anchorUnactive' => '<i class="fav"></i>',
                                        'cssClass' => 'multi out-wish',
                                        'cssClassInList' => 'in-wish',
                                        'building' => 'bc'
                                    ]); ?>
                                </div>

                            </div>
                            <div class="title_desc">
                                <div class="col">
                                    <p>Тип:</p>
                                </div>
                                <div class="col">
                                    <p><a href="<?= $city_url . '&filter[classes][]=' . $model->class->id ?>"
                                          class="green_link_3"><?= Yii::t('app', 'Business center') . ' ' . getDefaultTranslate('name', $currentLanguage, $model->class, true) ?> </a>
                                    </p>
                                </div>
                                <div class="col">
                                    <p>ID: <?= $model->id ?></p>
                                </div>
                            </div>
                        </div>
                    </div>


                    <? if (count($places) > 0) : ?>
                        <div class="inner">
                            <div class="free_office">
                                <a href="#places" class="scroll_to grey_pill"><?= Yii::t('app', 'Free Offices').': '.count($places).' - '.$minPrice ?></a>
                            </div>
                        </div>
                    <? else: ?>
                        <div class="inner">
                            <div class="office_info">
                                <p><b><?= Yii::t('app', 'Free Offices') ?>: <span
                                            class="red"><?= Yii::t('app', 'No') ?></span></b></p>
                                <?= Html::a(
                                    Yii::t('app', 'Subscribe to updates'),
                                    ['site/subscribe'],
                                    ['class' => 'green_pill green_pill_2 modal-form size-middle']
                                ) ?>
                            </div>
                        </div>
                    <? endif; ?>

                    <div class="inner">
                        <div class="two_cols_2 two_cols_2_2">
                            <div class="two_cols_2_col">
                                <div class="adres">
                                    <h5>
                                        <a target="_blank"
                                           href="<?= $district_filter_href ?>"><?= $cityName . $district ?></a>
                                    </h5>
                                    <? if ($model->address) : ?>
                                        <p><?= $model->address ?></p>
                                    <? endif; ?>
                                </div>
                                <? if (count($model->subways) > 0) : ?>
                                    <? foreach ($model->subways as $sub) : ?>
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
                                <p class="map_link"><i class="map"></i><a href="#" class="dashed_link showOnmap">на
                                        карте</a></p>
                            </div>
                        </div>
                    </div>
                    <? if (count($model->owners) > 0) : ?>
                        <? foreach ($model->owners as $user) : ?>
                            <?= $this->render('_partial/_user-info', [
                                'user' => $user,
                                'city_url' => $city_url,
                                'comission' => $comission,
                                'role' => 'Собственник'
                            ]); ?>
                        <? endforeach; ?>
                    <? endif; ?>
                    <?= $this->render('_partial/_user-info', [
                                'user' => $broker,
                                'city_url' => $city_url,
                                'comission' => $comission,
                                'role' => 'Брокер'
                            ]); ?>
                    <?/* if (count($model->brokers) > 0) : */?><!--
                        <?/* foreach ($model->brokers as $user) : */?>
                            <?/* debug($user) */?>
                            <?/*= $this->render('_partial/_user-info', [
                                'user' => $user,
                                'city_url' => $city_url,
                                'comission' => $comission,
                                'role' => 'Брокер'
                            ]); */?>
                        <?/* endforeach; */?>
                    --><?/* endif; */?>
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
                            <?= \ymaker\social\share\widgets\SocialShare::widget([
                                'configurator' => 'socialShare',
                                'url' => yii\helpers\Url::current([], true),
                                'title' => $this->title,
                                'description' => 'Description of the page...',
                                'imageUrl' => \yii\helpers\Url::to($share_img_url, true),
                            ]); ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="sect_7_2">
    <div class="row row_2">
        <? if (!empty($content = getDefaultTranslate('content', $currentLanguage, $model))) : ?>
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
        <? endif; ?>

        <? if (!empty($model->characteristics)) : ?>
            <div class="specifications_wrapp">
                <h2><?= Yii::t('app', 'Characteristics') ?></h2>
                <div class="text_box text_box_shadow" id="slide_text_2" data-minheight="250">
                    <div class="inner_height">
                        <div class="specifications offset_ziro">
                            <? foreach ($model->characteristics as $char) : ?>
                                <div class="specification_thumb">
                                    <div class="col">
                                        <div class="icon_box">
                                            <img src="/img/<?= $char->characteristic->img ?>" alt=""/>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <h3><?= getDefaultTranslate('name', $currentLanguage, $char->characteristic, true) ?></h3>
                                        <p><?= getDefaultTranslate('value', $currentLanguage, $char, true) ?></p>
                                    </div>
                                </div>
                            <? endforeach; ?>
                        </div>
                    </div>
                </div>
                <? if (count($model->characteristics) > 6) : ?>
                    <div class="showmore_wrapp">
                        <a href="#" class="green_link show_text" data-slidebox-id="slide_text_2">
                            <i class="plus"></i>
                            <span class="show"><?= Yii::t('app', 'Show more') ?></span>
                            <span class="hide"><?= Yii::t('app', 'Collapse') ?></span>
                        </a>
                    </div>
                <? endif; ?>

            </div>
        <? endif; ?>

    </div>

</section>

<? if (count($placesRent) > 0) {
    echo $this->render('_item-partial/_places', [
        'target' => $target,
        'places' => $placesRent,
        'blockTitle' => Yii::t('app', 'Office rental - offers'),
        'userId' => $broker->id
    ]);
} ?>

<? /*if (count($placesRent) > 0) {
    echo $this->render('_item-partial/_places-owner', [
        'target' => $target,
        'places' => $placesRent,
        'tablId' => 'placesOwnerTable',
        'galleryId' => 'galleries_2',
        'dataTable' => 'rent_table',
        'blockTitle' => Yii::t('app', 'Office rental - offers')
    ]);
}*/ ?>

<? /*if (count($placesRentArhive) > 0) {
    echo $this->render('_item-partial/_places-owner', [
        'target' => $target,
        'places' => $placesRentArhive,
        'tablId' => 'placesRentArhiveTable',
        'galleryId' => 'galleries_ar_2',
        'dataTable' => 'rent_ar_table',
        'blockTitle' => Yii::t('app', 'Office rental - archive')
    ]);
}*/ ?>



<? if (count($placesSell) > 0) {
    echo $this->render('_item-partial/_places-sell', [
        'target' => $target,
        'places' => $placesSell,
        'tablId' => 'placesSellTable',
        'galleryId' => 'galleries_3',
        'blockTitle' => Yii::t('app', 'Office sale - offers')
    ]);
} ?>

<? /*if (count($placesSell) > 0) {
    echo $this->render('_item-partial/_places-owner-sell', [
        'target' => $target,
        'places' => $placesSell,
        'tablId' => 'placesOwnerSellTable',
        'galleryId' => 'galleries_4',
        'dataTable' => 'sell_table',
        'blockTitle' => Yii::t('app', 'Office sale - offers')
    ]);
}*/ ?>

<? /*if (count($placesSellArhive) > 0) {
    echo $this->render('_item-partial/_places-owner-sell', [
        'target' => $target,
        'places' => $placesSellArhive,
        'tablId' => 'placesSellArhiveTable',
        'galleryId' => 'galleries_4',
        'dataTable' => 'sell_ar_table',
        'blockTitle' => Yii::t('app', 'Office sale - archive')
    ]);
}*/ ?>

<section class="sect_4_buisnes_center">
    <div class="row">
        <h2><?= Yii::t('app', 'Tenants') ?></h2>
        <?= common\widgets\PartnersWidget::widget(); ?>
    </div>
</section>

<section class="grey_bg">
    <div class="row row_2">
        <div class="two_cols_templ_2 clearfix" id="contacts">
            <div class="left">
                <div class="h2_wrapp">
                    <h2><?= Yii::t('app', 'Contact') ?></h2>
                </div>
                <div class="contact_item">
                    <div class="col">
                        <img src="/img/green_marker.svg" alt=""/>
                    </div>
                    <div class="col">
                        <p><?= $objectTitle . ',<br />' . $model->address . '<br />' . $cityName ?></p>
                    </div>
                </div>

                        <?
                        //debug($broker);
                        echo $this->render('_partial/_user-info', [
                            'user' => $broker,
                            'city_url' => $city_url,
                            'comission' => $comission,
                            'role' => 'Брокер'
                        ]);
                        ?>


                <? //if (count($model->brokers) > 0) : ?>
                    <? //foreach ($model->brokers as $user) : ?>
                        <? /*echo $this->render('_partial/_user-contact', [
                            'user' => $user,
                            'role' => 'Брокер'
                        ]);*/ ?>
                    <? //endforeach; ?>
                <? //endif; ?>


                <? //if (count($model->owners) > 0) : ?>
                    <? //foreach ($model->owners as $user) : ?>
                        <? /*echo $this->render('_partial/_user-contact', [
                            'user' => $user,
                            'role' => 'Собственник'
                        ]); */ ?>
                    <? //endforeach; ?>
                <? //endif; ?>

                <div class="contact_item">
                    <div class="col">
                        <img src="/img/green_envelop.svg" alt=""/>
                    </div>
                    <div class="col">
                        <p><a href="mailto:office@gmail.com">office@gmail.com</a></p>
                    </div>
                </div>
                <div class="contact_item">
                    <div class="col">
                        <img src="/img/green_globus.svg" alt=""/>
                    </div>
                    <div class="col">
                        <p><a href="#">www.atevilla.com.ua</a></p>
                    </div>
                </div>
            </div>
            <div class="right">
                <?= $this->render('order', [
                    'model' => $order,
                    'user' => $broker
                ]); ?>
            </div>
        </div>
    </div>
</section>

<section class="sect_7_bc">
    <div class="row">
        <? echo \common\widgets\AltOffersWidget::widget(['item' => $model, 'target' => $target]) ?>
        <?= common\widgets\ServicesWidget::widget(); ?>
    </div>
</section>
<section class="sect_7_2_bc">
    <div class="row">
        <? echo common\widgets\DistrictsStatWidget::widget(['target' => $target, 'city' => $city_id]); ?>
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


