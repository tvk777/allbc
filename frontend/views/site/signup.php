<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contact_popup">
    <div class="contact_popup_header">
        <button type="button" class="close close_btn" data-dismiss="modal" aria-label="Close"><i
                class="close_white"></i></button>

        <div class="contact_person_desc">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
    </div>
    <div class="contact_form_wrapp">
        <div class="contact_form2">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

            <div class="input_wrapp_2">
                <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'placeholder' => 'E-mail'])->label(false) ?>
            </div>

            <div class="input_wrapp_2">
                <?= $form->field($model, 'password')->passwordInput(['placeholder' => $model->getAttributeLabel('password')])->label(false) ?>
            </div>

            <div class="input_buttons">
                <?= Html::submitButton('Signup', ['class' => 'green_pill', 'name' => 'signup-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
