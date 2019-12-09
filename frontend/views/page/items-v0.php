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

    <?php //debug($items[0]); ?>

    <div id="map_box">
        <div class="mask"></div>
        <div class="map_object_header">
            <div class="row clearfix">
                <div class="left">
                    <div class="inlines_wrapp">
                        <div class="inline">
                            <h4><?= $seo->name ?></h4>
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
        <div class="append-elem" data-append-elem="map_index"></div>
        <div class="map_object_templ">
            <div class="row">
                <div class="w_half">
                    <div class="objects_cards">
                        <? //foreach ($items as $k => $item): ?>
                        <?  for ($i = 0; $i <= 3; $i++) { ?>
                            <div class="object_card">
                                <div class="border_wrapp">
                                    <div class="inner_wrapp">
                                        <div class="object_slider_wrapp">
                                            <div class="object_slider_header">
                                                <div class="inline">
                                                    <div class="cl_pill">
                                                        <p><?= $items[$i]->class->name ?></p>
                                                    </div>
                                                </div>
                                                <div class="inline">
                                                    <div class="black_circle_2">
                                                        <i class="star_icon_2"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="object_slider">
                                                <? foreach ($items[$i]->thumbs300x200 as $thumb): ?>
                                                    <div class="slide">
                                                        <a href="<?= $thumb ?>" class="img_box" data-fancybox="card_1" data-imageurl="<?= $thumb ?>"><img src="#" alt=""/></a>
                                                    </div>
                                                <? endforeach; ?>
                                            </div>
                                        </div>
                                        <div class="object_thumb_descript">
                                            <div class="p_info red_p">
                                                <p>Комиссия: 100%</p>
                                            </div>
                                            <a href="#" class="object_card_title"><?= $items[$i]->name ?></a>
                                            <div class="two_cols_2">
                                                <div class="adres">
                                                    <h5>г. Киев, Шевченковский р-н</h5>
                                                    <p>ул. Льва Толстого, 57</p>
                                                </div>
                                                <div class="metro_wrapp">
                                                    <p><i class="metro"></i>Театральная <span class="about">~</span> 900 м</p>
                                                </div>
                                            </div>
                                            <div class="thumb_5_footer">
                                                <div class="thumb_5_footer_col">
                                                    <p>площадь: 303 м²</p>
                                                </div>
                                                <div class="thumb_5_footer_col">
                                                    <p>цена: 968++ $/м²/mec</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <? } //endforeach; ?>
                    </div>
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
        <?= LinkPager::widget([
            'pagination' => $pages,
        ]); ?>
    </div>

        <div class="bottom_coord"></div>
</section>
