<?php
use common\models\GeoCities;
$city = GeoCities::find(1)->one();
$mainRent = $city->slug;
$mainSell = $city->slug_sell;
/* @var $this yii\web\View */

$currentLanguage = Yii::$app->language;


$this->title = getDefaultTranslate('title', $currentLanguage, $model);
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="content-sect">
    <form action="" id="main_form">
        <input name="city_link" type="hidden" id="city_link" value="<?= $mainRent ?>"
               data-valuesell="<?= $mainSell ?>">
        <input name="main_type" type="hidden" id="main_type" value="1">
        <input id="submit_main_form" type="hidden">
    </form>
    <div class="row">
        <h1><?= getDefaultTranslate('name', $currentLanguage, $model); ?></h1>

        <?= getDefaultTranslate('content', $currentLanguage, $model); ?>
    </div>
</section>
