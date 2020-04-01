<?php
$currentLanguage = Yii::$app->language;

use yii\widgets\Breadcrumbs;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$target = $targetUrls['target'];
$targetUrl = $target == 2 ? $targetUrls['sell']['url'] : $targetUrls['rent']['url'];

$this->params['breadcrumbs'][] = [
    'label' => $target == 2 ? $targetUrls['sell']['label'] : $targetUrls['rent']['label'],
    'url' => $targetUrl
];
$this->params['breadcrumbs'][] = Yii::t('app', 'Favorite');

?>

<section class="grey_bg favorite">
    <form action="" id="main_form">
        <input name="city_link" type="hidden" id="city_link" value="<?= $targetUrls['rent']['url'] ?>"
               data-valuesell="<?= $targetUrls['sell']['url'] ?>">
        <input name="main_type" type="hidden" id="main_type" value="<?= $target ?>">
        <input id="submit_main_form" type="hidden">
    </form>

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
        <div class="remove-fav">
        <?= Html::a('Удалить все', ['page/remove-favorites'], [
            'data-method' => 'POST',
            'data-params' => [
                'link' => $targetUrl,
            ],
            'class' => 'remove-link']) ?>
        </div>
    </div>
    <? //debug(count($model)); ?>
    <? foreach ($model as $key => $one) : ?>

        <div class="object_center_templ clearfix">
            <? if ($key !== 'offices') : ?>
                <div class="col60">
                    <div class="bc-img col50">
                        <? $bcName = getDefaultTranslate('name', $currentLanguage, $one['bc']) ?>
                        <? if ($one['bc']->images) : ?>
                            <a href="/<?= $one['bc']->slug->slug ?>" class="img_box">
                                <img
                                    src="<?= $one['bc']->images[0]->thumb300x200Src ?>"
                                    alt="<?= $bcName ?>"
                                />
                            </a>
                        <? endif; ?>
                    </div>
                    <div class="bc-adres col50">
                        <a href="/<?= $one['bc']->slug->slug ?>">
                            <span class="bc-name"><?= $bcName ?></span>
                        </a>
                        <div class="adres">
                            <? if ($one['bc']->address) : ?>
                                <p><?= $one['bc']->address ?></p>
                            <? endif; ?>
                        </div>
                        <? if (count($one['bc']->subways) > 0) : ?>
                            <? foreach ($one['bc']->subways as $sub) : ?>
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
                    <? if ($one['target'] == 1) {
                        echo $this->render('_item-partial/_fav-places', [
                            'places' => $one['places'],
                        ]);
                    } else {
                        echo $this->render('_item-partial/_fav-placesSell', [
                            'places' => $one['places'],
                        ]);
                    } ?>
                </div>
            <? else: ?>
                <?= $this->render('_item-partial/_fav-offices', [
                    'offices' => $one,
                ]); ?>

            <? endif; ?>

        </div>
    <? endforeach; ?>

</section>