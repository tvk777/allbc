<?php
use yii\helpers\Html;
use yii\helpers\Url;

$currentLanguage = Yii::$app->language;
?>
<? if (count($experts) > 0) : ?>
    <div class="two_cols_templ clearfix experts">
        <div class="left">
            <div class="descript_box">
                <div class="title_wrapp title_wrapp_2 clearfix">
                    <h2><?= Yii::t('app', 'The experts') ?> <span class="text_logo">a<span
                                class="green">l</span><span class="blue">l</span>bc</span> <span
                            class="city"><?= Yii::t('app', 'Kiev') ?></span></h2>
                </div>
                <div class="text">
                    <?= getDefaultTranslate('content', $currentLanguage, $text) ?>
                </div>
                <div class="pill_wrapp hide_900">
                    <a href="/pages/get_office/" class="green_pill"><?= Yii::t('app', 'Pick office') ?></a>
                </div>
            </div>
        </div>
        <div class="right">
            <div class="slider_2_wrapp">
                <div class="slider_2">
                    <? foreach ($experts as $expert) : ?>
                        <?
                        $src = $expert->user->avatar ? $expert->user->avatar->thumb260x260Src : '';
                        $name = $expert->user->name ? $expert->user->name : '';
                        ?>
                        <div class="slide">
                            <a href="<?= $baseUrl . '?filter[user]=' . $expert->user_id ?>" target="_blank">
                            <div class="thunb_4">
                                <div class="img_box">
                                        <img src="<?= $src ?>"
                                             alt="<?= $name ?>"
                                             title="<?= $name ?>"
                                        />
                                </div>
                                <h3><?= $name ?></h3>
                            </div>
                            </a>
                        </div>
                    <? endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="align_center pill_wrapp visible_900">
        <a href="/pages/get_office/" class="green_pill"><?= Yii::t('app', 'Pick office') ?></a>
    </div>

<? endif; ?>