<?php
$currentLanguage = Yii::$app->language;

use yii\widgets\Breadcrumbs;
use yii\helpers\ArrayHelper;

$target = $targetUrls['target'];

/*foreach ($model as $key => $one) {
    if ($key !== 'offices') {
        debug($one['bc']);
    }

}*/

$this->params['breadcrumbs'][] = [
    'label' => $target == 2 ? $targetUrls['sell']['label'] : $targetUrls['rent']['label'],
    'url' => $target == 2 ? $targetUrls['sell']['url'] : $targetUrls['rent']['url']
];
$this->params['breadcrumbs'][] = 'Favorite';
?>

<section class="grey_bg">
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
    </div>
    <? foreach ($model as $key => $one) : ?>
        <div class="object_center_templ clearfix">

            <div class="right">
                <? if($key !== 'offices') : ?>
                    <? foreach ($one['places'] as $k => $place) : ?>
                        <p><?= $place->id.' '.$place->getM2range(); ?></p>
                    <? endforeach; ?>
                <? endif; ?>
            </div>
            <div class="left">
                <? if($key !== 'offices') : ?>
                <?= getDefaultTranslate('name', $currentLanguage, $one['bc']) ?>
            <? endif; ?>
            </div>

        </div>
    <? endforeach; ?>

</section>