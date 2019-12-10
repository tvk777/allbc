<?php
//use common\widgets\GooglePlacesAutoComplete;
//надо добавить поиск адреса и карту; поменять id на названия
//['types' => ['address']
//['types' => ['(cities)']
//['types' => ['(regions)']
use common\widgets\GooglePlacesAutoComplete;
$this->registerJsFile('//maps.googleapis.com/maps/api/js?' . http_build_query([
        'libraries' => 'places',
        'language' => 'ru',
        'key' => Geo::getGoogleKey(),
    ]),['position' => $this::POS_END, 'async'=>'async', 'defer'=>'defer']);
?>
<div id="locationField">
</div>

<div class="col-sm-6">
    <label class="control-label" for="place">Поиск (адрес)</label>
    <? echo GooglePlacesAutoComplete::widget(
        [
            'name' => 'place',
            'autocompleteOptions' => ['types' => ['address']],
        ]); ?>

    <input type="hidden" id="address_autocomplate_value" name="address_location">
    <label class="control-label" for="GeoCities[name]">Город</label>
    <? echo GooglePlacesAutoComplete::widget(
        [
            'model' => $model->city,
            'attribute' => 'name',
            'autocompleteOptions' => ['types' => ['(cities)']],
            'geotype' => 'city'
        ]); ?>
    <?= $form->field($model, 'city_id')->hiddenInput(['id' => 'city_autocomplate_value'])->label(false) ?>

    <?= $form->field($model, 'street')->textInput(['id' => 'street_autocomplate_name']) ?>
</div>
<div class="col-sm-6">
    <label class="control-label" for="GeoCountries[name]">Страна</label>
    <? echo GooglePlacesAutoComplete::widget(
        [
            'model' => $model->country,
            'attribute' => 'name',
            'autocompleteOptions' => ['types' => ['(regions)']],
            'geotype' => 'country'
        ]); ?>
    <?= $form->field($model, 'country_id')->hiddenInput(['id' => 'country_autocomplate_value'])->label(false) ?>

    <label class="control-label" for="GeoDistricts[name]">Район</label>
    <? echo GooglePlacesAutoComplete::widget(
        [
            'model' => $model->district,
            'attribute' => 'name',
            'autocompleteOptions' => ['types' => ['(regions)']],
            'geotype' => 'district'
        ]); ?>
    <?= $form->field($model, 'district_id')->hiddenInput(['id' => 'district_autocomplate_value'])->label(false) ?>

    <?= $form->field($model, 'latlng')->textInput(['id' => 'latlng_autocomplate_name']) ?>
    <?= $form->field($model, 'lat')->hiddenInput(['id' => 'lat_autocomplate_value'])->label(false) ?>
    <?= $form->field($model, 'lng')->hiddenInput(['id' => 'lng_autocomplate_value'])->label(false) ?>
</div>
<div class="col-sm-6">
    <div class="subways">
        <?php //debug($model->subways);
        foreach ($model->subways as $subway): ?>
            <?= $form->field($subway, 'subway_id')->textInput(['class' => 'subway-name'])->label(false); ?>
            <?= $form->field($subway, 'walk_distance')->textInput(['placeholder' => $model->getAttributeLabel('walk_distance'), 'class' => 'subway-dig'])->label(false); ?>
            <?= $form->field($subway, 'walk_seconds')->textInput(['placeholder' => $model->getAttributeLabel('walk_seconds'), 'class' => 'subway-dig'])->label(false); ?>
            <span class="clearfix">&nbsp;</span>
        <?php endforeach; ?>
    </div>
    <?= $form->field($model, 'shuttle')->textInput() ?>
</div>



