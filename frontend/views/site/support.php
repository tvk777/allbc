<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Mail to support';
?>

<div class="contact_popup">
    <div class="contact_popup_header">
        <button type="button" class="close close_btn" data-dismiss="modal" aria-label="Close"><i
                class="close_white"></i></button>

        <div class="contact_person_desc">
            <h1><?= Yii::t('app', 'Mail to support') ?></h1>
        </div>
    </div>
    <div class="contact_form_wrapp">
        <div class="contact_form2">
            <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

            <div class="input_wrapp_2">
                <?= $form->field($model, 'name')->textInput(['autofocus' => true, 'placeholder' => Yii::t('app', 'Name')])->label(false)  ?>
            </div>

            <div class="input_wrapp_2">
                <?= $form->field($model, 'email')->textInput(['placeholder' => 'E-mail'])->label(false)   ?>
            </div>
            <div class="input_wrapp_2">
                <?= $form->field($model, 'subject')->textInput(['placeholder' => Yii::t('app', 'Subject')])->label(false) ?>
            </div>
            <div class="input_wrapp_2">
                <?= $form->field($model, 'body')->textarea(['rows' => 6, 'placeholder' => Yii::t('app', 'Message')])->label(false) ?>
            </div>

            <div class="input_buttons">
                <?= Html::submitButton(Yii::t('app', 'Send'), ['class' => 'green_pill', 'name' => 'contact-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
