<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Menu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menu-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-sm-4">
        <h3>Перевод на русский</h3>
        <?= $form->field($model, 'text')->textarea() ?>
    </div>
    <div class="col-sm-4">
        <h3>Перевод на украинский</h3>
    <?= $form->field($model, 'text_ua')->textarea() ?>
    </div>
    <div class="col-sm-4">
        <h3>English version</h3>
    <?= $form->field($model, 'text_en')->textarea() ?>
    </div>


    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'coll')->textInput() ?>

    <?= $form->field($model, 'sort_order')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
