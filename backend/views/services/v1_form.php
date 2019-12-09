<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\widgets\MultiLangTabsWidget;


/* @var $this yii\web\View */
/* @var $model common\models\Services */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="services-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'enable')->textInput() ?>
    <?= $form->field($model, 'name_ru')->textInput() ?>
    <?= $form->field($model, 'short_content_ru')->textInput() ?>
    <?= $form->field($model, 'content_ru')->textInput() ?>




    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
