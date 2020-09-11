<?php
use yii\helpers\Html;

$counts = [];
//debug($bars);
if (!empty($bars)) {
    $counts = $bars['count'];
    $maxRange = round($bars['maxVal'] / $rate);
    $minRange = round($bars['min'] / $rate);
    if (empty($minmax)) {
        $minPrice = round($bars['min'] / $rate);
        $maxPrice = round($bars['maxVal'] / $rate);
        $minmax = [$minPrice, $maxPrice];
    }
}
switch ($currency) {
    case 1:
        $currencySymbol = '₴';
        break;
    case 2:
        $currencySymbol = '$';
        break;
    case 3:
        $currencySymbol = '€';
        break;
    case 4:
        $currencySymbol = '₽';
        break;
    default:
        $currencySymbol = '₴';
        break;
}
$emptyPriceText = $currencySymbol . ', '.Yii::t('app', 'Price');

$js = <<< JS
var currency = $currency,
minPrice = $minmax[0],
maxPrice = $minmax[1],
maxRange = $maxRange,
minRange = $minRange,
priceText = '$emptyPriceText',
currencySymbol = '$currencySymbol';
JS;

$this->registerJs($js, $position = yii\web\View::POS_HEAD, $key = null);

?>
<div class="bars_range_wrapp  type1">
    <div class="bars">
        <? if (!empty($counts)): ?>
            <? foreach ($counts as $k => $val): ?>
                <? $valClass = $val > 0 ? 'notnull' : '' ?>
                <div class="bar <?= $valClass ?>" data-count-val="<?= $val ?>"></div>
            <? endforeach; ?>
        <? endif; ?>
    </div>
    <div class="range_slider_wrapp">
        <div id="range_slider_2"></div>
    </div>
</div>
<div class="range_inputs  type1">
    <div class="input_wrapp inline">
        <?= Html::input('number', null, null, ['id' => 'input-number_1']) ?>
        <?= Html::input('hidden', 'filter[pricemin]', $minmax[0], ['id' => 'minpricem2']) ?>
    </div>
    <div class="slash inline"></div>
    <div class="input_wrapp inline">
        <?= Html::input('number', null, null, ['id' => 'input-number_2']) ?>
        <?= Html::input('hidden', 'filter[pricemax]', $minmax[1], ['id' => 'maxpricem2']) ?>
    </div>
</div>




