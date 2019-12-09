<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SystemFiles */
/* @var $form yii\widgets\ActiveForm */
?>
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
</button>

<div class="system-files-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= Html::img($model->imgSrc, ['title' => $model->file_name, 'class' => 'img-responsive']) ?>
    <div class="update-img" style="padding:25px 25px 5px 25px;">

        <p>Добавьте заголовок и ссылку для этого слайда.</p>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label('заголовок') ?>

        <?= $form->field($model, 'description')->textInput()->label('ссылка') ?>


        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
            <?= Html::button(Yii::t('app', 'Cancel'), ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
