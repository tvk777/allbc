<?php
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;

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
if ((!empty($params['m2min']) && $params['m2min'] != $countValM2['min']) || (!empty($params['m2max']) && $params['m2max'] != $countValM2['max'])) {
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
if ($currency == 2) {
    $currencySymbol = '$';
} elseif ($currency == 3) {
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
$minPrice = !empty($params['pricemin']) ? $params['pricemin'] : round($minpricesChart / $rate);
$maxPrice = !empty($params['pricemax']) ? $params['pricemax'] : round($maxpricesChart / $rate);
$min_max = $currencySymbol . ' ' . $minPrice . ' - ' . $maxPrice;

$this->registerJsVar('maxPrice', $maxPrice, $this::POS_HEAD);
$this->registerJsVar('minPrice', $minPrice, $this::POS_HEAD);
$this->registerJsVar('maxTotalPrice', $pricesChart['type1']['max'], $this::POS_HEAD);

if ((!empty($params['pricemin']) && $params['pricemin'] != round($minpricesChart / $rate)) ||
    (!empty($params['pricemax']) && $params['pricemax'] != round($maxpricesChart / $rate))
) {
    $activePrice = 'green_active';
}
$activeDistricts = (!empty($params['districts']) && count($params['districts'])) ? 'green_active' : '';
/*$activeMore = '';
if (!empty($params['districts']) || !empty($params['walk_dist']) || !empty($params['subway']) || !empty($params['classes']) || !empty($params['statuses']) || !empty($params['comission'])) $activeMore = 'active';*/



switch ($currency) {
    case 1:
        $selectText = $type == 3 ? Yii::t('app', '&#8372;/month') : Yii::t('app', '&#8372;/m²/month');
        break;
    case 2:
        $selectText = $type == 3 ? Yii::t('app', '$/month') : Yii::t('app', '$/m²/month');
        break;
    case 3:
        $selectText = $type == 3 ? Yii::t('app', '€/month') : Yii::t('app', '€/m²/month');
        break;
    default:
        $selectText = Yii::t('app', '&#8372;/m²/month');
        break;
}

$sortText = Yii::t('app', 'Sort');
if (!empty($conditions) && !empty($conditions['sort'])) {
    switch ($conditions['sort']) {
        case 'price_asc':
            $sortText = Yii::t('app', 'Ascending prices');
            break;
        case 'price_desc':
            $sortText = Yii::t('app', 'Descending prices');
            break;
        case 'm2_asc':
            $sortText = Yii::t('app', 'Ascending area');
            break;
        case 'm2_desc':
            $sortText = Yii::t('app', 'Descending area');
            break;
        case 'updated_at':
            $sortText = Yii::t('app', 'By date added');
            break;
        default:
            $sortText = Yii::t('app', 'Sort');
            break;
    }
}

$result==='bc';
$urlRezult = Yii::$app->request->pathInfo;
if($result==='bc'){
    $bcLink = '<span class="active">'.Yii::t('app', 'Business centers').'</span>';
    $officeLink = '<a href="'.$urlRezult.'">'.Yii::t('app', 'Offices').'</a>';
} else {
    $urlRezult .='?filter[result]=bc';
    $officeLink = '<span class="active">'.Yii::t('app', 'Offices').'</span>';
    $bcLink = '<a href="'.$urlRezult.'">'.Yii::t('app', 'Business centers').'</a>';
}

?>
<?= Html::beginForm(['page/bars'], 'post', ['data-pjax' => true, 'id' => 'barsForm']) ?>
<?= Html::input('hidden', 'bars[]', serialize($pricesChart)) ?>
<?= Html::input('hidden', 'type', $type, ['id' => 'type']) ?>
<?= Html::input('hidden', 'currency', $currency, ['id' => 'currency']) ?>
<?= Html::endForm() ?>



<?= Html::beginForm('/' . $seo->slug->slug, 'get', ['class' => 'filter-form']) ?>
<div id="filters">
    <div class="filter_nav">
        <div class="row">
            <div class="items_sect clearfix">
                <div class="left filters">
                    <!--аренда-продажа-->
                    <div class="item_wrapp target novisible_767 target">
                        <div class="dropdow_item_wrapp">
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
                    </div>
                    <!--площадь-->
                    <div class="item_wrapp novisible_1024 square">
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
                    <!--цена-->
                    <div class="item_wrapp novisible_1024 price">
                        <div class="dropdow_item_wrapp">
                            <div class="dropdown_item_title dropdown_item_title_2  price-filter <?= $activePrice ?>">
                                <div class="item_title_text">
                                    <?= $min_max ?>
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

                    <!--<div class="item_wrapp">
                        <button type="button" class="more_filter <? /*= $activeMore */ ?>"><span
                                class="novisible_767">Еще фильтры</span><span class="visible_767">Фильтры</span>
                        </button>
                    </div>-->

                    <? if (!empty($filters['district'])): ?>
                        <div class="item_wrapp novisible_1024">
                            <div class="dropdow_item_wrapp">
                                <div class="dropdown_item_title district-filter <?= $activeDistricts ?>">
                                    <?  $districtText = (!empty($params['districts']) && count($params['districts']) > 0)
                                        ? ':(<span class="count">'.count($params['districts']).'</span>'
                                        : '';
                                    ?>
                                    <div class="item_title_text district"><?= Yii::t('app', 'District').$districtText ?></div>
                                    <!--<div class="chose_filter" data-filters-index="filters_2"></div>-->
                                </div>
                                <div class="dropdown_item_menu dropdown_item_menu_4 countable">
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
                                                       data-count="district"><?= $district->name ?></label>
                                            </div>
                                        </div>
                                    <? endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <? endif; ?>
                    <? if (!empty($filters['subways'])): ?>
                        <div class="item_wrapp novisible_1024">
                            <div class="dropdow_item_wrapp">
                                <div class="dropdown_item_title">
                                    <div class="item_title_text"><?= Yii::t('app', 'Subway') ?></div>
                                </div>
                                <div class="dropdown_item_menu dropdown_item_menu_4">
                                    <div class="metro_box">
                                        <div class="chose_filter" data-filters-index="filters_5">
                                            <span id="metro_val"><?= $metroVal ?></span> m,
                                            <span id="metro_name"><?= $metroName ?></span>
                                            <input type="hidden" name="filter[walk_dist]" id="walk_dist"
                                                   value="<?= $metroValclear ?>"/>
                                        </div>

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
                                                                    <label for="metro_1"><i
                                                                            class="red_metro"></i></label>
                                                                </div>
                                                            <? elseif ($branch == 2) : ?>
                                                                <div class="radio_wrapp metro_radio branch">
                                                                    <input data-branch="2" type="radio" id="metro_2"/>
                                                                    <label for="metro_2"><i
                                                                            class="green_metro"></i></label>
                                                                </div>
                                                            <? elseif ($branch == 3) : ?>
                                                                <div class="radio_wrapp metro_radio branch">
                                                                    <input data-branch="3" type="radio" id="metro_3"/>
                                                                    <label for="metro_3"><i
                                                                            class="blue_metro"></i></label>
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
                                            <div class="custom_select_title" id="metro_name_val"><a
                                                    href="#"><?= $metroName ?></a>
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
                                                <input type="hidden" name="filter[subway]" value="<?= $metroId ?>"
                                                       id="subway"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <? endif; ?>
                    <? if (!empty($filters['classes'])): ?>
                        <div class="item_wrapp novisible_1024">
                            <div class="dropdow_item_wrapp">
                                <div class="dropdown_item_title">
                                    <div class="item_title_text">Тип/Класс</div>
                                </div>
                                <div class="dropdown_item_menu dropdown_item_menu_4">
                                    <div class="chose_filter" data-filters-index="filters_1"></div>

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
                        <div class="item_wrapp novisible_1024">
                            <div class="dropdow_item_wrapp">
                                <div class="dropdown_item_title">
                                    <div class="item_title_text">Состояние</div>
                                </div>
                                <div class="dropdown_item_menu dropdown_item_menu_4">
                                    <div class="chose_filter" data-filters-index="filters_6"></div>
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

                    <div class="item_wrapp novisible_1024">
                        <a href="#" class="submit olive_pill "><?= Yii::t('app', 'Search') ?></a>
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


<div id="map_box">
    <div class="mask"></div>
    <div class="map_object_header">
        <div class="row clearfix">
            <div class="left">
                <div class="inlines_wrapp">
                    <div class="inline count">
                        <p><?= $countPlaces ?> </p>
                    </div>
                    <div class="inline result">
                        <span>Выводить:</span>
                        <?= $bcLink ?>
                        <?= $officeLink ?>
                    </div>
                    <div class="item_wrapp novisible_1024">
                        <div class="resp_filter_inner">
                            <div class="checkbox">
                                <? $comChecked = !empty($params['comission']) && $params['comission'] == 'on' ? 'checked' : '' ?>
                                <input class="more-filters" type="checkbox" name="filter[comission]"
                                       id="ch_1_2" <?= $comChecked ?>/>
                                <label for="ch_1_2">Без комиссии</label>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="right align_right">
                <!--подписаться на обновления-->
                <div class="item_wrapp append-elem novisible_767" data-append-desktop-elem="8"
                     data-min-screen="767">
                    <?= Html::a(
                        Yii::t('app', 'Subscribe to updates'),
                        ['site/subscribe'],
                        ['class' => 'green_pill green_pill_2 modal-form size-middle']
                    ) ?>
                </div>
                <!--сортировка-->
                <div class="custom_select_wrapp custom_select_wrapp_2">
                    <div class="custom_select">
                        <div>
                            <input type="text" class="select_res" value="$/м²/mec" readonly="readonly">
                            <p class="select_input"><span class="sel_val"><?= $sortText ?></span></p>
                        </div>
                        <div class="dropdown_select">
                            <div class="select_item">
                                <p><a href="<?= Url::current(['sort' => 'price_asc']) ?>"><?= Yii::t('app', 'Ascending prices') ?></a></p>
                            </div>
                            <div class="select_item">
                                <p><a href="<?= Url::current(['sort' => 'price_desc']) ?>"><?= Yii::t('app', 'Descending prices') ?></a></p>
                            </div>
                            <div class="select_item">
                                <p><a href="<?= Url::current(['sort' => 'm2_asc']) ?>"><?= Yii::t('app', 'Ascending area') ?></a></p>
                            </div>
                            <div class="select_item">
                                <p><a href="<?= Url::current(['sort' => 'm2_desc']) ?>"><?= Yii::t('app', 'Descending area') ?></a></p>
                            </div>
                            <div class="select_item">
                                <p><a href="<?= Url::current(['sort' => 'updated_at']) ?>"><?= Yii::t('app', 'By date added') ?></a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?= Html::endForm() ?>
