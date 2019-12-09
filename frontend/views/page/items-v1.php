<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\LinkPager;

$currentLanguage = Yii::$app->language;
$this->title = getDefaultTranslate('title', $currentLanguage, $seo);
$this->params['breadcrumbs'][] = $this->title;

?>
<section class="object_map_sect">

    <div id="filters">
        <div class="filter_nav">
            <div class="row">
                <div class="items_sect clearfix">
                    <div class="left filters">
                        <div class="item_wrapp novisible_767">
                            <div class="dropdow_item_wrapp">
                                <div class="dropdown_item_title">
                                    <div class="item_title_text">Аренда</div>
                                </div>
                                <div class="dropdown_item_menu single">
                                    <a href="#">Продажа</a>
                                </div>
                            </div>
                        </div>
                        <div class="item_wrapp novisible_1024">
                            <div class="dropdow_item_wrapp">
                                <div class="dropdown_item_title green_active">
                                    <div class="item_title_text">Площадь</div>
                                </div>
                                <div class="dropdown_item_menu price_w">
                                    <div class="append-elem" data-append-desktop-elem="6" data-min-screen="1024">
                                        <h4>Площадь офиса, <span class="val_p">м²</span></h4>
                                        <div class="bars_range_wrapp">
                                            <div class="bars">
                                                <!-- bar это цена, data-count-val - количество объектов по этой цене -->
                                                <div class="bar" data-count-val="0"></div>
                                                <div class="bar" data-count-val="0"></div>
                                                <div class="bar" data-count-val="30"></div>
                                                <div class="bar" data-count-val="50"></div>
                                                <div class="bar" data-count-val="10"></div>
                                                <div class="bar" data-count-val="20"></div>
                                                <div class="bar" data-count-val="30"></div>
                                                <div class="bar" data-count-val="40"></div>
                                                <div class="bar" data-count-val="60"></div>
                                                <div class="bar" data-count-val="50"></div>
                                                <div class="bar" data-count-val="40"></div>
                                                <div class="bar" data-count-val="30"></div>
                                                <div class="bar" data-count-val="10"></div>
                                                <div class="bar" data-count-val="30"></div>
                                                <div class="bar" data-count-val="20"></div>
                                                <div class="bar" data-count-val="0"></div>
                                                <div class="bar" data-count-val="0"></div>
                                                <div class="bar" data-count-val="0"></div>
                                                <div class="bar" data-count-val="0"></div>
                                                <div class="bar" data-count-val="0"></div>
                                                <div class="bar" data-count-val="0"></div>
                                                <div class="bar" data-count-val="0"></div>
                                                <div class="bar" data-count-val="10"></div>
                                                <div class="bar" data-count-val="0"></div>
                                                <div class="bar" data-count-val="0"></div>
                                                <div class="bar" data-count-val="0"></div>
                                                <div class="bar" data-count-val="0"></div>
                                                <div class="bar" data-count-val="0"></div>
                                                <div class="bar" data-count-val="0"></div>
                                            </div>
                                            <div class="range_slider_wrapp">
                                                <div id="range_slider_4"></div>
                                            </div>
                                        </div>
                                        <div class="range_inputs">
                                            <div class="col">
                                                <div class="input_wrapp inline">
                                                    <input type="number" placeholder="99999" id="input-number_5"/>
                                                </div>
                                                <div class="slash inline"></div>
                                                <div class="input_wrapp inline">
                                                    <input type="number" placeholder="99999" id="input-number_6"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="footer_two_cols clearfix">
                                        <div class="left">
                                            <p><a href="#" class="green_link">Применить</a></p>
                                        </div>
                                        <div class="right">
                                            <p><a href="#" class="black_link">Очистить</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item_wrapp novisible_1024">
                            <div class="dropdow_item_wrapp">
                                <div class="dropdown_item_title dropdown_item_title_2">
                                    <div class="item_title_text">
                                        <p>$ 1400 - 5000</p>
                                    </div>
                                </div>
                                <div class="dropdown_item_menu price_w">
                                    <div class="append-elem" data-append-desktop-elem="7" data-min-screen="1024">
                                        <div class="metro_two_cols metro_two_cols_2">
                                            <div class="col">
                                                <h4>Арендная ставка,</h4>
                                            </div>
                                            <div class="col">
                                                <div class="custom_select_wrapp">
                                                    <div class="custom_select">
                                                        <div>
                                                            <input type="text" class="select_res" value="$/м²/mec"
                                                                   readonly="readonly"/>
                                                            <p class="select_input"><span class="sel_val"
                                                                                          id="price_sel">$/м²/mec</span>
                                                            </p>
                                                        </div>
                                                        <div class="dropdown_select">
                                                            <div class="select_item">
                                                                <p>$/м²/mec</p>
                                                            </div>
                                                            <div class="select_item">
                                                                <p>$/mec</p>
                                                            </div>
                                                            <div class="select_item">
                                                                <p>&#8372;/м²/mec</p>
                                                            </div>
                                                            <div class="select_item">
                                                                <p>&#8372;/mec</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bars_range_wrapp">
                                            <div class="bars">
                                                <!-- bar это цена, data-count-val - количество объектов по этой цене -->
                                                <div class="bar" data-count-val="0"></div>
                                                <div class="bar" data-count-val="0"></div>
                                                <div class="bar" data-count-val="30"></div>
                                                <div class="bar" data-count-val="50"></div>
                                                <div class="bar" data-count-val="10"></div>
                                                <div class="bar" data-count-val="20"></div>
                                                <div class="bar" data-count-val="30"></div>
                                                <div class="bar" data-count-val="40"></div>
                                                <div class="bar" data-count-val="60"></div>
                                                <div class="bar" data-count-val="50"></div>
                                                <div class="bar" data-count-val="40"></div>
                                                <div class="bar" data-count-val="30"></div>
                                                <div class="bar" data-count-val="10"></div>
                                                <div class="bar" data-count-val="30"></div>
                                                <div class="bar" data-count-val="20"></div>
                                                <div class="bar" data-count-val="0"></div>
                                                <div class="bar" data-count-val="0"></div>
                                                <div class="bar" data-count-val="0"></div>
                                                <div class="bar" data-count-val="0"></div>
                                                <div class="bar" data-count-val="0"></div>
                                                <div class="bar" data-count-val="0"></div>
                                                <div class="bar" data-count-val="0"></div>
                                                <div class="bar" data-count-val="10"></div>
                                                <div class="bar" data-count-val="0"></div>
                                                <div class="bar" data-count-val="0"></div>
                                                <div class="bar" data-count-val="0"></div>
                                                <div class="bar" data-count-val="0"></div>
                                                <div class="bar" data-count-val="0"></div>
                                                <div class="bar" data-count-val="0"></div>
                                            </div>
                                            <div class="range_slider_wrapp">
                                                <div id="range_slider_2"></div>
                                            </div>
                                        </div>
                                        <div class="range_inputs">
                                            <div class="input_wrapp inline">
                                                <input type="number" placeholder="99999" id="input-number_1"/>
                                            </div>
                                            <div class="slash inline"></div>
                                            <div class="input_wrapp inline">
                                                <input type="number" placeholder="99999" id="input-number_2"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="footer_two_cols clearfix">
                                        <div class="left">
                                            <p><a href="#" class="green_link">Применить</a></p>
                                        </div>
                                        <div class="right">
                                            <p><a href="#" class="black_link">Очистить</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item_wrapp">
                            <button type="button" class="more_filter"><span
                                    class="novisible_767">Еще фильтры</span><span class="visible_767">Фильтры</span>
                            </button>
                        </div>
                        <div class="item_wrapp append-elem novisible_767" data-append-desktop-elem="8"
                             data-min-screen="767">
                            <a href="#" class="green_pill green_pill_2">Подписаться на обновления</a>
                        </div>
                    </div>
                    <div class="right">
                        <div class="item_wrapp">
                            <div class="map_checkbox">
                                <input type="checkbox" name="map_ch" id="onMap"/>
                                <label for="onMap">На карте</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="filter_resp_wrapp" id="filters_menu">
        <div class="filter_resp">
            <div class="close_box">
                <button type="button" class="close_filter"></button>
            </div>
            <div class="resp_filter_wrapp visible_767">
                <div class="resp_filter_inner">
                    <div class="green_pills_wrapp">
                        <div class="pill_checlbox_2">
                            <input type="radio" name="pill_checkboxes_2" id="pill_ch_3"/>
                            <label for="pill_ch_3">Аренда</label>
                        </div>
                        <div class="pill_checlbox_2">
                            <input type="radio" name="pill_checkboxes_2" id="pill_ch_4" checked="checked">
                            <label for="pill_ch_4">Продажа</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="resp_filter_wrapp visible_1024">
                <div class="dropdow_item_wrapp resp">
                    <div class="dropdown_item_title">
                        <div class="item_title_text">Площадь</div>
                        <div class="chose_filter" data-filters-index="filters_4">от <span class="minVal"></span> до
                            <span class="maxVal"></span> м²
                        </div>
                    </div>
                    <div class="dropdown_item_menu dropdown_item_menu_4">
                        <div class="append-elem" data-append-elem="6"></div>
                    </div>
                </div>
            </div>
            <div class="resp_filter_wrapp visible_1024">
                <div class="dropdow_item_wrapp resp">
                    <div class="dropdown_item_title">
                        <div class="item_title_text">Ценовой диапазон</div>
                        <div class="chose_filter" data-filters-index="filters_3">
                            <span class="price_range_str">от <span class="minVal2"></span> до <span
                                    class="maxVal2"></span></span> <span class="price_resp"></span>
                        </div>
                    </div>
                    <div class="dropdown_item_menu dropdown_item_menu_4">
                        <div class="append-elem" data-append-elem="7"></div>
                    </div>
                </div>
            </div>
            <div class="resp_filter_wrapp">
                <div class="dropdow_item_wrapp resp">
                    <div class="dropdown_item_title">
                        <div class="item_title_text">Район</div>
                        <div class="chose_filter" data-filters-index="filters_2"></div>
                    </div>
                    <div class="dropdown_item_menu dropdown_item_menu_4">
                        <div class="checkbox_wrapp">
                            <div class="checkbox">
                                <input type="checkbox" name="filter_ch" id="ch_18">
                                <label for="ch_18" data-filter="filters_2">Район 1</label>
                            </div>
                        </div>
                        <div class="checkbox_wrapp">
                            <div class="checkbox">
                                <input type="checkbox" name="filter_ch" id="ch_19">
                                <label for="ch_19" data-filter="filters_2">Район 2</label>
                            </div>
                        </div>
                        <div class="checkbox_wrapp">
                            <div class="checkbox">
                                <input type="checkbox" name="filter_ch" id="ch_20">
                                <label for="ch_20" data-filter="filters_2">Район 3</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="resp_filter_wrapp">
                <div class="dropdow_item_wrapp resp">
                    <div class="dropdown_item_title">
                        <div class="item_title_text">Метро</div>
                        <div class="chose_filter" data-filters-index="filters_5"><span id="metro_val"></span> Метров,
                            <span id="metro_name"></span></div>
                    </div>
                    <div class="dropdown_item_menu dropdown_item_menu_4">
                        <div class="metro_box">
                            <div class="metro_two_cols">
                                <div class="col">
                                    <h4>Ветка метро</h4>
                                </div>
                                <div class="col">
                                    <div class="radio_metro_wrapp">
                                        <div class="radio_wrapp metro_radio">
                                            <input type="radio" name="metro" id="metro_1"/>
                                            <label for="metro_1"><i class="red_metro"></i></label>
                                        </div>
                                        <div class="radio_wrapp metro_radio">
                                            <input type="radio" name="metro" id="metro_2"/>
                                            <label for="metro_2"><i class="green_metro"></i></label>
                                        </div>
                                        <div class="radio_wrapp metro_radio">
                                            <input type="radio" name="metro" id="metro_3"/>
                                            <label for="metro_3"><i class="blue_metro"></i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="metro_two_cols">
                                <div class="col">
                                    <h4>До метро</h4>
                                </div>
                                <div class="col">
                                    <div class="range_slider_wrapp range_slider_3_wrapp">
                                        <span class="sl_desc">Метров</span>
                                        <div id="range_slider_3"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="select_4_wrapp select_4_2">
                            <div class="custom_select_2">
                                <div class="custom_select_title" id="metro_name_val"><a href="#">Метро</a></div>
                                <div class="custom_select_list">
                                    <div class="custom_select_item selected"><a href="#">Option 1</a></div>
                                    <div class="custom_select_item"><a href="#">Option 2</a></div>
                                    <div class="custom_select_item"><a href="#">Option 3</a></div>
                                    <div class="custom_select_item"><a href="#">Option 4</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="resp_filter_wrapp">
                <div class="dropdow_item_wrapp resp">
                    <div class="dropdown_item_title">
                        <div class="item_title_text">Тип/Класс</div>
                        <div class="chose_filter" data-filters-index="filters_1"></div>
                    </div>
                    <div class="dropdown_item_menu dropdown_item_menu_4">
                        <div class="checkbox_wrapp">
                            <div class="checkbox">
                                <input type="checkbox" name="filter_ch" id="ch_3_2">
                                <label for="ch_3_2" data-filter="filters_1">БЦ класса А</label>
                            </div>
                        </div>
                        <div class="checkbox_wrapp">
                            <div class="checkbox">
                                <input type="checkbox" name="filter_ch" id="ch_4_2">
                                <label for="ch_4_2" data-filter="filters_1">БЦ класса В</label>
                            </div>
                        </div>
                        <div class="checkbox_wrapp">
                            <div class="checkbox">
                                <input type="checkbox" name="filter_ch" id="ch_5_2">
                                <label for="ch_5_2" data-filter="filters_1">БЦ класса С</label>
                            </div>
                        </div>
                        <div class="checkbox_wrapp">
                            <div class="checkbox">
                                <input type="checkbox" name="filter_ch" id="ch_6_2">
                                <label for="ch_6_2" data-filter="filters_1">Админ. здание</label>
                            </div>
                        </div>
                        <div class="checkbox_wrapp">
                            <div class="checkbox">
                                <input type="checkbox" name="filter_ch" id="ch_7_2">
                                <label for="ch_7_2" data-filter="filters_1">ОСЗ/Особняк</label>
                            </div>
                        </div>
                        <div class="checkbox_wrapp">
                            <div class="checkbox">
                                <input type="checkbox" name="filter_ch" id="ch_8_2">
                                <label for="ch_8_2" data-filter="filters_1">Coworking</label>
                            </div>
                        </div>
                        <div class="checkbox_wrapp">
                            <div class="checkbox">
                                <input type="checkbox" name="filter_ch" id="ch_9_2">
                                <label for="ch_9_2" data-filter="filters_1">Бизнес-парк</label>
                            </div>
                        </div>
                        <div class="checkbox_wrapp">
                            <div class="checkbox">
                                <input type="checkbox" name="filter_ch" id="ch_10_2">
                                <label for="ch_10_2" data-filter="filters_1">Технопарк</label>
                            </div>
                        </div>
                        <div class="checkbox_wrapp">
                            <div class="checkbox">
                                <input type="checkbox" name="filter_ch" id="ch_11_2">
                                <label for="ch_11_2" data-filter="filters_1">Офис в ЖК</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="resp_filter_wrapp">
                <div class="dropdow_item_wrapp resp">
                    <div class="dropdown_item_title">
                        <div class="item_title_text">Состояние</div>
                        <div class="chose_filter" data-filters-index="filters_6"></div>
                    </div>
                    <div class="dropdown_item_menu dropdown_item_menu_4">
                        <div class="checkbox_wrapp">
                            <div class="checkbox">
                                <input type="checkbox" name="filter_ch" id="ch_15_2">
                                <label for="ch_15_2" data-filter="filters_6">Состояние 1</label>
                            </div>
                        </div>
                        <div class="checkbox_wrapp">
                            <div class="checkbox">
                                <input type="checkbox" name="filter_ch" id="ch_16_2">
                                <label for="ch_16_2" data-filter="filters_6">Состояние 2</label>
                            </div>
                        </div>
                        <div class="checkbox_wrapp">
                            <div class="checkbox">
                                <input type="checkbox" name="filter_ch" id="ch_17_2">
                                <label for="ch_17_2" data-filter="filters_6">Состояние 3</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="resp_filter_wrapp">
                <div class="resp_filter_inner">
                    <div class="checkbox">
                        <input type="checkbox" name="filter_ch" id="ch_1_2"/>
                        <label for="ch_1_2">Без комиссии</label>
                    </div>
                </div>
            </div>
            <div class="resp_filter_wrapp visible_1024">
                <div class="dropdow_item_wrapp resp">
                    <div class="dropdown_item_title">
                        <div class="item_title_text">Сортировать</div>
                        <div class="chose_filter" data-filters-index="filters_7"></div>
                    </div>
                    <div class="dropdown_item_menu dropdown_item_menu_4">
                        <div>
                            <div class="radio_wrapp_2">
                                <input type="radio" name="filter_radio" id="r_15_2">
                                <label for="r_15_2" data-radio-filter="filters_7">По возрастанию цены</label>
                            </div>
                        </div>
                        <div>
                            <div class="radio_wrapp_2">
                                <input type="radio" name="filter_radio" id="r_16_2">
                                <label for="r_16_2" data-radio-filter="filters_7">По убыванию цены</label>
                            </div>
                        </div>
                        <div>
                            <div class="radio_wrapp_2">
                                <input type="radio" name="filter_radio" id="r_17_2">
                                <label for="r_17_2" data-radio-filter="filters_7">По популярности</label>
                            </div>
                        </div>
                        <div>
                            <div class="radio_wrapp_2">
                                <input type="radio" name="filter_radio" id="r_18_2">
                                <label for="r_18_2" data-radio-filter="filters_7">По дате добавления</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="resp_filter_wrapp">
                <div class="resp_filter_inner">
                    <div class="filter_wrapp">
                        <div class="col">
                            <p>Выводить:</p>
                        </div>
                        <div class="col">
                            <div class="checkboxes_wrapp">
                                <div class="pill_checlbox">
                                    <input type="radio" name="pill_checkboxes" id="pill_ch_1" checked/>
                                    <label for="pill_ch_1">Офисы</label>
                                </div>
                                <div class="pill_checlbox">
                                    <input type="radio" name="pill_checkboxes" id="pill_ch_2"/>
                                    <label for="pill_ch_2">Бизнес-Центры</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer_two_cols_resp">
                <div class="share_btn">
                    <div class="append-elem" data-append-elem="8"></div>
                </div>
                <div class="flex_pills">
                    <a href="#" class="olive_pill">Применить</a>
                    <a href="#" class="white_pill">Очистить</a>
                </div>
            </div>
        </div>
        <div class="mask_2"></div>
    </div>
    <div id="map_box">
        <div class="mask"></div>
        <div class="map_object_header">
            <div class="row clearfix">
                <div class="left">
                    <div class="inlines_wrapp">
                        <div class="inline">
                            <h4><?= getDefaultTranslate('name', $currentLanguage, $seo) ?></h4>
                        </div>
                        <div class="inline">
                            <p><?= Yii::t('app', 'Found: {countPlaces} offices', [
                                    'countPlaces' => $countPlaces,
                                ]); ?> </p>
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
                            if ($items[$i]) {
                                echo $this->render('_partial/_card', [
                                    'item' => $items[$i],
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
                            if ($items[$i]) {
                                echo $this->render('_partial/_card', [
                                    'item' => $items[$i],
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
    </div>
    <div class="bottom_coord"></div>
</section>
<?= $this->render('_partial/_items-foot', [
'seo' => $seo,
]); ?>

<!-- Photo Gallery -->
<div class="photo_gallery"></div>
<!-- /Photo Gallery -->
<?
$script = <<< JS
 var map, mar, markers = [], id, geojson = $markers;
JS;
$this->registerCssFile('https://api.tiles.mapbox.com/mapbox-gl-js/v1.2.0/mapbox-gl.css');
$this->registerJsFile('https://api.tiles.mapbox.com/mapbox-gl-js/v1.2.0/mapbox-gl.js');
$this->registerJsFile('https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-language/v0.10.1/mapbox-gl-language.js');
$this->registerJs($script, $position = $this::POS_BEGIN);
$this->registerJsFile('/js/mapbox.js',['depends' => [\yii\web\JqueryAsset::className()]]);
?>
