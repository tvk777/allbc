<?php
use common\models\Geo;
use yii\helpers\Html;
$this->registerJsFile('//maps.googleapis.com/maps/api/js?' . http_build_query([
        'libraries' => 'places',
        'language' => 'ru',
        'key' => Geo::getGoogleKey(),
    ]),['position' => $this::POS_END, 'async'=>'async', 'defer'=>'defer']);
$this->registerJsFile( '/backend/web/js/autocomplete/geo.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

if(count($model->subways)>0) {
    foreach ($model->subways as $key => $subway) {
        $subways[$key]['name'] = $subway->subwayDetails->name;
        $subways[$key]['walk_distance'] = $subway->walk_distance;
        $subways[$key]['walk_seconds'] = round($subway->walk_seconds / 60);
        $subways[$key]['subway_id'] = $subway->subway_id;
    }
} else{
    $subways = [];
}
//debug($subways);
?>
<div id="locationField">
</div>

<div class="col-sm-6">
    <label class="control-label" for="place">Поиск (адрес)</label>
    <input type="text" value="" class="form-control" id="address_autocomplate_name">
    <input type="hidden" id="address_autocomplate_value" name="address_location">

    <?= $form->field($model, 'cityName')->textInput(['id' => 'city_autocomplate_name']) ?>
    <?= $form->field($model, 'city_id')->hiddenInput(['id' => 'city_autocomplate_value'])->label(false) ?>

    <?= $form->field($model, 'street')->textInput(['id' => 'street_autocomplate_name']) ?>
</div>
<div class="col-sm-6">
    <?= $form->field($model, 'countryName')->textInput(['id' => 'country_autocomplate_name']) ?>
    <?= $form->field($model, 'country_id')->hiddenInput(['id' => 'country_autocomplate_value'])->label(false) ?>

    <?= $form->field($model, 'districtName')->textInput(['id' => 'district_autocomplate_name']) ?>
    <?= $form->field($model, 'district_id')->hiddenInput(['id' => 'district_autocomplate_value'])->label(false) ?>

    <?= $form->field($model, 'latlng')->textInput(['id' => 'latlng_autocomplate_name']) ?>
    <?= $form->field($model, 'lat')->hiddenInput(['id' => 'lat_autocomplate_value'])->label(false) ?>
    <?= $form->field($model, 'lng')->hiddenInput(['id' => 'lng_autocomplate_value'])->label(false) ?>
    <div id="gmapbox"> </div>
</div>
<div class="col-sm-6">
    <div class="subways">
        <?php
        for ($i = 0; $i <= 2; $i++) {
            $subwayName = isset($subways[$i]['name']) ? $subways[$i]['name'] : '';
            $subwayDistance = isset($subways[$i]['walk_distance']) ? $subways[$i]['walk_distance'] : '';
            $subwaySeconds = isset($subways[$i]['walk_seconds']) ? $subways[$i]['walk_seconds'] : '';
            $subwayId = isset($subways[$i]['subway_id']) ? $subways[$i]['subway_id'] : '';
            ?>

            <?= Html::textInput('Subways['.$i.'][name]', $subwayName, [
                'class' => 'subway-name form-control',
                'id' => 'subway'.$i.'_autocomplate_name',
                'onkeyup' => 'js:if($(this).val()=="")$("#subway'.$i.'_autocomplate_value").val("");'
            ]); ?>
            <?= Html::textInput('Subways['.$i.'][walk_distance]', $subwayDistance, [
                'class' => 'subway-dig form-control',
                'id' => 'subway'.$i.'_autocomplate_range',
                'placeholder' => 'метры'
            ]); ?>
            <?= Html::textInput('Subways['.$i.'][walk_seconds]', $subwaySeconds, [
                'class' => 'subway-dig form-control',
                'id' => 'subway'.$i.'_autocomplate_time',
                'placeholder' => 'минуты'
            ]); ?>
            <?= Html::hiddenInput('Subways['.$i.'][subway_id]', $subwayId, [
                'class' => 'subway-name form-control',
                'id' => 'subway'.$i.'_autocomplate_value'
            ]); ?>
        <? } ?>
    </div>
    <?= $form->field($model, 'shuttle')->textInput() ?>
</div>

