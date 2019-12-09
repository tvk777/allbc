<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\LinkPager;

$currentLanguage = Yii::$app->language;
//debug($model);
$this->title = $seo->title;
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
                                    <div class="append-elem" data-append-desktop-elem = "6" data-min-screen = "1024">
                                        <h4>Площадь офиса, <span class="val_p">м²</span></h4>
                                        <div class="bars_range_wrapp">
                                            <div class="bars">
                                                <!-- bar это цена, data-count-val - количество объектов по этой цене -->
                                                <div class="bar" data-count-val = "0"></div>
                                                <div class="bar" data-count-val = "0"></div>
                                                <div class="bar" data-count-val = "30"></div>
                                                <div class="bar" data-count-val = "50"></div>
                                                <div class="bar" data-count-val = "10"></div>
                                                <div class="bar" data-count-val = "20"></div>
                                                <div class="bar" data-count-val = "30"></div>
                                                <div class="bar" data-count-val = "40"></div>
                                                <div class="bar" data-count-val = "60"></div>
                                                <div class="bar" data-count-val = "50"></div>
                                                <div class="bar" data-count-val = "40"></div>
                                                <div class="bar" data-count-val = "30"></div>
                                                <div class="bar" data-count-val = "10"></div>
                                                <div class="bar" data-count-val = "30"></div>
                                                <div class="bar" data-count-val = "20"></div>
                                                <div class="bar" data-count-val = "0"></div>
                                                <div class="bar" data-count-val = "0"></div>
                                                <div class="bar" data-count-val = "0"></div>
                                                <div class="bar" data-count-val = "0"></div>
                                                <div class="bar" data-count-val = "0"></div>
                                                <div class="bar" data-count-val = "0"></div>
                                                <div class="bar" data-count-val = "0"></div>
                                                <div class="bar" data-count-val = "10"></div>
                                                <div class="bar" data-count-val = "0"></div>
                                                <div class="bar" data-count-val = "0"></div>
                                                <div class="bar" data-count-val = "0"></div>
                                                <div class="bar" data-count-val = "0"></div>
                                                <div class="bar" data-count-val = "0"></div>
                                                <div class="bar" data-count-val = "0"></div>
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
                                    <div class="append-elem" data-append-desktop-elem = "7" data-min-screen = "1024">
                                        <div class="metro_two_cols metro_two_cols_2">
                                            <div class="col">
                                                <h4>Арендная ставка,</h4>
                                            </div>
                                            <div class="col">
                                                <div class="custom_select_wrapp">
                                                    <div class="custom_select">
                                                        <div>
                                                            <input type="text" class="select_res" value="$/м²/mec" readonly="readonly" />
                                                            <p class="select_input"><span class="sel_val" id="price_sel">$/м²/mec</span></p>
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
                                                <div class="bar" data-count-val = "0"></div>
                                                <div class="bar" data-count-val = "0"></div>
                                                <div class="bar" data-count-val = "30"></div>
                                                <div class="bar" data-count-val = "50"></div>
                                                <div class="bar" data-count-val = "10"></div>
                                                <div class="bar" data-count-val = "20"></div>
                                                <div class="bar" data-count-val = "30"></div>
                                                <div class="bar" data-count-val = "40"></div>
                                                <div class="bar" data-count-val = "60"></div>
                                                <div class="bar" data-count-val = "50"></div>
                                                <div class="bar" data-count-val = "40"></div>
                                                <div class="bar" data-count-val = "30"></div>
                                                <div class="bar" data-count-val = "10"></div>
                                                <div class="bar" data-count-val = "30"></div>
                                                <div class="bar" data-count-val = "20"></div>
                                                <div class="bar" data-count-val = "0"></div>
                                                <div class="bar" data-count-val = "0"></div>
                                                <div class="bar" data-count-val = "0"></div>
                                                <div class="bar" data-count-val = "0"></div>
                                                <div class="bar" data-count-val = "0"></div>
                                                <div class="bar" data-count-val = "0"></div>
                                                <div class="bar" data-count-val = "0"></div>
                                                <div class="bar" data-count-val = "10"></div>
                                                <div class="bar" data-count-val = "0"></div>
                                                <div class="bar" data-count-val = "0"></div>
                                                <div class="bar" data-count-val = "0"></div>
                                                <div class="bar" data-count-val = "0"></div>
                                                <div class="bar" data-count-val = "0"></div>
                                                <div class="bar" data-count-val = "0"></div>
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
                            <button type="button" class="more_filter"><span class="novisible_767">Еще фильтры</span><span class="visible_767">Фильтры</span></button>
                        </div>
                        <div class="item_wrapp append-elem novisible_767" data-append-desktop-elem = "8" data-min-screen = "767">
                            <a href="#" class="green_pill green_pill_2">Подписаться на обновления</a>
                        </div>
                    </div>
                    <div class="right">
                        <div class="item_wrapp">
                            <div class="map_checkbox">
                                <input type="checkbox" name="map_ch" id="ch_2" />
                                <label for="ch_2">На карте</label>
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
                            <label for="pill_ch_4">Прродажа</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="resp_filter_wrapp visible_1024">
                <div class="dropdow_item_wrapp resp">
                    <div class="dropdown_item_title">
                        <div class="item_title_text">Площадь</div>
                        <div class="chose_filter" data-filters-index="filters_4">от <span class="minVal"></span> до <span class="maxVal"></span> м²</div>
                    </div>
                    <div class="dropdown_item_menu dropdown_item_menu_4">
                        <div class="append-elem" data-append-elem = "6"></div>
                    </div>
                </div>
            </div>
            <div class="resp_filter_wrapp visible_1024">
                <div class="dropdow_item_wrapp resp">
                    <div class="dropdown_item_title">
                        <div class="item_title_text">Ценовой диапазон</div>
                        <div class="chose_filter" data-filters-index="filters_3">
                            <span class="price_range_str">от <span class="minVal2"></span> до <span class="maxVal2"></span></span> <span class="price_resp"></span>
                        </div>
                    </div>
                    <div class="dropdown_item_menu dropdown_item_menu_4">
                        <div class="append-elem" data-append-elem = "7"></div>
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
                        <div class="chose_filter" data-filters-index="filters_5"><span id="metro_val"></span> Метров, <span id="metro_name"></span></div>
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
                                            <input type="radio" name="metro" id="metro_1" />
                                            <label for="metro_1"><i class="red_metro"></i></label>
                                        </div>
                                        <div class="radio_wrapp metro_radio">
                                            <input type="radio" name="metro" id="metro_2" />
                                            <label for="metro_2"><i class="green_metro"></i></label>
                                        </div>
                                        <div class="radio_wrapp metro_radio">
                                            <input type="radio" name="metro" id="metro_3" />
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
                        <input type="checkbox" name="filter_ch" id="ch_1_2" />
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
                                    <input type="radio" name="pill_checkboxes" id="pill_ch_2" />
                                    <label for="pill_ch_2">Бизнес-Центры</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer_two_cols_resp">
                <div class="share_btn">
                    <div class="append-elem" data-append-elem = "8"></div>
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
                            <h4>Аренда офиса в бизнес-центрах класса А в городе Киеве</h4>
                        </div>
                        <div class="inline">
                            <p>Найдено: 24 000 офисов</p>
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
        <div class="append-elem" data-append-elem = "map_index"></div>
        <div class="map_object_templ">
            <div class="row">
                <div class="w_half">
                    <div class="objects_cards">
                        <div class="object_card">
                            <div class="border_wrapp">
                                <div class="inner_wrapp">
                                    <div class="object_slider_wrapp">
                                        <div class="object_slider_header">
                                            <div class="inline">
                                                <div class="cl_pill">
                                                    <p>Класс A</p>
                                                </div>
                                            </div>
                                            <div class="inline">
                                                <div class="black_circle_2">
                                                    <i class="star_icon_2"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="object_slider">
                                            <div class="slide">
                                                <a href="img/img_11.jpg" class="img_box" data-fancybox="card_1" data-imageurl = "img/img_11.jpg">
                                                    <img src="#" alt="" />
                                                </a>
                                            </div>
                                            <div class="slide">
                                                <a href="img/img_12.jpg" class="img_box" data-fancybox="card_1" data-imageurl = "img/img_12.jpg">
                                                    <img src="#" alt="" />
                                                </a>
                                            </div>
                                            <div class="slide">
                                                <a href="img/img_05.jpg" class="img_box" data-fancybox="card_1" data-imageurl = "img/img_05.jpg">
                                                    <img src="#" alt="" />
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="object_thumb_descript">
                                        <div class="p_info red_p">
                                            <p>Комиссия: 100%</p>
                                        </div>
                                        <a href="#" class="object_card_title">Бизнес-центр Арена Сити Плаза, в два ряда название</a>
                                        <div class="two_cols_2">
                                            <!-- <div class="two_cols_2_col"> -->
                                            <div class="adres">
                                                <h5>г. Киев, Шевченковский р-н</h5>
                                                <p>ул. Льва Толстого, 57</p>
                                            </div>
                                            <div class="metro_wrapp">
                                                <p><i class="metro"></i>Театральная <span class="about">~</span> 900 м</p>
                                            </div>
                                            <!-- </div>
                                            <div class="two_cols_2_col">
                                                <div class="office_cont_wrapp">
                                                    <div class="office_cont">
                                                        <div class="col">
                                                            <i class="room_2"></i>
                                                        </div>
                                                        <div class="col">
                                                            <h5>24</h5>
                                                        </div>
                                                    </div>
                                                    <p>офисов</p>
                                                </div>
                                            </div> -->
                                        </div>
                                        <div class="thumb_5_footer">
                                            <div class="thumb_5_footer_col">
                                                <!-- <p>от 30 м²…303 м²</p> -->
                                                <p>площадь: 303 м²</p>
                                            </div>
                                            <div class="thumb_5_footer_col">
                                                <!-- <p>50 000 грн/мес</p> -->
                                                <p>цена: 968++ $/м²/mec</p>
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
                                                <p>$/м²</p>
                                            </div>
                                            <div class="table_cell">
                                                <p>all in/мес</p>
                                            </div>
                                            <div class="table_cell">
                                            </div>
                                        </div>
                                        <div class="table_row">
                                            <div class="table_cell">
                                                <p>90</p>
                                            </div>
                                            <div class="table_cell">
                                                <p>968 <span class="pluses">++</span></p>
                                            </div>
                                            <div class="table_cell">
                                                <p>140567</p>
                                            </div>
                                            <div class="table_cell">
                                            </div>
                                        </div>
                                        <div class="table_row">
                                            <div class="table_cell">
                                                <p>347</p>
                                            </div>
                                            <div class="table_cell">
                                                <p>1968 <span class="pluses">++</span></p>
                                            </div>
                                            <div class="table_cell">
                                                <p>140567</p>
                                            </div>
                                            <div class="table_cell">
                                                <a href="#" class="icon_link_2" data-photogallerylink = "18"><i class="photo"></i></a>
                                                <div class="images_paths_array" data-photogalleryindex = "18">
                                                    <span data-imagepath="img/img_11.jpg"></span>
                                                    <span data-imagepath="img/img_12.jpg"></span>
                                                    <span data-imagepath="img/img_05.jpg"></span>
                                                </div>
                                                <a href="#" class="icon_link_2"><i class="star_2"></i></a>
                                            </div>
                                        </div>
                                        <div class="table_row">
                                            <div class="table_cell">
                                                <p>1334</p>
                                            </div>
                                            <div class="table_cell">
                                                <p>968 <span class="pluses">++</span></p>
                                            </div>
                                            <div class="table_cell">
                                                <p>140567</p>
                                            </div>
                                            <div class="table_cell">
                                                <a href="#" class="icon_link_2" data-photogallerylink = "21"><i class="photo"></i></a>
                                                <div class="images_paths_array" data-photogalleryindex = "21">
                                                    <span data-imagepath="img/img_11.jpg"></span>
                                                    <span data-imagepath="img/img_12.jpg"></span>
                                                    <span data-imagepath="img/img_05.jpg"></span>
                                                </div>
                                                <a href="#" class="icon_link_2"><i class="star_2"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="object_card">
                            <div class="border_wrapp">
                                <div class="inner_wrapp">
                                    <div class="object_slider_wrapp">
                                        <div class="object_slider_header">
                                            <div class="inline">
                                                <div class="cl_pill">
                                                    <p>Класс A</p>
                                                </div>
                                            </div>
                                            <div class="inline">
                                                <div class="black_circle_2">
                                                    <i class="star_icon_2"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="object_slider">
                                            <div class="slide">
                                                <a href="img/img_11.jpg" class="img_box" data-fancybox="card_2" data-imageurl = "img/img_11.jpg">
                                                    <img src="#" alt="" />
                                                </a>
                                            </div>
                                            <div class="slide">
                                                <a href="img/img_12.jpg" class="img_box" data-fancybox="card_2" data-imageurl = "img/img_12.jpg">
                                                    <img src="#" alt="" />
                                                </a>
                                            </div>
                                            <div class="slide">
                                                <a href="img/img_05.jpg" class="img_box" data-fancybox="card_2" data-imageurl = "img/img_05.jpg">
                                                    <img src="#" alt="" />
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="object_thumb_descript">
                                        <div class="p_info red_p">
                                            <p>Комиссия: 100%</p>
                                        </div>
                                        <a href="#" class="object_card_title">Бизнес-центр Арена Сити Плаза, в два ряда название</a>
                                        <div class="two_cols_2">
                                            <div class="two_cols_2_col">
                                                <div class="adres">
                                                    <h5>г. Киев, Шевченковский р-н</h5>
                                                    <p>ул. Льва Толстого, 57</p>
                                                </div>
                                                <div class="metro_wrapp">
                                                    <p><i class="metro"></i>Театральная <span class="about">~</span> 900 м</p>
                                                </div>
                                            </div>
                                            <div class="two_cols_2_col">
                                                <div class="office_cont_wrapp">
                                                    <div class="office_cont">
                                                        <div class="col">
                                                            <i class="room_2"></i>
                                                        </div>
                                                        <div class="col">
                                                            <h5>24</h5>
                                                        </div>
                                                    </div>
                                                    <p>офисов</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="thumb_5_footer">
                                            <div class="thumb_5_footer_col">
                                                <p>от 30 м²…303 м²</p>
                                            </div>
                                            <div class="thumb_5_footer_col">
                                                <p>50 000 грн/мес</p>
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
                                                <p>$/м²</p>
                                            </div>
                                            <div class="table_cell">
                                                <p>all in/мес</p>
                                            </div>
                                            <div class="table_cell">
                                            </div>
                                        </div>
                                        <div class="table_row">
                                            <div class="table_cell">
                                                <p>90</p>
                                            </div>
                                            <div class="table_cell">
                                                <p>968 <span class="pluses">++</span></p>
                                            </div>
                                            <div class="table_cell">
                                                <p>140567</p>
                                            </div>
                                            <div class="table_cell">
                                            </div>
                                        </div>
                                        <div class="table_row">
                                            <div class="table_cell">
                                                <p>347</p>
                                            </div>
                                            <div class="table_cell">
                                                <p>1968 <span class="pluses">++</span></p>
                                            </div>
                                            <div class="table_cell">
                                                <p>140567</p>
                                            </div>
                                            <div class="table_cell">
                                                <a href="#" class="icon_link_2" data-photogallerylink = "31"><i class="photo"></i></a>
                                                <div class="images_paths_array" data-photogalleryindex = "31">
                                                    <span data-imagepath="img/img_11.jpg"></span>
                                                    <span data-imagepath="img/img_12.jpg"></span>
                                                    <span data-imagepath="img/img_05.jpg"></span>
                                                </div>
                                                <a href="#" class="icon_link_2"><i class="star_2"></i></a>
                                            </div>
                                        </div>
                                        <div class="table_row">
                                            <div class="table_cell">
                                                <p>1334</p>
                                            </div>
                                            <div class="table_cell">
                                                <p>968 <span class="pluses">++</span></p>
                                            </div>
                                            <div class="table_cell">
                                                <p>140567</p>
                                            </div>
                                            <div class="table_cell">
                                                <a href="#" class="icon_link_2" data-photogallerylink = "41"><i class="photo"></i></a>
                                                <div class="images_paths_array" data-photogalleryindex = "41">
                                                    <span data-imagepath="img/img_11.jpg"></span>
                                                    <span data-imagepath="img/img_12.jpg"></span>
                                                    <span data-imagepath="img/img_05.jpg"></span>
                                                </div>
                                                <a href="#" class="icon_link_2"><i class="star_2"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="object_card">
                            <div class="border_wrapp">
                                <div class="inner_wrapp">
                                    <div class="object_slider_wrapp">
                                        <div class="object_slider_header">
                                            <div class="inline">
                                                <div class="cl_pill">
                                                    <p>Класс A</p>
                                                </div>
                                            </div>
                                            <div class="inline">
                                                <div class="black_circle_2">
                                                    <i class="star_icon_2"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="object_slider">
                                            <div class="slide">
                                                <a href="img/img_11.jpg" class="img_box" data-fancybox="card_3" data-imageurl = "img/img_11.jpg">
                                                    <img src="#" alt="" />
                                                </a>
                                            </div>
                                            <div class="slide">
                                                <a href="img/img_12.jpg" class="img_box" data-fancybox="card_3" data-imageurl = "img/img_12.jpg">
                                                    <img src="#" alt="" />
                                                </a>
                                            </div>
                                            <div class="slide">
                                                <a href="img/img_05.jpg" class="img_box" data-fancybox="card_3" data-imageurl = "img/img_05.jpg">
                                                    <img src="#" alt="" />
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="object_thumb_descript">
                                        <div class="p_info red_p">
                                            <p>Комиссия: 100%</p>
                                        </div>
                                        <a href="#" class="object_card_title">Бизнес-центр Арена Сити Плаза, в два ряда название</a>
                                        <div class="two_cols_2">
                                            <div class="two_cols_2_col">
                                                <div class="adres">
                                                    <h5>г. Киев, Шевченковский р-н</h5>
                                                    <p>ул. Льва Толстого, 57</p>
                                                </div>
                                                <div class="metro_wrapp">
                                                    <p><i class="metro"></i>Театральная <span class="about">~</span> 900 м</p>
                                                </div>
                                            </div>
                                            <div class="two_cols_2_col">
                                                <div class="office_cont_wrapp">
                                                    <div class="office_cont">
                                                        <div class="col">
                                                            <i class="room_2"></i>
                                                        </div>
                                                        <div class="col">
                                                            <h5>24</h5>
                                                        </div>
                                                    </div>
                                                    <p>офисов</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="thumb_5_footer">
                                            <div class="thumb_5_footer_col">
                                                <p>от 30 м²…303 м²</p>
                                            </div>
                                            <div class="thumb_5_footer_col">
                                                <p>50 000 грн/мес</p>
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
                                                <p>$/м²</p>
                                            </div>
                                            <div class="table_cell">
                                                <p>all in/мес</p>
                                            </div>
                                            <div class="table_cell">
                                            </div>
                                        </div>
                                        <div class="table_row">
                                            <div class="table_cell">
                                                <p>90</p>
                                            </div>
                                            <div class="table_cell">
                                                <p>968 <span class="pluses">++</span></p>
                                            </div>
                                            <div class="table_cell">
                                                <p>140567</p>
                                            </div>
                                            <div class="table_cell">
                                            </div>
                                        </div>
                                        <div class="table_row">
                                            <div class="table_cell">
                                                <p>347</p>
                                            </div>
                                            <div class="table_cell">
                                                <p>1968 <span class="pluses">++</span></p>
                                            </div>
                                            <div class="table_cell">
                                                <p>140567</p>
                                            </div>
                                            <div class="table_cell">
                                                <a href="#" class="icon_link_2" data-photogallerylink = "51"><i class="photo"></i></a>
                                                <div class="images_paths_array" data-photogalleryindex = "51">
                                                    <span data-imagepath="img/img_11.jpg"></span>
                                                    <span data-imagepath="img/img_12.jpg"></span>
                                                    <span data-imagepath="img/img_05.jpg"></span>
                                                </div>
                                                <a href="#" class="icon_link_2"><i class="star_2"></i></a>
                                            </div>
                                        </div>
                                        <div class="table_row">
                                            <div class="table_cell">
                                                <p>1334</p>
                                            </div>
                                            <div class="table_cell">
                                                <p>968 <span class="pluses">++</span></p>
                                            </div>
                                            <div class="table_cell">
                                                <p>140567</p>
                                            </div>
                                            <div class="table_cell">
                                                <a href="#" class="icon_link_2" data-photogallerylink = "61"><i class="photo"></i></a>
                                                <div class="images_paths_array" data-photogalleryindex = "61">
                                                    <span data-imagepath="img/img_11.jpg"></span>
                                                    <span data-imagepath="img/img_12.jpg"></span>
                                                    <span data-imagepath="img/img_05.jpg"></span>
                                                </div>
                                                <a href="#" class="icon_link_2"><i class="star_2"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="object_card">
                            <div class="border_wrapp">
                                <div class="inner_wrapp">
                                    <div class="object_slider_wrapp">
                                        <div class="object_slider_header">
                                            <div class="inline">
                                                <div class="cl_pill">
                                                    <p>Класс A</p>
                                                </div>
                                            </div>
                                            <div class="inline">
                                                <div class="black_circle_2">
                                                    <i class="star_icon_2"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="object_slider">
                                            <div class="slide">
                                                <a href="img/img_11.jpg" class="img_box" data-fancybox="card_4" data-imageurl = "img/img_11.jpg">
                                                    <img src="#" alt="" />
                                                </a>
                                            </div>
                                            <div class="slide">
                                                <a href="img/img_12.jpg" class="img_box" data-fancybox="card_4" data-imageurl = "img/img_12.jpg">
                                                    <img src="#" alt="" />
                                                </a>
                                            </div>
                                            <div class="slide">
                                                <a href="img/img_05.jpg" class="img_box" data-fancybox="card_4" data-imageurl = "img/img_05.jpg">
                                                    <img src="#" alt="" />
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="object_thumb_descript">
                                        <div class="p_info red_p">
                                            <p>Комиссия: 100%</p>
                                        </div>
                                        <a href="#" class="object_card_title">Бизнес-центр Арена Сити Плаза, в два ряда название</a>
                                        <div class="two_cols_2">
                                            <div class="two_cols_2_col">
                                                <div class="adres">
                                                    <h5>г. Киев, Шевченковский р-н</h5>
                                                    <p>ул. Льва Толстого, 57</p>
                                                </div>
                                                <div class="metro_wrapp">
                                                    <p><i class="metro"></i>Театральная <span class="about">~</span> 900 м</p>
                                                </div>
                                            </div>
                                            <div class="two_cols_2_col">
                                                <div class="office_cont_wrapp">
                                                    <div class="office_cont">
                                                        <div class="col">
                                                            <i class="room_2"></i>
                                                        </div>
                                                        <div class="col">
                                                            <h5>24</h5>
                                                        </div>
                                                    </div>
                                                    <p>офисов</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="thumb_5_footer">
                                            <div class="thumb_5_footer_col">
                                                <p>от 30 м²…303 м²</p>
                                            </div>
                                            <div class="thumb_5_footer_col">
                                                <p>50 000 грн/мес</p>
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
                                                <p>$/м²</p>
                                            </div>
                                            <div class="table_cell">
                                                <p>all in/мес</p>
                                            </div>
                                            <div class="table_cell">
                                            </div>
                                        </div>
                                        <div class="table_row">
                                            <div class="table_cell">
                                                <p>90</p>
                                            </div>
                                            <div class="table_cell">
                                                <p>968 <span class="pluses">++</span></p>
                                            </div>
                                            <div class="table_cell">
                                                <p>140567</p>
                                            </div>
                                            <div class="table_cell">
                                            </div>
                                        </div>
                                        <div class="table_row">
                                            <div class="table_cell">
                                                <p>347</p>
                                            </div>
                                            <div class="table_cell">
                                                <p>1968 <span class="pluses">++</span></p>
                                            </div>
                                            <div class="table_cell">
                                                <p>140567</p>
                                            </div>
                                            <div class="table_cell">
                                                <a href="#" class="icon_link_2" data-photogallerylink = "71"><i class="photo"></i></a>
                                                <div class="images_paths_array" data-photogalleryindex = "71">
                                                    <span data-imagepath="img/img_11.jpg"></span>
                                                    <span data-imagepath="img/img_12.jpg"></span>
                                                    <span data-imagepath="img/img_05.jpg"></span>
                                                </div>
                                                <a href="#" class="icon_link_2"><i class="star_2"></i></a>
                                            </div>
                                        </div>
                                        <div class="table_row">
                                            <div class="table_cell">
                                                <p>1334</p>
                                            </div>
                                            <div class="table_cell">
                                                <p>968 <span class="pluses">++</span></p>
                                            </div>
                                            <div class="table_cell">
                                                <p>140567</p>
                                            </div>
                                            <div class="table_cell">
                                                <a href="#" class="icon_link_2" data-photogallerylink = "81"><i class="photo"></i></a>
                                                <div class="images_paths_array" data-photogalleryindex = "81">
                                                    <span data-imagepath="img/img_11.jpg"></span>
                                                    <span data-imagepath="img/img_12.jpg"></span>
                                                    <span data-imagepath="img/img_05.jpg"></span>
                                                </div>
                                                <a href="#" class="icon_link_2"><i class="star_2"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="two_cols_templ_wrapp two_cols_templ_wrapp_2 white_bg">
                <div class="row">
                    <div class="w_half">
                        <div class="two_cols_templ clearfix">
                            <div class="left">
                                <div class="descript_box">
                                    <div class="title_wrapp title_wrapp_2 clearfix">
                                        <h2>Эксперты <span class="text_logo">a<span class="green">l</span><span class="blue">l</span>bc</span> <span class="city">Киев</span></h2>
                                    </div>
                                    <div class="text">
                                        <p>allbc.info - Наши сотрудники самые умные, самые лучшие, самые красивые. Мы любим наших сотрудников. В любое время ответим на Ваши вопросы.</p>
                                    </div>
                                    <div class="pill_wrapp hide_900">
                                        <a href="#" class="green_pill">Подобрать офис</a>
                                    </div>
                                </div>
                            </div>
                            <div class="right">
                                <div class="slider_2_wrapp">
                                    <div class="slider_2">
                                        <div class="slide">
                                            <div class="thunb_4">
                                                <div class="img_box">
                                                    <img src="img/david-krane.jpg" alt="" />
                                                </div>
                                                <h3>David Krane</h3>
                                            </div>
                                        </div>
                                        <div class="slide">
                                            <div class="thunb_4">
                                                <div class="img_box">
                                                    <img src="img/david-krane.jpg" alt="" />
                                                </div>
                                                <h3>David Krane</h3>
                                            </div>
                                        </div>
                                        <div class="slide">
                                            <div class="thunb_4">
                                                <div class="img_box">
                                                    <img src="img/david-krane.jpg" alt="" />
                                                </div>
                                                <h3>David Krane</h3>
                                            </div>
                                        </div>
                                        <div class="slide">
                                            <div class="thunb_4">
                                                <div class="img_box">
                                                    <img src="img/david-krane.jpg" alt="" />
                                                </div>
                                                <h3>David Krane</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="align_center pill_wrapp visible_900">
                            <a href="#" class="green_pill">Подобрать офис</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="w_half">
                    <div class="objects_catalog objects_cards">
                        <div class="object_card">
                            <div class="border_wrapp">
                                <div class="inner_wrapp">
                                    <div class="object_slider_wrapp">
                                        <div class="object_slider_header">
                                            <div class="inline">
                                                <div class="cl_pill">
                                                    <p>Класс A</p>
                                                </div>
                                            </div>
                                            <div class="inline">
                                                <div class="black_circle_2">
                                                    <i class="star_icon_2"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="object_slider">
                                            <div class="slide">
                                                <a href="img/img_11.jpg" class="img_box" data-fancybox="card_5" data-imageurl = "img/img_11.jpg">
                                                    <img src="#" alt="" />
                                                </a>
                                            </div>
                                            <div class="slide">
                                                <a href="img/img_12.jpg" class="img_box" data-fancybox="card_5" data-imageurl = "img/img_12.jpg">
                                                    <img src="#" alt="" />
                                                </a>
                                            </div>
                                            <div class="slide">
                                                <a href="img/img_05.jpg" class="img_box" data-fancybox="card_5" data-imageurl = "img/img_05.jpg">
                                                    <img src="#" alt="" />
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="object_thumb_descript">
                                        <div class="p_info red_p">
                                            <p>Комиссия: 100%</p>
                                        </div>
                                        <a href="#" class="object_card_title">Бизнес-центр Арена Сити Плаза, в два ряда название</a>
                                        <div class="two_cols_2">
                                            <div class="two_cols_2_col">
                                                <div class="adres">
                                                    <h5>г. Киев, Шевченковский р-н</h5>
                                                    <p>ул. Льва Толстого, 57</p>
                                                </div>
                                                <div class="metro_wrapp">
                                                    <p><i class="metro"></i>Театральная <span class="about">~</span> 900 м</p>
                                                </div>
                                            </div>
                                            <div class="two_cols_2_col">
                                                <div class="office_cont_wrapp">
                                                    <div class="office_cont">
                                                        <div class="col">
                                                            <i class="room_2"></i>
                                                        </div>
                                                        <div class="col">
                                                            <h5>24</h5>
                                                        </div>
                                                    </div>
                                                    <p>офисов</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="thumb_5_footer">
                                            <div class="thumb_5_footer_col">
                                                <p>от 30 м²…303 м²</p>
                                            </div>
                                            <div class="thumb_5_footer_col">
                                                <p>50 000 грн/мес</p>
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
                                                <p>$/м²</p>
                                            </div>
                                            <div class="table_cell">
                                                <p>all in/мес</p>
                                            </div>
                                            <div class="table_cell">
                                            </div>
                                        </div>
                                        <div class="table_row">
                                            <div class="table_cell">
                                                <p>90</p>
                                            </div>
                                            <div class="table_cell">
                                                <p>968 <span class="pluses">++</span></p>
                                            </div>
                                            <div class="table_cell">
                                                <p>140567</p>
                                            </div>
                                            <div class="table_cell">
                                            </div>
                                        </div>
                                        <div class="table_row">
                                            <div class="table_cell">
                                                <p>347</p>
                                            </div>
                                            <div class="table_cell">
                                                <p>1968 <span class="pluses">++</span></p>
                                            </div>
                                            <div class="table_cell">
                                                <p>140567</p>
                                            </div>
                                            <div class="table_cell">
                                                <a href="#" class="icon_link_2" data-photogallerylink = "10"><i class="photo"></i></a>
                                                <div class="images_paths_array" data-photogalleryindex = "10">
                                                    <span data-imagepath="img/img_11.jpg"></span>
                                                    <span data-imagepath="img/img_12.jpg"></span>
                                                    <span data-imagepath="img/img_05.jpg"></span>
                                                </div>
                                                <a href="#" class="icon_link_2"><i class="star_2"></i></a>
                                            </div>
                                        </div>
                                        <div class="table_row">
                                            <div class="table_cell">
                                                <p>1334</p>
                                            </div>
                                            <div class="table_cell">
                                                <p>968 <span class="pluses">++</span></p>
                                            </div>
                                            <div class="table_cell">
                                                <p>140567</p>
                                            </div>
                                            <div class="table_cell">
                                                <a href="#" class="icon_link_2" data-photogallerylink = "11"><i class="photo"></i></a>
                                                <div class="images_paths_array" data-photogalleryindex = "11">
                                                    <span data-imagepath="img/img_11.jpg"></span>
                                                    <span data-imagepath="img/img_12.jpg"></span>
                                                    <span data-imagepath="img/img_05.jpg"></span>
                                                </div>
                                                <a href="#" class="icon_link_2"><i class="star_2"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="object_card">
                            <div class="border_wrapp">
                                <div class="inner_wrapp">
                                    <div class="object_slider_wrapp">
                                        <div class="object_slider_header">
                                            <div class="inline">
                                                <div class="cl_pill">
                                                    <p>Класс A</p>
                                                </div>
                                            </div>
                                            <div class="inline">
                                                <div class="black_circle_2">
                                                    <i class="star_icon_2"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="object_slider">
                                            <div class="slide">
                                                <a href="img/img_11.jpg" class="img_box" data-fancybox="card_6" data-imageurl = "img/img_11.jpg">
                                                    <img src="#" alt="" />
                                                </a>
                                            </div>
                                            <div class="slide">
                                                <a href="img/img_12.jpg" class="img_box" data-fancybox="card_6" data-imageurl = "img/img_12.jpg">
                                                    <img src="#" alt="" />
                                                </a>
                                            </div>
                                            <div class="slide">
                                                <a href="img/img_05.jpg" class="img_box" data-fancybox="card_6" data-imageurl = "img/img_05.jpg">
                                                    <img src="#" alt="" />
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="object_thumb_descript">
                                        <div class="p_info red_p">
                                            <p>Комиссия: 100%</p>
                                        </div>
                                        <a href="#" class="object_card_title">Бизнес-центр Арена Сити Плаза, в два ряда название</a>
                                        <div class="two_cols_2">
                                            <div class="two_cols_2_col">
                                                <div class="adres">
                                                    <h5>г. Киев, Шевченковский р-н</h5>
                                                    <p>ул. Льва Толстого, 57</p>
                                                </div>
                                                <div class="metro_wrapp">
                                                    <p><i class="metro"></i>Театральная <span class="about">~</span> 900 м</p>
                                                </div>
                                            </div>
                                            <div class="two_cols_2_col">
                                                <div class="office_cont_wrapp">
                                                    <div class="office_cont">
                                                        <div class="col">
                                                            <i class="room_2"></i>
                                                        </div>
                                                        <div class="col">
                                                            <h5>24</h5>
                                                        </div>
                                                    </div>
                                                    <p>офисов</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="thumb_5_footer">
                                            <div class="thumb_5_footer_col">
                                                <p>от 30 м²…303 м²</p>
                                            </div>
                                            <div class="thumb_5_footer_col">
                                                <p>50 000 грн/мес</p>
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
                                                <p>$/м²</p>
                                            </div>
                                            <div class="table_cell">
                                                <p>all in/мес</p>
                                            </div>
                                            <div class="table_cell">
                                            </div>
                                        </div>
                                        <div class="table_row">
                                            <div class="table_cell">
                                                <p>90</p>
                                            </div>
                                            <div class="table_cell">
                                                <p>968 <span class="pluses">++</span></p>
                                            </div>
                                            <div class="table_cell">
                                                <p>140567</p>
                                            </div>
                                            <div class="table_cell">
                                            </div>
                                        </div>
                                        <div class="table_row">
                                            <div class="table_cell">
                                                <p>347</p>
                                            </div>
                                            <div class="table_cell">
                                                <p>1968 <span class="pluses">++</span></p>
                                            </div>
                                            <div class="table_cell">
                                                <p>140567</p>
                                            </div>
                                            <div class="table_cell">
                                                <a href="#" class="icon_link_2" data-photogallerylink = "13"><i class="photo"></i></a>
                                                <div class="images_paths_array" data-photogalleryindex = "13">
                                                    <span data-imagepath="img/img_11.jpg"></span>
                                                    <span data-imagepath="img/img_12.jpg"></span>
                                                    <span data-imagepath="img/img_05.jpg"></span>
                                                </div>
                                                <a href="#" class="icon_link_2"><i class="star_2"></i></a>
                                            </div>
                                        </div>
                                        <div class="table_row">
                                            <div class="table_cell">
                                                <p>1334</p>
                                            </div>
                                            <div class="table_cell">
                                                <p>968 <span class="pluses">++</span></p>
                                            </div>
                                            <div class="table_cell">
                                                <p>140567</p>
                                            </div>
                                            <div class="table_cell">
                                                <a href="#" class="icon_link_2" data-photogallerylink = "14"><i class="photo"></i></a>
                                                <div class="images_paths_array" data-photogalleryindex = "14">
                                                    <span data-imagepath="img/img_11.jpg"></span>
                                                    <span data-imagepath="img/img_12.jpg"></span>
                                                    <span data-imagepath="img/img_05.jpg"></span>
                                                </div>
                                                <a href="#" class="icon_link_2"><i class="star_2"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="object_card">
                            <div class="border_wrapp">
                                <div class="inner_wrapp">
                                    <div class="object_slider_wrapp">
                                        <div class="object_slider_header">
                                            <div class="inline">
                                                <div class="cl_pill">
                                                    <p>Класс A</p>
                                                </div>
                                            </div>
                                            <div class="inline">
                                                <div class="black_circle_2">
                                                    <i class="star_icon_2"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="object_slider">
                                            <div class="slide">
                                                <a href="img/img_11.jpg" class="img_box" data-fancybox="card_7" data-imageurl = "img/img_11.jpg">
                                                    <img src="#" alt="" />
                                                </a>
                                            </div>
                                            <div class="slide">
                                                <a href="img/img_12.jpg" class="img_box" data-fancybox="card_7" data-imageurl = "img/img_12.jpg">
                                                    <img src="#" alt="" />
                                                </a>
                                            </div>
                                            <div class="slide">
                                                <a href="img/img_05.jpg" class="img_box" data-fancybox="card_7" data-imageurl = "img/img_05.jpg">
                                                    <img src="#" alt="" />
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="object_thumb_descript">
                                        <div class="p_info red_p">
                                            <p>Комиссия: 100%</p>
                                        </div>
                                        <a href="#" class="object_card_title">Бизнес-центр Арена Сити Плаза, в два ряда название</a>
                                        <div class="two_cols_2">
                                            <div class="two_cols_2_col">
                                                <div class="adres">
                                                    <h5>г. Киев, Шевченковский р-н</h5>
                                                    <p>ул. Льва Толстого, 57</p>
                                                </div>
                                                <div class="metro_wrapp">
                                                    <p><i class="metro"></i>Театральная <span class="about">~</span> 900 м</p>
                                                </div>
                                            </div>
                                            <div class="two_cols_2_col">
                                                <div class="office_cont_wrapp">
                                                    <div class="office_cont">
                                                        <div class="col">
                                                            <i class="room_2"></i>
                                                        </div>
                                                        <div class="col">
                                                            <h5>24</h5>
                                                        </div>
                                                    </div>
                                                    <p>офисов</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="thumb_5_footer">
                                            <div class="thumb_5_footer_col">
                                                <p>от 30 м²…303 м²</p>
                                            </div>
                                            <div class="thumb_5_footer_col">
                                                <p>50 000 грн/мес</p>
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
                                                <p>$/м²</p>
                                            </div>
                                            <div class="table_cell">
                                                <p>all in/мес</p>
                                            </div>
                                            <div class="table_cell">
                                            </div>
                                        </div>
                                        <div class="table_row">
                                            <div class="table_cell">
                                                <p>90</p>
                                            </div>
                                            <div class="table_cell">
                                                <p>968 <span class="pluses">++</span></p>
                                            </div>
                                            <div class="table_cell">
                                                <p>140567</p>
                                            </div>
                                            <div class="table_cell">
                                            </div>
                                        </div>
                                        <div class="table_row">
                                            <div class="table_cell">
                                                <p>347</p>
                                            </div>
                                            <div class="table_cell">
                                                <p>1968 <span class="pluses">++</span></p>
                                            </div>
                                            <div class="table_cell">
                                                <p>140567</p>
                                            </div>
                                            <div class="table_cell">
                                                <a href="#" class="icon_link_2" data-photogallerylink = "15"><i class="photo"></i></a>
                                                <div class="images_paths_array" data-photogalleryindex = "15">
                                                    <span data-imagepath="img/img_11.jpg"></span>
                                                    <span data-imagepath="img/img_12.jpg"></span>
                                                    <span data-imagepath="img/img_05.jpg"></span>
                                                </div>
                                                <a href="#" class="icon_link_2"><i class="star_2"></i></a>
                                            </div>
                                        </div>
                                        <div class="table_row">
                                            <div class="table_cell">
                                                <p>1334</p>
                                            </div>
                                            <div class="table_cell">
                                                <p>968 <span class="pluses">++</span></p>
                                            </div>
                                            <div class="table_cell">
                                                <p>140567</p>
                                            </div>
                                            <div class="table_cell">
                                                <a href="#" class="icon_link_2" data-photogallerylink = "16"><i class="photo"></i></a>
                                                <div class="images_paths_array" data-photogalleryindex = "16">
                                                    <span data-imagepath="img/img_11.jpg"></span>
                                                    <span data-imagepath="img/img_12.jpg"></span>
                                                    <span data-imagepath="img/img_05.jpg"></span>
                                                </div>
                                                <a href="#" class="icon_link_2"><i class="star_2"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="object_card">
                            <div class="border_wrapp">
                                <div class="inner_wrapp">
                                    <div class="object_slider_wrapp">
                                        <div class="object_slider_header">
                                            <div class="inline">
                                                <div class="cl_pill">
                                                    <p>Класс A</p>
                                                </div>
                                            </div>
                                            <div class="inline">
                                                <div class="black_circle_2">
                                                    <i class="star_icon_2"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="object_slider">
                                            <div class="slide">
                                                <a href="img/img_11.jpg" class="img_box" data-fancybox="card_8" data-imageurl = "img/img_11.jpg">
                                                    <img src="#" alt="" />
                                                </a>
                                            </div>
                                            <div class="slide">
                                                <a href="img/img_12.jpg" class="img_box" data-fancybox="card_8" data-imageurl = "img/img_12.jpg">
                                                    <img src="#" alt="" />
                                                </a>
                                            </div>
                                            <div class="slide">
                                                <a href="img/img_05.jpg" class="img_box" data-fancybox="card_8" data-imageurl = "img/img_05.jpg">
                                                    <img src="#" alt="" />
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="object_thumb_descript">
                                        <div class="p_info red_p">
                                            <p>Комиссия: 100%</p>
                                        </div>
                                        <a href="#" class="object_card_title">Бизнес-центр Арена Сити Плаза, в два ряда название</a>
                                        <div class="two_cols_2">
                                            <div class="two_cols_2_col">
                                                <div class="adres">
                                                    <h5>г. Киев, Шевченковский р-н</h5>
                                                    <p>ул. Льва Толстого, 57</p>
                                                </div>
                                                <div class="metro_wrapp">
                                                    <p><i class="metro"></i>Театральная <span class="about">~</span> 900 м</p>
                                                </div>
                                            </div>
                                            <div class="two_cols_2_col">
                                                <div class="office_cont_wrapp">
                                                    <div class="office_cont">
                                                        <div class="col">
                                                            <i class="room_2"></i>
                                                        </div>
                                                        <div class="col">
                                                            <h5>24</h5>
                                                        </div>
                                                    </div>
                                                    <p>офисов</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="thumb_5_footer">
                                            <div class="thumb_5_footer_col">
                                                <p>от 30 м²…303 м²</p>
                                            </div>
                                            <div class="thumb_5_footer_col">
                                                <p>50 000 грн/мес</p>
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
                                                <p>$/м²</p>
                                            </div>
                                            <div class="table_cell">
                                                <p>all in/мес</p>
                                            </div>
                                            <div class="table_cell">
                                            </div>
                                        </div>
                                        <div class="table_row">
                                            <div class="table_cell">
                                                <p>90</p>
                                            </div>
                                            <div class="table_cell">
                                                <p>968 <span class="pluses">++</span></p>
                                            </div>
                                            <div class="table_cell">
                                                <p>140567</p>
                                            </div>
                                            <div class="table_cell">
                                            </div>
                                        </div>
                                        <div class="table_row">
                                            <div class="table_cell">
                                                <p>347</p>
                                            </div>
                                            <div class="table_cell">
                                                <p>1968 <span class="pluses">++</span></p>
                                            </div>
                                            <div class="table_cell">
                                                <p>140567</p>
                                            </div>
                                            <div class="table_cell">
                                                <a href="#" class="icon_link_2" data-photogallerylink = "17"><i class="photo"></i></a>
                                                <div class="images_paths_array" data-photogalleryindex = "17">
                                                    <span data-imagepath="img/img_11.jpg"></span>
                                                    <span data-imagepath="img/img_12.jpg"></span>
                                                    <span data-imagepath="img/img_05.jpg"></span>
                                                </div>
                                                <a href="#" class="icon_link_2"><i class="star_2"></i></a>
                                            </div>
                                        </div>
                                        <div class="table_row">
                                            <div class="table_cell">
                                                <p>1334</p>
                                            </div>
                                            <div class="table_cell">
                                                <p>968 <span class="pluses">++</span></p>
                                            </div>
                                            <div class="table_cell">
                                                <p>140567</p>
                                            </div>
                                            <div class="table_cell">
                                                <a href="#" class="icon_link_2" data-photogallerylink = "18"><i class="photo"></i></a>
                                                <div class="images_paths_array" data-photogalleryindex = "18">
                                                    <span data-imagepath="img/img_11.jpg"></span>
                                                    <span data-imagepath="img/img_12.jpg"></span>
                                                    <span data-imagepath="img/img_05.jpg"></span>
                                                </div>
                                                <a href="#" class="icon_link_2"><i class="star_2"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <ul class="pagination">
                        <li class="prev_page disable"><a href="#" class="prev_arrow"><span>Предыдущая</span></a></li>
                        <li><a href="#" class="active">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">5</a></li>
                        <li class="offset">...</li>
                        <li><a href="#">15,440</a></li>
                        <li class="next_page"><a href="#" class="next_arrow"><span>Следующая</span></a></li>
                    </ul>
                </div>
            </div>
            <div class="append-elem" data-append-desktop-elem = "map_index" data-min-screen = "1024">
                <div class="object_map">
                    <div class="map_scroll">
                        <div class="map_search_wrapp">
                            <div class="map_search checkbox">
                                <input type="checkbox" name="mach_ch" id="map_ch" />
                                <label for="map_ch">Поиск при перемещении на карте</label>
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

<section class="sect_2_info_side">
    <div class="row">
        <div class="text_box" id="slide_tags" data-minheight="175">
            <div class="inner_height">
                <div class="tags_slidedown tags_slidedown_2">
                    <a class="tag active" href="#">Аренда офиса в Киеве без посредников<span class="count">13</span></a>
                    <a class="tag" href="#">Снять офис в Киеве без посредников<span class="count">25</span></a>
                    <a class="tag" href="#">Снять офис в Киеве<span class="count">25</span></a>
                    <a class="tag" href="#">Аренда офиса в центре Киеве<span class="count">25</span></a>
                    <a class="tag" href="#">Аренда офиса в Оболонском районе<span class="count">14</span></a>
                    <a class="tag" href="#">Аренда офиса в Подольском районе<span class="count">14</span></a>
                    <a class="tag" href="#">Аренда помещения под офис в Киеве<span class="count">14</span></a>
                    <a class="tag" href="#">Аренда офиса в Дарницком районе<span class="count">25</span></a>
                    <a class="tag" href="#">Снять офис в Киеве без посредников<span class="count">25</span></a>
                    <a class="tag" href="#">Снять офис в Киеве<span class="count">25</span></a>
                    <a class="tag" href="#">Аренда офиса в центре Киеве<span class="count">25</span></a>
                    <a class="tag" href="#">Аренда офиса в Оболонском районе<span class="count">14</span></a>
                    <a class="tag" href="#">Аренда офиса в Подольском районе<span class="count">14</span></a>
                    <a class="tag" href="#">Аренда помещения под офис в Киеве<span class="count">14</span></a>
                    <a class="tag" href="#">Аренда офиса в Дарницком районе<span class="count">25</span></a>
                </div>
            </div>
        </div>
        <div class="showmore_wrapp">
            <a href="#" class="green_link show_text" data-slidebox-id = "slide_tags"><i class="plus"></i><span class="show">Показать больше</span><span class="hide">Свернуть</span></a>
        </div>
    </div>
</section>

<section class="sect_3_info_side">
    <div class="row">
        <h2>Статистика по районам</h2>
        <div class="table_slider_wrapp">
            <div class="table_slider_controls"></div>
            <div class="table_slider">
                <div class="slide">
                    <div class="overflow_y">
                        <div class="static_table">
                            <div class="table_row">
                                <div class="table_cell">
                                    <h4>Район</h4>
                                </div>
                                <div class="table_cell">
                                    <h4>Средняя аренда м<span class="sq">2</span></h4>
                                </div>
                                <div class="table_cell">
                                    <h4>Кол-во предложений</h4>
                                </div>
                                <div class="table_cell">
                                    <h4>Вакантность</h4>
                                </div>
                            </div>
                            <div class="table_row">
                                <div class="table_cell">
                                    <p><a href="#" class="green_link_2">Деснянский р-н</a></p>
                                </div>
                                <div class="table_cell">
                                    <p>300 грн/м<span class="sq">2</span></p>
                                </div>
                                <div class="table_cell">
                                    <p>56</p>
                                </div>
                                <div class="table_cell">
                                    <p>20%</p>
                                </div>
                            </div>
                            <div class="table_row">
                                <div class="table_cell">
                                    <p><a href="#" class="green_link_2">Деснянский р-н</a></p>
                                </div>
                                <div class="table_cell">
                                    <p>300 грн/м<span class="sq">2</span></p>
                                </div>
                                <div class="table_cell">
                                    <p>56</p>
                                </div>
                                <div class="table_cell">
                                    <p>20%</p>
                                </div>
                            </div>
                            <div class="table_row">
                                <div class="table_cell">
                                    <p><a href="#" class="green_link_2">Деснянский р-н</a></p>
                                </div>
                                <div class="table_cell">
                                    <p>300 грн/м<span class="sq">2</span></p>
                                </div>
                                <div class="table_cell">
                                    <p>56</p>
                                </div>
                                <div class="table_cell">
                                    <p>20%</p>
                                </div>
                            </div>
                            <div class="table_row">
                                <div class="table_cell">
                                    <p><a href="#" class="green_link_2">Деснянский р-н</a></p>
                                </div>
                                <div class="table_cell">
                                    <p>300 грн/м<span class="sq">2</span></p>
                                </div>
                                <div class="table_cell">
                                    <p>56</p>
                                </div>
                                <div class="table_cell">
                                    <p>20%</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="slide">
                    <div class="overflow_y">
                        <div class="static_table">
                            <div class="table_row">
                                <div class="table_cell">
                                    <h4>Район 2</h4>
                                </div>
                                <div class="table_cell">
                                    <h4>Средняя аренда м<span class="sq">2</span></h4>
                                </div>
                                <div class="table_cell">
                                    <h4>Кол-во предложений</h4>
                                </div>
                                <div class="table_cell">
                                    <h4>Вакантность</h4>
                                </div>
                            </div>
                            <div class="table_row">
                                <div class="table_cell">
                                    <p><a href="#" class="green_link_2">Деснянский р-н</a></p>
                                </div>
                                <div class="table_cell">
                                    <p>300 грн/м<span class="sq">2</span></p>
                                </div>
                                <div class="table_cell">
                                    <p>56</p>
                                </div>
                                <div class="table_cell">
                                    <p>20%</p>
                                </div>
                            </div>
                            <div class="table_row">
                                <div class="table_cell">
                                    <p><a href="#" class="green_link_2">Деснянский р-н</a></p>
                                </div>
                                <div class="table_cell">
                                    <p>300 грн/м<span class="sq">2</span></p>
                                </div>
                                <div class="table_cell">
                                    <p>56</p>
                                </div>
                                <div class="table_cell">
                                    <p>20%</p>
                                </div>
                            </div>
                            <div class="table_row">
                                <div class="table_cell">
                                    <p><a href="#" class="green_link_2">Деснянский р-н</a></p>
                                </div>
                                <div class="table_cell">
                                    <p>300 грн/м<span class="sq">2</span></p>
                                </div>
                                <div class="table_cell">
                                    <p>56</p>
                                </div>
                                <div class="table_cell">
                                    <p>20%</p>
                                </div>
                            </div>
                            <div class="table_row">
                                <div class="table_cell">
                                    <p><a href="#" class="green_link_2">Деснянский р-н</a></p>
                                </div>
                                <div class="table_cell">
                                    <p>300 грн/м<span class="sq">2</span></p>
                                </div>
                                <div class="table_cell">
                                    <p>56</p>
                                </div>
                                <div class="table_cell">
                                    <p>20%</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="thumbnails_3_wrapp">
            <h2>Дополнительные услуги</h2>
            <div class="thumbnails_3 offset_ziro">
                <a href="#" class="thumb_3">
                    <img src="img/img_05.jpg" alt="" />
                    <div class="descript">
                        <h3>Дизайн и рассадка</h3>
                    </div>
                </a>
                <a href="#" class="thumb_3">
                    <img src="img/img_02.jpg" alt="" />
                    <div class="descript">
                        <h3>Ремонт и отделка</h3>
                    </div>
                </a>
                <a href="#" class="thumb_3">
                    <img src="img/img_09.jpg" alt="" />
                    <div class="descript">
                        <h3>Мебель в ваш офис </h3>
                    </div>
                </a>
                <a href="#" class="thumb_3">
                    <img src="img/img_01.jpg" alt="" />
                    <div class="descript">
                        <h3>Услуги перевозчиков</h3>
                    </div>
                </a>
                <a href="#" class="thumb_3">
                    <img src="img/img_08.jpg" alt="" />
                    <div class="descript">
                        <h3>Уборка и клининг</h3>
                    </div>
                </a>
                <a href="#" class="thumb_3">
                    <img src="img/img_07.jpg" alt="" />
                    <div class="descript">
                        <h3>Еда и вода</h3>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<section class="sect_7_2">
    <div class="row">
        <h2>О нас</h2>
        <div class="text_box" id="slide_text" data-minheight="142">
            <div class="inner_height">
                <p>allbc.info -  готовое решение поиска офиса,- мы знаем все обо всех! На сайте отображена вся информация, необходимая для принятия решения, об аренде офиса или его покупки, дальше только осмотр и подписание Договора. Задайте требуемые параметры поиска и просматривайте актуальную информацию про каждый объект: фото, цены, свободные офисы, планировки и т.д. Добавляйте в избранное, сравнивайте по вашим ключевым потребностям, договаривайтесь с собственником на просмотр и подписывайте Договор без посредников. Однако, если вам нужна наша помощь, мы готовы подобрать вам подходящие предложения и договориться на осмотры выбранных офисов за фиксированную плату. Все наши сотрудники лично знакомы практически с каждым объектом и собственником, поэтому готовы предоставить вам исчерпывающую консультацию для принятия решения.</p>
                <p>allbc.info -  готовое решение поиска офиса,- мы знаем все обо всех! На сайте отображена вся информация, необходимая для принятия решения, об аренде офиса или его покупки, дальше только осмотр и подписание Договора. Задайте требуемые параметры поиска и просматривайте актуальную информацию про каждый объект: фото, цены, свободные офисы, планировки и т.д. Добавляйте в избранное, сравнивайте по вашим ключевым потребностям, договаривайтесь с собственником на просмотр и подписывайте Договор без посредников. Однако, если вам нужна наша помощь, мы готовы подобрать вам подходящие предложения и договориться на осмотры выбранных офисов за фиксированную плату. Все наши сотрудники лично знакомы практически с каждым объектом и собственником, поэтому готовы предоставить вам исчерпывающую консультацию для принятия решения.</p>
                <ol class="mark_list">
                    <li>Item 1</li>
                    <li>Item 2</li>
                    <li>Item 3</li>
                </ol>
                <ol class="number_list">
                    <li>Item 1</li>
                    <li>Item 2</li>
                    <li>Item 3</li>
                    <li>Item 1</li>
                    <li>Item 2</li>
                    <li>Item 3</li>
                    <li>Item 1</li>
                    <li>Item 2</li>
                    <li>Item 3</li>
                    <li>Item 1</li>
                    <li>Item 2</li>
                    <li>Item 3</li>
                </ol>
            </div>
        </div>
        <div class="showmore_wrapp">
            <a href="#" class="green_link show_text" data-slidebox-id = "slide_text"><i class="plus"></i><span class="show">Показать больше</span><span class="hide">Свернуть</span></a>
        </div>
    </div>
</section>

<section>
    <div class="row">
        <div class="breadcrumbs_wrapp">
            <ul class="breadcrumbs">
                <li><a href="#">Главная</a></li>
                <li><a href="#">Аренда офиса</a></li>
                <li><a href="#">Аренда офиса Киева</a></li>
            </ul>
        </div>
    </div>
</section>
