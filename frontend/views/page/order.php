<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Заявка на просмотр';
$this->params['breadcrumbs'][] = $this->title;
$phone = !empty($user->broker_phone) ? $user->broker_phone : $user->phone;
?>
<div class="contact_popup">
    <div class="contact_popup_header">
        <button type="button" class="close close_btn" data-dismiss="modal" aria-label="Close"><i class="close_white"></i></button>

        <div class="contact_person_desc">
            <div class="col">
                <div class="author_photo author_photo_2">
                    <img src="<?= $user->avatar->thumb260x260Src ?>" alt=""/>
                </div>
            </div>
            <div class="col">
                <h3>ЛМ - <?= $user->name ?></h3>
                <div class="tel_link_2_wrapp"><a class="tel_link_2" href="tel:<?= $phone ?>"><?= $phone ?></a>
                </div>
            </div>
        </div>
    </div>
    <div class="contact_form_wrapp">
        <h3>Записаться на просмотр</h3>
        <div class="contact_form">
            <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
            <div class="input_wrapp_2">
                <?= $form->field($model, 'name')->textInput(['autofocus' => true, 'placeholder' => $model->getAttributeLabel('name')])->label(false); ?>
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
</div>
