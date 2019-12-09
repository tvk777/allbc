<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\GeoCitiesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="geo-cities-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'created_at') ?>

    <?= $form->field($model, 'updated_at') ?>

    <?= $form->field($model, 'active') ?>

    <?php // echo $form->field($model, 'country_id') ?>

    <?php // echo $form->field($model, 'place_id') ?>

    <?php // echo $form->field($model, 'lat') ?>

    <?php // echo $form->field($model, 'lng') ?>

    <?php // echo $form->field($model, 'slug') ?>

    <?php // echo $form->field($model, 'sort_order') ?>

    <?php // echo $form->field($model, 'bc_count') ?>

    <?php // echo $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'contacts_open') ?>

    <?php // echo $form->field($model, 'offices_open') ?>

    <?php // echo $form->field($model, 'zoom') ?>

    <?php // echo $form->field($model, 'openstreetmapid') ?>

    <?php // echo $form->field($model, 'inflect') ?>

    <?php // echo $form->field($model, 'slug_sell') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
