<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$phone = !empty($user->broker_phone) ? $user->broker_phone : $user->phone;
$src = !empty($user->avatar) ? $user->avatar->thumb260x260Src : '';
?>
    <div class="contact_form_order">
        <h2>Записаться на просмотр</h2>
        <div class="contact_form">
            <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
            <div class="input_wrapp_2">
                <?= $form->field($model, 'name')->textInput(['placeholder' => $model->getAttributeLabel('name')])->label(false); ?>
            </div>
            <div class="input_wrapp_2">
                <?= $form->field($model, 'email')->textInput(['placeholder' => $model->getAttributeLabel('email')])->label(false); ?>
            </div>
            <div class="input_wrapp_2">
                <?= $form->field($model, 'phone')->textInput(['placeholder' => $model->getAttributeLabel('phone')])->label(false); ?>
            </div>
            <div class="input_wrapp_2">
                <?= $form->field($model, 'body')->textarea(['rows' => 4, 'placeholder' => $model->getAttributeLabel('body')])->label(false) ?>
            </div>
            <div class="submit_wrapp">
                <?= Html::submitButton('Send Message', ['class' => 'green_pill', 'name' => 'order-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
