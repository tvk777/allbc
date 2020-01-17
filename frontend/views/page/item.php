<?php
$currentLanguage = Yii::$app->language;
//debug($model->characteristics);
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

$this->registerJsFile('/js/jquery.mCustomScrollbar.concat.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('/css/jquery.mCustomScrollbar.css');


$places = $target == 2 ? $model->placesSell : $model->places;
$city_url = $target == 2 ? $mainSell : $mainRent;
$city_id = 0;
//debug(count($model->district->items));

if (isset($model->city)) {
    $city_id = $model->city->id;
    $rentLable = Yii::t('app', 'Office rental in') . ' ' . getLangInflect($model->city, $currentLanguage);
    $sellLable = Yii::t('app', 'Office for sale in') . ' ' . getLangInflect($model->city, $currentLanguage);
    $city_url = $target == 2 ? $model->city->slug_sell : $model->city->slug;
    $this->params['breadcrumbs'][] = [
        'label' => $target == 2 ? $sellLable : $rentLable,
        'url' => $city_url
    ];
}
if ($seoClass) {
    $this->params['breadcrumbs'][] = [
        'label' => $seoClass->name,
        'url' => $seoClass->slug->slug
    ];
}
$district = '';
$district_filter_href = $city_url;
if ($model->district) {
    $district = ', ' . $model->district->name . ' р-н';
    $district_filter_href .= '?filter[districts][]=' . $model->district->id;
}
$comission = $model->percent_commission == 0 ? '<span class="red">' . Yii::t('app', 'no commission') . ' </span>' : '<span class="red"> ' . Yii::t('app', 'commission') . ' ' . $model->percent_commission . '%</span>';

$this->title = getDefaultTranslate('title', $currentLanguage, $model);
$this->params['breadcrumbs'][] = getDefaultTranslate('name', $currentLanguage, $model);
$share_img_url = '';
?>
<section class="grey_bg">
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
            </div>
            <div class="left">
                <div class="object_info">
                    <div class="inner">
                        <div class="object_title">
                            <div class="h3_wrapp">
                                <h3><?= getDefaultTranslate('name', $currentLanguage, $model); ?></h3>
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
                                    <p><a href="<?= $city_url . '?filter[classes][]=' . $model->class->id ?>"
                                          class="green_link_3"><?= Yii::t('app', 'Business center') . ' ' . getDefaultTranslate('name', $currentLanguage, $model->class, true) ?> </a>
                                    </p>
                                </div>
                                <div class="col">
                                    <p>ID: <?= $model->id ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="inner">
                        <div class="free_office">
                            <p>Свободные оффисы:</p>
                            <div class="pills_wrapp_2 scroll">
                                <? if (count($places) > 0) : ?>
                                    <? foreach ($places as $index => $place) : ?>
                                        <? $m2 = $place->m2min ? $place->m2min . '-' . $place->m2 : $place->m2;
                                        $check = $index == 0 ? 'checked="true"' : '';
                                        $a = Html::a($m2 . ' м²', ['show-place', 'id' => $place->id, 'target' => $target], ['class' => 'modal-form']);
                                        ?>
                                        <div class="pill_checlbox pill_checkbox_2">
                                            <input type="radio" name="pill_checkboxes_2"
                                                   id="pill_ch_<?= $index ?>" <?= $check ?> >
                                            <label for="pill_ch_<?= $index ?>"><?= $a ?></label>
                                        </div>
                                    <? endforeach ?>
                                <? endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="inner">
                        <div class="two_cols_2 two_cols_2_2">
                            <div class="two_cols_2_col">
                                <div class="adres">
                                    <h5>
                                        <a target="_blank"
                                           href="<?= $district_filter_href ?>"><?= getDefaultTranslate('name', $currentLanguage, $model->city, true) . $district ?></a>
                                    </h5>
                                    <? if ($model->street) : ?>
                                        <p><?= $model->street ?></p>
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

                                        $subway = $subwayIco . '<a target="_blank" href="' . $city_url . '?filter[subway]=' . $sub->subway_id . '">' . $sub->subwayDetails->name . '</a> <span class="about">~</span> ' . $sub->walk_distance . ' м'; ?>
                                        <div class="metro_wrapp">
                                            <p><?= $subway; ?></p>
                                        </div>
                                    <? endforeach ?>
                                <? endif; ?>
                            </div>
                            <div class="two_cols_2_col">
                                <p class="map_link"><i class="map"></i><a href="#" class="dashed_link">на карте</a></p>
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
                    <? if (count($model->brokers) > 0) : ?>
                        <? foreach ($model->brokers as $user) : ?>
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

<section>
    <div class="row row_2">
        <div class="inner_box">

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

