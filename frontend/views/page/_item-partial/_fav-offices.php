<?php
use kriptograf\wishlist\widgets\WishlistButton;

$currentLanguage = Yii::$app->language;
$target = 1;
//debug(); if(!empty($item->images))
foreach ($offices as $office) : ?>
    <?
    //var_dump($office['model']->no_bc);
    $item = $office['model']->no_bc === 1 ? $office['model']->office : $office['model']->bcitem;
    $imgSrc = '';
    if (!empty($office['model']->images)) {
        $imgSrc = $office['model']->images[0]->thumb300x200Src;
    } else {
        if ($office['model']->no_bc !== 1 && !empty($item->images)) {
            $imgSrc = $item->images[0]->thumb300x200Src;
        }
    }

    $plus = '';
    $placePrices = $office['model']->prices;
    $prices = count($placePrices) > 0 ? $office['model']->getPricePeriod($placePrices) : Yii::t('app', 'con.');
    if (count($placePrices) > 0) {
        $uah = $prices['uah']['m2'];
        if ($office['target'] == 1) {
            $m2_uah = $prices['uah']['m2_2'];
            if ($uah < $m2_uah) $plus = ' ++';
            $price = Yii::t('app', 'Price') . ': ' . $uah . ' ' . Yii::t('app', '₴/m²/mo.') . $plus;
        } else {
            $value = $prices['uah']['value'];
            $full = $prices['uah']['full'];
            if ($value < $full) $plus = ' ++';
            $price = Yii::t('app', 'Price') . ': ' . $uah . ' ' . Yii::t('app', '₴/m²') . $plus;
        }
    } else {
        $price = Yii::t('app', 'con.');
    }

    //debug($office['model']);
    ?>
    <div class="col60">
        <? //debug(array_keys($office)) ?>
        <? $objectTitle = getDefaultTranslate('name', $currentLanguage, $office['model']); ?>
        <div class="bc-img col50">
            <a href="<?= $office['model']->slug->slug ?>" class="img_box">
                <img src="<?= $imgSrc ?>" alt=""/>
            </a>
        </div>
        <div class="bc-adres col50">
            <a href="<?= $office['model']->slug->slug ?>" class="place-title">
                <span class="bc-name"><?= $objectTitle ?></span>
            </a>
            <div class="adres">
                <? if ($item->address) : ?>
                    <p><?= $item->address ?></p>
                <? endif; ?>
            </div>
            <? if (count($item->subways) > 0) : ?>
                <? foreach ($item->subways as $sub) : ?>
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

                    $subway = $subwayIco . $sub->subwayDetails->name . ' <span class="about">~</span> ' . $sub->walk_distance . ' м'; ?>
                    <div class="metro_wrapp">
                        <p><?= $subway; ?></p>
                    </div>
                <? endforeach ?>
            <? endif; ?>
        </div>

    </div>
    <div class="col40">
        <div class="title_desc">
            <div class="col">
                <p>Тип:</p>
            </div>
            <div class="col">
                <p><?= Yii::t('app', 'Business center') . ' ' . getDefaultTranslate('name', $currentLanguage, $item->class, true) ?></p>
            </div>
            <div class="col">
                <p>ID: <?= $office['model']->id ?></p>
            </div>
            <div class="star_checkbox like_star">
                <?= WishlistButton::widget([
                    'model' => $office['model'],
                    'anchorActive' => '<i class="fav rem"></i>',
                    'anchorUnactive' => '<i class="fav"></i>',
                    'cssClass' => 'out-wish',
                    'cssClassInList' => 'in-wish',
                    'building' => 'office'
                ]); ?>
            </div>
        </div>
        <div class="inner">
            <div class="office_info">
                <p><b><?= Yii::t('app', 'Office area') . ': ' . $office['model']->m2range ?> м²</b></p>
                <p><b><?= $price ?></b></p>
            </div>
        </div>


    </div>
<? endforeach; ?>
