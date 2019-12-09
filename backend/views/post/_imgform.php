<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(['action' => ['update', 'id' =>$id]]); ?>

    <? //echo $form->errorSummary($imageData); ?>

    <?= $form->field($imageData, 'disk_name')->textInput() ?>

    <?= $form->field($imageData, 'title')->textInput() ?>

    <?= $form->field($imageData, 'description')->textInput() ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>



</div>
