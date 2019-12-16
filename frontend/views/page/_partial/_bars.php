<?php
use yii\helpers\Html;
$counts = [];

if(!empty($bars)){
    if($type==1){
        $counts = $bars['type1']['count'];
        $maxTotalPrice = round($bars['type1']['max']/$rate);
        if(empty($minmax)) {
          $minPrice = round($bars['type1']['min']/$rate);
          $maxPrice = round($bars['type1']['max']/$rate);
          $minmax = [$minPrice, $maxPrice];   
        }
    } else {
        $counts = $bars['type3']['count'];
        $maxTotalPrice = round($bars['type3']['max']/$rate);
        if(empty($minmax)) {
            $minPrice = round($bars['type3']['min']/$rate);
            $maxPrice = round($bars['type3']['max']/$rate);
            $minmax = [$minPrice, $maxPrice];
        }
    }
}
$js = <<< JS
var currency = $currency;
minPrice = $minmax[0];
maxPrice = $minmax[1];
maxTotalPrice = $maxTotalPrice;
JS;

$this->registerJs( $js, $position = yii\web\View::POS_HEAD, $key = null );

?>
<div class="bars_range_wrapp  type1">
    <div class="bars">
        <? if (!empty($counts)): ?>
            <? foreach ($counts as $k => $val): ?>
                <? $valClass = $val>0 ? 'notnull' : ''?>
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




