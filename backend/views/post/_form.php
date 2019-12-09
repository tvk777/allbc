<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\widgets\UploadImagesWidget;
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'enabled')->checkbox(['0', '1',])  ?>


    <? echo UploadImagesWidget::widget([
        'form' => $form,
        'model' => $model,
        //'uploadAction' => 'post/upload-image',
        //'deleteAction' => 'post/delete-image',
        //'allwoedFiles' => ['png', 'gif', 'jpg'],
        //'maxFileCount' => 5,
        //'field' => 'img'
    ])
    ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>




</div>
