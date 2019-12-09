<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-sm-4">
        <h3>Перевод на русский</h3>
        <?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>
        <?= $form->field($model, 'content')->textarea() ?>
    </div>
    <div class="col-sm-4">
        <h3>Перевод на украинский</h3>
        <?= $form->field($model, 'title_ua')->textInput(['maxlength' => 255]) ?>
        <?= $form->field($model, 'content_ua')->textarea() ?>
    </div>
    <div class="col-sm-4">
        <h3>English version</h3>
        <?= $form->field($model, 'title_en')->textInput(['maxlength' => 255]) ?>
        <?= $form->field($model, 'content_en')->textarea() ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
