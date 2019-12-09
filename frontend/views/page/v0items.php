<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

$currentLanguage = Yii::$app->language;
$this->title = getDefaultTranslate('title', $currentLanguage, $seo);
$this->params['breadcrumbs'][] = $this->title;
if($city!==0){
    $city = $city->id;
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
//debug($m2);
?>
<section class="object_map_sect">
    <form action="" id="main_form">
        <input name="city_link" type="hidden" id="city_link" value="<?= $mainRent ?>"
               data-valuesell="<?= $mainSell ?>">
        <input name="main_type" type="hidden" id="main_type" value="1">
        <input id="submit_main_form" type="hidden">
    </form>

    <?= $this->render('_partial/_items-head', [
        'seo' => $seo,
        'countValM2' => $countValM2,
        'filters' => $filters,
        'params' => $params
    ]); ?>

    <div id="map_box">
        <?php Pjax::begin([
            'enableReplaceState' => false,
            'enablePushState' => false,
            'options' => ['id' => 'cardsPjax']
        ]); ?>
        <div class="mask"></div>
        <div class="map_object_header">
            <div class="row clearfix">
                <div class="left">
                    <div class="inlines_wrapp">
                        <div class="inline">
                            <h4><?= getDefaultTranslate('name', $currentLanguage, $seo) ?></h4>
                        </div>
                        <div class="inline">
                            <p><?= $countPlaces ?> </p>
                        </div>
                    </div>
                </div>
                <div class="right align_right">
                    <div class="custom_select_wrapp custom_select_wrapp_2">
                        <div class="custom_select">
                            <div>
                                <input type="text" class="select_res" value="$/м²/mec" readonly="readonly">
                                <p class="select_input"><span class="sel_val">Сортировать</span></p>
                            </div>
                            <div class="dropdown_select">
                                <div class="select_item">
                                    <p>По возрастанию цены</p>
                                </div>
                                <div class="select_item">
                                    <p>По убыванию цены</p>
                                </div>
                                <div class="select_item">
                                    <p>По популярности</p>
                                </div>
                                <div class="select_item">
                                    <p>По дате добавления</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="append-elem" data-append-elem="map_index"></div>
        <div class="map_object_templ">
            <div class="row">
                <div class="w_half">
                    <div class="objects_cards">
                        <? for ($i = 0; $i <= 3; $i++) {
                            if (isset($items[$i])) {
                                echo $this->render('_partial/_card', [
                                    'item' => $items[$i],
                                    'target' => $seo->target,
                                    'm2' => $m2,
                                    'places' => $places
                                ]);
                            }
                        } ?>
                    </div>
                </div>
            </div>
            <div class="two_cols_templ_wrapp two_cols_templ_wrapp_2 white_bg">
                <div class="row">
                    <div class="w_half">
                        <?= common\widgets\ExpertsWidget::widget(); ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="w_half">
                    <div class="objects_catalog objects_cards">
                        <? for ($i = 4; $i <= 7; $i++) {
                            if (isset($items[$i])) {
                                echo $this->render('_partial/_card', [
                                    'item' => $items[$i],
                                    'target' => $seo->target,
                                    'm2' => $m2,
                                    'places' => $places
                                ]);
                            }
                        } ?>
                    </div>
                    <? echo LinkPager::widget([
                        'pagination' => $pages,
                    ]); ?>
                </div>
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
        <?php Pjax::end(); ?>
    </div>
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
$script = <<< JS
 var map, mar, markers = [], id, geojson = $markers, center = $center, zoom = $zoom;
JS;
$this->registerCssFile('https://api.tiles.mapbox.com/mapbox-gl-js/v1.2.0/mapbox-gl.css');
$this->registerJsFile('https://api.tiles.mapbox.com/mapbox-gl-js/v1.2.0/mapbox-gl.js');
$this->registerJsFile('https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-language/v0.10.1/mapbox-gl-language.js');
$this->registerJs($script, $position = $this::POS_BEGIN);
$this->registerJsFile('/js/mapbox.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
