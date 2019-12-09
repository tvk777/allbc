<?php
$links = json_decode($seo->links);
$count = count($links);
$crumbs = json_decode($seo->crumbs);
//debug($count);
$i = 0;
$active = '';
?>
<? if ($count > 0) : ?>
<section class="sect_2_info_side">
    <div class="row">
        <div class="text_box" id="slide_tags" data-minheight="175">
            <div class="inner_height">
                <div class="tags_slidedown tags_slidedown_2">
                    <? foreach ($links as $link): ?>
                        <? $active = $i == 0 ? 'active' : '' ?>
                        <a class="tag <?= $active ?>" href="<?= $link->col2 ?>"><?= $link->col1 ?></a>
                        <? $i++; ?>
                    <? endforeach; ?>
                </div>
            </div>
        </div>
        <? if ($count > 9) : ?>
        <div class="showmore_wrapp">
            <a href="#" class="green_link show_text" data-slidebox-id="slide_tags"><i class="plus"></i><span
                    class="show">Показать больше</span><span class="hide">Свернуть</span></a>
        </div>
        <? endif; ?>
    </div>
</section>
<? endif; ?>


<section class="sect_3_info_side">
    <div class="row">
        <?= common\widgets\DistrictsStatWidget::widget(['target' => $seo->target, 'city' => $city]); ?>
        <div class="thumbnails_3_wrapp">
            <?= common\widgets\ServicesWidget::widget(); ?>
        </div>
    </div>
</section>

<section class="sect_7_2">
    <div class="row">
        <?= common\widgets\AboutUsWidget::widget(); ?>
    </div>
</section>

<? if (count($crumbs) > 0) : ?>
    <section>
        <div class="row">
            <div class="breadcrumbs_wrapp">
                <ul class="breadcrumbs">
                    <li><a href="/"><?= Yii::t('app', 'Home') ?></a></li>
                    <? foreach ($crumbs as $crumb): ?>
                        <? if ($crumb->col2 != ''): ?>
                            <li><a href="<?= $crumb->col2 ?>"><?= $crumb->col1 ?></a></li>
                        <? else: ?>
                            <li><span><?= $crumb->col1 ?></span></li>
                        <? endif; ?>
                    <? endforeach; ?>
                </ul>
            </div>
        </div>
    </section>
<? endif; ?>

