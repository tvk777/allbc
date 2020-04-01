<?php
$currentLanguage = Yii::$app->language;
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
//$this->registerCssFile('/css/style.css');



$places = $target == 2 ? $model->placesSell : $model->places;


$comission = $model->percent_commission == 0 ? '<span class="red">' . Yii::t('app', 'no commission') . ' </span>' : '<span class="red"> ' . Yii::t('app', 'commission') . ' ' . $model->percent_commission . '%</span>';

$this->title = getDefaultTranslate('title', $currentLanguage, $model);
$district = '';
if($model->district){
    $district = ', ' . $model->district->name . ' р-н';
}

?>
<section class="grey_bg">
    <div class="row row_2">
        <div class="object_center_templ clearfix">
            <div class="top">
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
                                    <p><a href="#"
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
                        <div class="two_cols_2 two_cols_2_2">
                            <div class="two_cols_2_col">
                                <div class="adres">
                                    <h5>
                                        <a target="_blank" href="#"><?= getDefaultTranslate('name', $currentLanguage, $model->city) . $district ?></a>
                                    </h5>
                                    <? if($model->address) : ?>
                                    <p><?= $model->address ?></p>
                                    <?endif; ?>
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

                                        $subway = $subwayIco . '<a target="_blank" href="#">' . $sub->subwayDetails->name . '</a> <span class="about">~</span> ' . $sub->walk_distance . ' м'; ?>
                                        <div class="metro_wrapp">
                                            <p><?= $subway; ?></p>
                                        </div>
                                    <? endforeach ?>
                                <? endif; ?>
                            </div>
                        </div>
                    </div>
                    <? if (!empty($model->user)) : ?>
                        <? //debug($model->user->userInfo->avatar) ?>
                        <div class="inner">
                            <div class="author_wrapp">
                                <? if (!empty($model->user->userInfo->avatar->thumb260x260Src)) : ?>
                                    <div class="col">
                                        <div class="author_photo">
                                            <img src="<? echo $model->user->userInfo->avatar->thumb260x260Src ?>"
                                                 alt=""/>
                                        </div>
                                    </div>
                                <? endif; ?>
                                <div class="col">
                                    <h3><? echo $model->user->userInfo->name ?></h3>
                                    <p class="desc_p_2"><b>Собственник</b><span
                                            class="border_line_2"> |</span><?= $comission ?></p>
                                    <p><a href="#" class="green_link_3">Другие объявления автора</a></p>
                                </div>
                            </div>
                            <? if (!empty($model->user->userInfo->phone) || !empty($model->user->userInfo->broker_phone)) : ?>
                                <? $phone = !empty($model->user->userInfo->broker_phone) ? $model->user->userInfo->broker_phone : $model->user->userInfo->phone; $short = substr($phone, 0, 3);?>
                            <div class="tel_pill_wrapp tel_pill_wrapp_resp">
                                <div>
                                    <a href="tel:<?= $phone ?>" class="white_pill tel_pill"
                                       data-tel-pill="tel_pill_1"><i class="tel_icon"></i> <span class="tel_number"><?= $phone ?></span></a>
                                </div>
                            </div>
                            <? endif; ?>
                        </div>
                    <? endif; ?>
                </div>
            </div>
            <div class="bottom">
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
        </div>
    </div>
</section>
