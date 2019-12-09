<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Tabs;


/* @var $this yii\web\View */
/* @var $model common\models\GeoCities */
/* @var $form yii\widgets\ActiveForm */
/**/
?>

<div class="geo-cities-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php
    $ru = $form->field($model, 'name')->textInput(['maxlength' => true]).$form->field($model, 'inflect')->textInput(['maxlength' => true]);
    $ua = $form->field($model, 'name_ua')->textInput(['maxlength' => true]).$form->field($model, 'inflect_ua')->textInput(['maxlength' => true]);
    $en = $form->field($model, 'name_en')->textInput(['maxlength' => true]);
    ?>

    <? echo Tabs::widget([
        'items' => [
            [
                'label' => 'RU',
                'content' => $ru,
                'active' => true
            ],
            [
                'label' => 'UA',
                'content' => $ua,
            ],
            [
                'label' => 'EN',
                'content' => $en,
            ],
        ],
    ]); ?>

    <?= $form->field($model, 'active')->textInput() ?>

    <?= $form->field($model, 'country_id')->textInput() ?>

    <?= $form->field($model, 'lat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lng')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'slug_sell')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sort_order')->textInput() ?>


    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contacts_open')->textInput() ?>

    <?= $form->field($model, 'offices_open')->textInput() ?>

    <?= $form->field($model, 'zoom')->textInput() ?>



    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
