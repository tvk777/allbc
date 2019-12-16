<?php
use yii\helpers\Html;
use yii\widgets\Pjax;

if ($seo->target == 1) {
    $targetText = Yii::t('app', 'Rent');
    $rentSelected = 'selected';
    $saleSelected = '';
} else {
    $targetText = Yii::t('app', 'Sale');
    $saleSelected = 'selected';
    $rentSelected = '';
}
$defaultDist = 1000;
$defaultName = Yii::t('app', 'Subway');
$metroVal = $defaultDist;
$metroValclear = '';
if (!empty($filters['subways'])) {
    if (!empty($params['subway'])) {
        foreach ($filters['subways'] as $subway) {
            if ($subway->id == $params['subway']) {
                $metroId = $subway->id;
                $metroName = $subway->name;
            }
        }
    } else {
        $metroId = '';
        $metroName = $defaultName;
    }
    if (!empty($params['walk_dist'])) {
        $metroVal = $metroValclear = $params['walk_dist'];
    }
}
$this->registerJsVar('metroVal', $metroVal, $this::POS_HEAD);
$this->registerJsVar('defaultDist', $defaultDist, $this::POS_HEAD);
$this->registerJsVar('defaultName', $defaultName, $this::POS_HEAD);
$activeM2 = '';
if ((!empty($params['m2min']) && $params['m2min']!=$countValM2['min']) || (!empty($params['m2max']) && $params['m2max']!=$countValM2['max'])) {
    $activeM2 = 'green_active';
}
$minM2 = !empty($params['m2min']) ? $params['m2min'] : $countValM2['min'];
$maxM2 = !empty($params['m2max']) ? $params['m2max'] : $countValM2['max'];
$this->registerJsVar('maxM2', $maxM2, $this::POS_HEAD);
$this->registerJsVar('minM2', $minM2, $this::POS_HEAD);
$this->registerJsVar('maxTotal', $countValM2['max'], $this::POS_HEAD);

$currency = !empty($params['currency']) ? $params['currency'] : 1;
$type = !empty($params['type']) ? $params['type'] : 1;

$activePrice = '';
if($currency==2){
    $currencySymbol = '$';
} elseif ($currency==3){
    $currencySymbol = '€';
} else {
    $currencySymbol = '&#8372;';
}
if ($type == 3) {
    $minpricesChart = $pricesChart['type3']['min'];
    $maxpricesChart = $pricesChart['type3']['max'];
} else {
    $minpricesChart = $pricesChart['type1']['min'];
    $maxpricesChart = $pricesChart['type1']['max'];
}
$minPrice = !empty($params['pricemin']) ? $params['pricemin'] : round($minpricesChart/$rate);
$maxPrice = !empty($params['pricemax']) ? $params['pricemax'] : round($maxpricesChart/$rate);
$min_max = $currencySymbol.' '.$minPrice . ' - ' . $maxPrice;

$this->registerJsVar('maxPrice', $maxPrice, $this::POS_HEAD);
$this->registerJsVar('minPrice', $minPrice, $this::POS_HEAD);
$this->registerJsVar('maxTotalPrice', $pricesChart['type1']['max'], $this::POS_HEAD);

if ((!empty($params['pricemin']) && $params['pricemin'] !=round($minpricesChart/$rate)) ||
    (!empty($params['pricemax']) && $params['pricemax'] !=round($maxpricesChart/$rate))) {
    $activePrice = 'green_active';
}

$activeMore = '';
if (!empty($params['districts']) || !empty($params['walk_dist']) || !empty($params['subway']) || !empty($params['classes']) || !empty($params['statuses']) || !empty($params['comission'])) $activeMore = 'active';

switch ($currency){
    case 1:
        $selectText = $type==3 ? Yii::t('app', '&#8372;/month') : Yii::t('app', '&#8372;/m²/month');
        break;
    case 2:
        $selectText = $type==3 ? Yii::t('app', '$/month') : Yii::t('app', '$/m²/month');
        break;
    case 3:
        $selectText = $type==3 ? Yii::t('app', '€/month') : Yii::t('app', '€/m²/month');
        break;
    default:
        $selectText = Yii::t('app', '&#8372;/m²/month');
        break;
}


?>
<?= Html::beginForm(['page/bars'], 'post', ['data-pjax' => true, 'id' => 'barsForm']) ?>
<?= Html::beginForm(['/example/pjax/pjax-example-5'], 'post', ['data-pjax' => '', 'class' => 'form-inline']); ?>
<?= Html::input('hidden', 'bars[]', serialize($pricesChart)) ?>
<?= Html::input('hidden', 'type', $type, ['id' => 'type']) ?>
<?= Html::input('hidden', 'currency', $currency, ['id' => 'currency']) ?>
<?= Html::endForm() ?>



<?= Html::beginForm(['page/seo_catalog_urls', 'slug' => $seo->slug->slug], 'get', ['class' => 'filter-form']) ?>
<div id="filters">
    <div class="filter_nav">
        <div class="row">
            <div class="items_sect clearfix">
                <div class="left filters">
                    <div class="item_wrapp target novisible_767">
                        <div class="dropdow_item_wrapp"
                        <div class="select_2_wrapp">
                            <div class="custom_select_2">
                                <div class="custom_select_title"><a href="#"><?= $targetText ?></a></div>
                                <div class="custom_select_list">
                                    <div data-value="1" class="sel-type custom_select_item <?= $rentSelected ?>"><a
                                            href="#"><?= Yii::t('app', 'Rent') ?></a>
                                    </div>
                                    <div data-value="2" class="sel-type custom_select_item <?= $saleSelected ?>"><a
                                            href="#"><?= Yii::t('app', 'Sale') ?></a></div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="item_wrapp novisible_1024">
                        <div class="dropdow_item_wrapp">
                            <div class="dropdown_item_title m2-filter <?= $activeM2 ?>">
                                <div class="item_title_text"><?= Yii::t('app', 'Square') ?></div>
                            </div>
                            <div class="dropdown_item_menu price_w">
                                <div class="append-elem" data-append-desktop-elem="6" data-min-screen="1024">
                                    <h4>Площадь офиса, <span class="val_p">м²</span></h4>
                                    <div class="bars_range_wrapp">
                                        <div class="bars">
                                            <? if (!empty($countValM2['count'])) : ?>
                                                <? foreach ($countValM2['count'] as $k => $val): ?>
                                                    <? $valClass = $val > 0 ? 'notnull' : '' ?>
                                                    <div class="bar <?= $valClass ?>"
                                                         data-count-val="<?= $val ?>"></div>
                                                <? endforeach; ?>
                                            <? endif; ?>
                                        </div>
                                        <div class="range_slider_wrapp">
                                            <div id="range_slider_4"></div>
                                        </div>
                                    </div>
                                    <div class="range_inputs">
                                        <div class="col">
                                            <div class="input_wrapp inline">
                                                <?= Html::input('number', null, null, ['id' => 'input-number_5']) ?>
                                                <?= Html::input('hidden', 'filter[m2min]', $minM2, ['id' => 'minm2']) ?>
                                            </div>
                                            <div class="slash inline"></div>
                                            <div class="input_wrapp inline">
                                                <?= Html::input('number', null, null, ['id' => 'input-number_6']) ?>
                                                <?= Html::input('hidden', 'filter[m2max]', $maxM2, ['id' => 'maxm2']) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="footer_two_cols clearfix">
                                    <div class="left m2-filter">
                                        <p><a href="#" class="submit green_link"><?= Yii::t('app', 'Apply') ?></a></p>
                                    </div>
                                    <div class="right m2-filter">
                                        <p><a href="#" class="remove black_link"><?= Yii::t('app', 'Clear') ?></a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item_wrapp novisible_1024">
                        <div class="dropdow_item_wrapp">
                            <div class="dropdown_item_title dropdown_item_title_2  price-filter <?= $activePrice ?>">
                                <div class="item_title_text">
                                    <p><?= $min_max ?></p>
                                </div>
                            </div>
                            <div class="dropdown_item_menu price_w">
                                <div class="append-elem" data-append-desktop-elem="7" data-min-screen="1024">
                                    <div class="metro_two_cols metro_two_cols_2">
                                        <div class="col">
                                            <h4><?= Yii::t('app', 'Rents') ?>,</h4>
                                        </div>
                                        <div class="col">
                                            <div class="custom_select_wrapp">
                                                <div class="custom_select">
                                                    <div>
                                                        <input type="text" class="select_res" value="$/м²/mec"
                                                               readonly="readonly"/>
                                                        <p class="select_input">
                                                            <span class="sel_val"
                                                                  id="price_sel"><?= $selectText ?></span>
                                                        </p>
                                                    </div>
                                                    <div class="dropdown_select" id="price-filter">
                                                        <div class="select_item">
                                                            <p data-type="1"
                                                               data-currency="1"><?= Yii::t('app', '&#8372;/m²/month') ?></p>
                                                        </div>
                                                        <div class="select_item">
                                                            <p data-type="3"
                                                               data-currency="1"><?= Yii::t('app', '&#8372;/month') ?></p>
                                                        </div>
                                                        <div class="select_item">
                                                            <p data-type="1"
                                                               data-currency="2"><?= Yii::t('app', '$/m²/month') ?></p>
                                                        </div>
                                                        <div class="select_item">
                                                            <p data-type="3"
                                                               data-currency="2"><?= Yii::t('app', '$/month') ?></p>
                                                        </div>
                                                        <div class="select_item">
                                                            <p data-type="1"
                                                               data-currency="3"><?= Yii::t('app', '€/m²/month') ?></p>
                                                        </div>
                                                        <div class="select_item">
                                                            <p data-type="3"
                                                               data-currency="3"><?= Yii::t('app', '€/month') ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <? Pjax::begin([
                                        'enablePushState' => false,
                                        'options' => ['id' => 'barsPjax'],
                                        'formSelector' => '#barsForm',
                                        'clientOptions' => ['method' => 'POST']
                                    ]);
                                    ?>

                                    <?= $this->render('_bars', [
                                        'bars' => $pricesChart,
                                        'type' => $type,
                                        'currency' => $currency,
                                        'rate' => $rate,
                                        'symbol' => $currencySymbol,
                                        'minmax' => [$minPrice, $maxPrice]
                                    ]);
                                    ?>
                                    <? Pjax::end(); ?>


                                </div>
                                <div class="footer_two_cols clearfix">
                                    <div class="left">
                                        <?= Html::input('hidden', 'filter[currency]', $currency, ['id' => 'currF']) ?>
                                        <?= Html::input('hidden', 'filter[type]', $type, ['id' => 'typeF']) ?>
                                        <p><a href="#" class="submit green_link"><?= Yii::t('app', 'Apply') ?></a></p>
                                    </div>
                                    <div class="right">
                                        <p><a href="#" class="remove black_link"><?= Yii::t('app', 'Clear') ?></a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item_wrapp">
                        <button type="button" class="more_filter <?= $activeMore ?>"><span
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
                        <input type="radio" name="filter[target][]" id="pill_ch_3"/>
                        <label for="pill_ch_3">Аренда</label>
                    </div>
                    <div class="pill_checlbox_2">
                        <input type="radio" name="filter[target][]" id="pill_ch_4">
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
        <? if (!empty($filters['district'])): ?>
            <div class="resp_filter_wrapp more-filters">
                <div class="dropdow_item_wrapp resp">
                    <div class="dropdown_item_title">
                        <div class="item_title_text">Район</div>
                        <div class="chose_filter" data-filters-index="filters_2"></div>
                    </div>
                    <div class="dropdown_item_menu dropdown_item_menu_4">
                        <? foreach ($filters['district'] as $district) : ?>
                            <? if (!empty($params['districts']) && in_array($district->id, $params['districts'])) {
                                $checked_district = 'checked';
                            } else {
                                $checked_district = '';
                            }
                            ?>
                            <div class="checkbox_wrapp">
                                <div class="checkbox">
                                    <input class="more-filters" type="checkbox" name="filter[districts][]"
                                           value="<?= $district->id ?>"
                                           id="ch_<?= $district->id ?>" <?= $checked_district ?> >
                                    <label for="ch_<?= $district->id ?>"
                                           data-filter="filters_2"><?= $district->name ?></label>
                                </div>
                            </div>
                        <? endforeach; ?>
                    </div>
                </div>
            </div>
        <? endif; ?>
        <? if (!empty($filters['subways'])): ?>
            <div class="resp_filter_wrapp  more-filters">
                <div class="dropdow_item_wrapp resp">
                    <div class="dropdown_item_title">
                        <div class="item_title_text"><?= Yii::t('app', 'Subway') ?></div>
                        <div class="chose_filter" data-filters-index="filters_5">
                            <span id="metro_val"><?= $metroVal ?></span> m,
                            <span id="metro_name"><?= $metroName ?></span>
                            <input type="hidden" name="filter[walk_dist]" id="walk_dist" value="<?= $metroValclear ?>"/>
                        </div>
                    </div>
                    <div class="dropdown_item_menu dropdown_item_menu_4">
                        <div class="metro_box">
                            <? if (!empty($filters['branches'])): ?>
                                <div class="metro_two_cols">
                                    <div class="col">
                                        <h4>Ветка метро</h4>
                                    </div>
                                    <div class="col">
                                        <div class="radio_metro_wrapp">
                                            <? foreach ($filters['branches'] as $branch) : ?>
                                                <? if ($branch == 1) : ?>
                                                    <div class="radio_wrapp metro_radio branch">
                                                        <input data-branch="1" type="radio" id="metro_1"/>
                                                        <label for="metro_1"><i class="red_metro"></i></label>
                                                    </div>
                                                <? elseif ($branch == 2) : ?>
                                                    <div class="radio_wrapp metro_radio branch">
                                                        <input data-branch="2" type="radio" id="metro_2"/>
                                                        <label for="metro_2"><i class="green_metro"></i></label>
                                                    </div>
                                                <? elseif ($branch == 3) : ?>
                                                    <div class="radio_wrapp metro_radio branch">
                                                        <input data-branch="3" type="radio" id="metro_3"/>
                                                        <label for="metro_3"><i class="blue_metro"></i></label>
                                                    </div>
                                                <? endif; ?>
                                            <? endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            <? endif; ?>
                            <div class="metro_two_cols">
                                <div class="col">
                                    <h4>До метро</h4>
                                </div>
                                <div class="col">
                                    <div class="range_slider_wrapp range_slider_3_wrapp">
                                        <span class="sl_desc">m</span>
                                        <div id="range_slider_3"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="select_4_wrapp select_4_2">
                            <div class="custom_select_2">
                                <div class="custom_select_title" id="metro_name_val"><a href="#"><?= $metroName ?></a>
                                </div>
                                <div class="custom_select_list">
                                    <? foreach ($filters['subways'] as $subway) : ?>
                                        <?
                                        if (isset($params['subway']) && $subway->id == $params['subway']) {
                                            $checked_subway = 'selected';
                                        } else {
                                            $checked_subway = '';
                                        }
                                        ?>

                                        <div class="subway custom_select_item <?= $checked_subway ?>"
                                             data-subway="<?= $subway->id ?>"
                                             data-branch="<?= $subway->branch_id ?>"><a
                                                href="#"><?= $subway->name ?></a></div>
                                    <? endforeach; ?>
                                    <input type="hidden" name="filter[subway]" value="<?= $metroId ?>" id="subway"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <? endif; ?>
        <? if (!empty($filters['classes'])): ?>
            <div class="resp_filter_wrapp more-filters">
                <div class="dropdow_item_wrapp resp">
                    <div class="dropdown_item_title">
                        <div class="item_title_text">Тип/Класс</div>
                        <div class="chose_filter" data-filters-index="filters_1"></div>
                    </div>
                    <div class="dropdown_item_menu dropdown_item_menu_4">
                        <? foreach ($filters['classes'] as $class) : ?>
                            <? if (!empty($params['classes']) && in_array($class->id, $params['classes'])) {
                                $checked_classes = 'checked';
                            } else {
                                $checked_classes = '';
                            }
                            ?>

                            <div class="checkbox_wrapp">
                                <div class="checkbox">
                                    <input class="more-filters" type="checkbox" name="filter[classes][]"
                                           value="<?= $class->id ?>"
                                           id="ch_3_<?= $class->id ?>" <?= $checked_classes ?>>
                                    <label for="ch_3_<?= $class->id ?>"
                                           data-filter="filters_1"><?= $class->name ?></label>
                                </div>
                            </div>
                        <? endforeach; ?>
                    </div>
                </div>
            </div>
        <? endif; ?>
        <? if (!empty($filters['statuses'])): ?>
            <div class="resp_filter_wrapp more-filters">
                <div class="dropdow_item_wrapp resp">
                    <div class="dropdown_item_title">
                        <div class="item_title_text">Состояние</div>
                        <div class="chose_filter" data-filters-index="filters_6"></div>
                    </div>
                    <div class="dropdown_item_menu dropdown_item_menu_4">
                        <? foreach ($filters['statuses'] as $status) : ?>
                            <? if (!empty($params['statuses']) && in_array($status->id, $params['statuses'])) {
                                $checked_statuses = 'checked';
                            } else {
                                $checked_statuses = '';
                            }
                            ?>
                            <div class="checkbox_wrapp">
                                <div class="checkbox">
                                    <input class="more-filters" type="checkbox" name="filter[statuses][]"
                                           value="<?= $status->id ?>"
                                           id="ch_15_<?= $status->id ?>" <?= $checked_statuses ?> >
                                    <label for="ch_15_<?= $status->id ?>"
                                           data-filter="filters_6"><?= $status->name ?></label>
                                </div>
                            </div>
                        <? endforeach; ?>
                    </div>
                </div>
            </div>
        <? endif; ?>

        <div class="resp_filter_wrapp more-filters">
            <div class="resp_filter_inner">
                <div class="checkbox">
                    <? $comChecked = !empty($params['comission']) && $params['comission']=='on' ? 'checked' : '' ?>
                    <input class="more-filters" type="checkbox" name="filter[comission]" id="ch_1_2" <?= $comChecked ?>/>
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
        <div class="resp_filter_wrapp ">
            <div class="resp_filter_inner">
                <div class="filter_wrapp">
                    <div class="col">
                        <p>Выводить:</p>
                    </div>
                    <div class="col">
                        <div class="checkboxes_wrapp">
                            <div class="pill_checlbox">
                                <? if($result=='offices'){
                                    $ofChecked = 'checked';
                                    $bcChecked = '';
                                } else {
                                    $ofChecked = '';
                                    $bcChecked = 'checked';
                                };
                                ?>
                                <input name=filter[result] value="offices" type="radio" id="pill_ch_1" <?= $ofChecked ?>/>
                                <label for="pill_ch_1">Офисы</label>
                            </div>
                            <div class="pill_checlbox">
                                <input name=filter[result] value="bc" type="radio" id="pill_ch_2" <?= $bcChecked ?>/>
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
            <div class="flex_pills more-filters">
                <a href="#" class="submit olive_pill"><?= Yii::t('app', 'Apply') ?></a>
                <a href="#" class="remove white_pill"><?= Yii::t('app', 'Clear') ?></a>
            </div>
        </div>
    </div>
    <div class="mask_2"></div>
</div>
<? //echo Html::submitButton('Отправить', ['class' => 'submit']) ?>
<?= Html::endForm() ?>
