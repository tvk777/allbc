<?php
//debug($rentLinks);
?>

<div class="row">
    <h2><?= Yii::t('app', 'Popular Searches') ?></h2>
    <div class="pills_list_wrapp">
        <ul>
            <li class="switch-type"><a id="rent" href="<?= $mainRent ?>" class="active"><?= Yii::t('app', 'Rent') ?></a></li>
            <li class="switch-type"><a id="sale" href="<?= $mainSell ?>"><?= Yii::t('app', 'Sale') ?></a></li>
        </ul>
    </div>

    <div class="selects_sect offset_ziro tags" data-slidedown="tags" data-minheight="132">
        <div class="rent-links">
            <? if (!empty($rentLinks)) : ?>
                <? foreach ($rentLinks as $category) : ?>
                    <? if (!empty($category->links2)) : ?>
                        <? foreach ($category->links2 as $l) : ?>
                            <a class="tag" href="<?= $l->link_href ?>"><?= $l->link_name ?></a>
                        <? endforeach; ?>
                    <? endif; ?>
                <? endforeach; ?>
            <? endif; ?>
        </div>
        <div class="sale-links">
            <? if (!empty($saleLinks)) : ?>
                <? foreach ($saleLinks as $category) : ?>
                    <? if (!empty($category->links3)) : ?>
                        <? foreach ($category->links3 as $l) : ?>
                            <a class="tag" href="<?= $l->link_href ?>"><?= $l->link_name ?></a>
                        <? endforeach; ?>
                    <? endif; ?>
                <? endforeach; ?>
            <? endif; ?>
        </div>
    </div>
    <div class="align_right">
        <a href="#" class="green_pill show_text" data-slidedown-btn="tags">
            <span class="show"><?= Yii::t('app', 'Show more') ?><i class="arrow_down_white"></i></span>
            <span class="hide"><?= Yii::t('app', 'Collapse') ?><i class="arrow_up_white"></i></span>
        </a>
    </div>

</div>