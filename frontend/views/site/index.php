<?php
use yii\helpers\Url;
/* @var $this yii\web\View */
$currentLanguage = Yii::$app->language;
$this->title = $seo->title;
$this->registerMetaTag([
    'name' => 'description',
    'content' => $seo->description
]);
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => $seo->keywords
]);
$this->registerJsFile( '/js/sliderResponsive.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('/css/sliderResponsive.css');

?>
<section class="promo_sect">
    <div class="promo-slider" id="bgslider">
        <? foreach($images as $img) : ?>
        <div style="background-image:url(<?= $img['url']?>)">
          <a href="<?= $img['href']?>"><?= $img['title']?></a>
        </div>
        <? endforeach; ?>
    </div>
    <div class="row">

        <?php echo common\widgets\MainTitleWidget::widget() ?>

        <div class="search_city">
            <div class="select_sect">
                <div class="select_2_wrapp">
                    <div class="custom_select_2">
                        <div class="custom_select_title"><a href="#"><?= Yii::t('app', 'Rent') ?></a></div>
                        <div class="custom_select_list">
                            <div data-value="1" class="sel-type custom_select_item selected"><a href="#"><?= Yii::t('app', 'Rent') ?></a>
                            </div>
                            <div data-value="2" class="sel-type custom_select_item"><a href="#"><?= Yii::t('app', 'Sale') ?></a></div>
                        </div>
                    </div>
                </div>
            </div>
            <form action="" id="main_form">
                <input name="city_link" type="hidden" id="city_link" value="<?= $mainRent ?>"
                       data-valuesell="<?= $mainSell ?>">
                <input name="main_type" type="hidden" id="main_type" value="1">
                <input id="submit_main_form" class="gradient_pill search" type="submit" value="<?= Yii::t('app', 'Search') ?>">
            </form>
        </div>

        <div class="section_1_text offset_ziro">
            <div class="text_section" id="count">
                <div class="city_count free_count"><h3><?= $city->bc_count ?></h3></div>
                <div class="count_text"><p><?= Yii::t('app', 'Free') ?><br/> <?= Yii::t('app', 'offices in') ?> <span
                            class="city-name"><?= $inflect ?></span></p></div>
            </div>
        </div>

    </div>

</section>
<section class="sect_2">
    <?= $this->render('_partial/_links', [
        'rentLinks' => $rentLinks,
        'saleLinks' => $saleLinks,
        'mainRent' => $mainRent,
        'mainSell' => $mainSell,
    ]); ?>
</section>
<section class="sect_3 grey_bg">
    <div class="row">
        <?= common\widgets\HowtouseWidget::widget(); ?>
    </div>
</section>
<section class="sect_4">
    <div class="row">
        <h2><?= Yii::t('app', 'Our Partners') ?></h2>
        <?= common\widgets\PartnersWidget::widget(); ?>
    </div>
</section>
<section class="sect_5">
    <div class="row">
        <?= common\widgets\ServicesWidget::widget(); ?>
    </div>
</section>

<section class="sect_6 grey_bg">
    <div class="row">
        <?= common\widgets\ReviewsWidget::widget(); ?>
    </div>
</section>

<section class="sect_7">
    <div class="row">
        <?= common\widgets\AboutUsWidget::widget(); ?>
    </div>
</section>
<section class="sect_8">
    <div class="row">
        <?= common\widgets\ExpertsWidget::widget(); ?>
    </div>
</section>
<section class="sect_10 grey_bg">
    <div class="row">
        <?= common\widgets\LastModifyWidget::widget(); ?>
    </div>
</section>
<section class="sect_11">
    <div class="row">
        <?= common\widgets\NewsWidget::widget(); ?>
    </div>
</section>



