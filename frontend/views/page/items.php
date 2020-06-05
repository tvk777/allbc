<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;
use yii\helpers\Url;
//echo Yii::$app->settings->maxM2;
//debug($pricesChart);

//debug($items[0]['bc']);
//debug($conditions);
//[type] => 3
//debug($items[1]['bc']->minPrice);
//debug($items[0]['places']);
//debug($items[0]->place);
//$currency = $conditions['currency'];
$currentLanguage = Yii::$app->language;
$this->title = getDefaultTranslate('title', $currentLanguage, $seo);
$this->params['breadcrumbs'][] = $this->title;
if (!empty($city)) {
    $sellHref = $city->slug_sell;
    $rentHref = $city->slug;
    $city = $city->id;
} else {
    $sellHref = $mainSell;
    $rentHref = $mainRent;
}
$script = <<< JS
var city = $city, 
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
$result = !empty($params['result']) && $params['result'] == 'bc' ? 'bc' : 'offices';
$h1 = getDefaultTranslate('name', $currentLanguage, $seo);
$h2 = getDefaultTranslate('short_content', $currentLanguage, $seo);
?>

<section class="items-top-banner">
    <?= common\widgets\SliderWidget::widget(['text' => [$h1, $h2]]); ?>
</section>
<section class="object_map_sect">
    <form action="" id="main_form">
        <input name="city_link" type="hidden" id="city_link" value="<?= $rentHref ?>"
               data-valuesell="<?= $sellHref ?>">
        <input name="main_type" type="hidden" id="main_type" value="<?= $seo->target ?>">
        <input id="submit_main_form" type="hidden">
    </form>


    <? echo $this->render('_partial/_items-head', [
        'seo' => $seo,
        'countValM2' => $countValM2,
        'filters' => $filters,
        'params' => $params,
        'pricesChart' => $pricesChart,
        'rates' => $rates,
        'result' => $result,
        'countPlaces' => $countPlaces
    ]); ?>
    <?php Pjax::begin([
        'enableReplaceState' => true,
        'enablePushState' => true,
        'options' => ['id' => 'cardsPjax'],
        'formSelector' => '#filterForm',
        'timeout' => 10000,
        'clientOptions' => ['method' => 'GET']
    ]); ?>

    <div class="append-elem" data-append-elem="map_index"></div>

    <div class="map_object_templ">
        <div class="row">
            <div class="w_half">
                <div class="objects_cards">
                    <?
                    for ($i = 0; $i <= 7; $i++) {
                        if (isset($items[$i])) {
                            echo $this->render('_partial/_card', [
                                'item' => $items[$i],
                                'target' => $seo->target,
                                'result' => $result,
                                'currentLanguage' => $currentLanguage,
                                'currency' => $currency,
                                'rates' => $rates,
                                'type' => $conditions['type'],
                                'taxes' => $taxes
                            ]);
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <? if($city==1) : ?>
        <div class="two_cols_templ_wrapp two_cols_templ_wrapp_2 white_bg">
            <div class="row">
                <div class="w_half">
                    <?= common\widgets\ExpertsWidget::widget(); ?>
                </div>
            </div>
        </div>
        <? endif; ?>
        <div class="row">
            <div class="w_half">
                <div class="objects_catalog objects_cards">
                    <?
                    for ($i = 8; $i <= 16; $i++) {
                        if (isset($items[$i])) {
                            echo $this->render('_partial/_card', [
                                'item' => $items[$i],
                                'target' => $seo->target,
                                'result' => $result,
                                'currentLanguage' => $currentLanguage,
                                'currency' => $currency,
                                'rates' => $rates,
                                'type' => $conditions['type'],
                                'taxes' => $taxes
                            ]);
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="row">
            <?
            debug($pages);
            echo LinkPager::widget([
                'pagination' => $pages,
            ]); ?>
        </div>

        <div class="append-elem" data-append-desktop-elem="map_index" data-min-screen="1024">
            <div class="object_map">
                <div class="map_scroll">
                    <div class="map_search_wrapp">
                        <div class="map_search checkbox">
                            <input type="checkbox" name="searchonmap" id="searchonmap"/>
                            <label for="searchonmap">Поиск при перемещении на карте</label>
                        </div>
                    </div>
                    <div id="object_map"></div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <?
    $script = <<< JS
 var map, mar, markers = [], id, geojson = $markers, center = $center, zoom = $zoom, countOfices = $countPlaces;
JS;
    $this->registerJs($script, $position = $this::POS_BEGIN);
    Pjax::end();
    ?>

    <div class="bottom_coord"></div>

</section>
<?= $this->render('_partial/_items-foot', [
    'seo' => $seo,
    'city' => $city
]); ?>

<!-- Photo Gallery -->
<div class="photo_gallery"></div>
<!-- /Photo Gallery -->
<?
$this->registerCssFile('https://api.tiles.mapbox.com/mapbox-gl-js/v1.2.0/mapbox-gl.css');
$this->registerJsFile('https://api.tiles.mapbox.com/mapbox-gl-js/v1.2.0/mapbox-gl.js');
$this->registerJsFile('https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-language/v0.10.1/mapbox-gl-language.js');
$this->registerJsFile('/js/mapbox.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>



