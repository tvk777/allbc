<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Pjax;
?>

<div class="contact_popup">
    <div class="contact_popup_header">
        <button type="button" class="close close_btn" data-dismiss="modal" aria-label="Close">
            <i class="close_white"></i></button>
        <div class="contact_person_desc">
            <h1><?= Yii::t('app', 'Subscribe to updates') ?></h1>
        </div>
    </div>
    <div class="contact_form_wrapp">
        <div class="contact_form2">
            <?php Pjax::begin(['enablePushState' => false, 'id' => 'pjax_form']); ?>
            <?php $form = ActiveForm::begin([
                'action' => yii\helpers\Url::to(['site/subscription']),
                'options' => [
                    'data-pjax' => true,
                ],
            ]); ?>
            <div class="input_wrapp_2">
                <?=$form->field($model, 'email')->textInput(['autofocus' => true,'placeholder'=>'E-mail'])->label(false);?>
            </div>
            <?=Html::submitButton('Подписаться',  ['class' => 'green_pill']); ?>
            <?php ActiveForm::end(); ?>
            <?php Pjax::end(); ?>
            <div style="clear:both;"></div>
        </div>
    </div>
</div>
