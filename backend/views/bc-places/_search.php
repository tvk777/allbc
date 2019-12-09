<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\BcPlacesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bc-places-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'created_at') ?>

    <?= $form->field($model, 'updated_at') ?>

    <?= $form->field($model, 'item_id') ?>

    <?= $form->field($model, 'm2') ?>

    <?php // echo $form->field($model, 'm2min') ?>

    <?php // echo $form->field($model, 'valute_id') ?>

    <?php // echo $form->field($model, 'stage_name') ?>

    <?php // echo $form->field($model, 'price_period') ?>

    <?php // echo $form->field($model, 'ai') ?>

    <?php // echo $form->field($model, 'commission') ?>

    <?php // echo $form->field($model, 'opex') ?>

    <?php // echo $form->field($model, 'plan_comment') ?>

    <?php // echo $form->field($model, 'hide') ?>

    <?php // echo $form->field($model, 'archive') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'con_price') ?>

    <?php // echo $form->field($model, 'tax') ?>

    <?php // echo $form->field($model, 'kop') ?>

    <?php // echo $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'status_id') ?>

    <?php // echo $form->field($model, 'rent') ?>

    <?php // echo $form->field($model, 'hits') ?>

    <?php // echo $form->field($model, 'hide_contacts') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
