<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\InfoblocksHowtouse */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="infoblocks-howtouse-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="row">
        <div class="col-sm-4">
            <h3>Перевод на русский</h3>
            <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
            <?= $form->field($model, 'text')->textarea() ?>
        </div>
        <div class="col-sm-4">
            <h3>Перевод на украинский</h3>
            <?= $form->field($model, 'name_ua')->textInput(['maxlength' => 255]) ?>
            <?= $form->field($model, 'text_ua')->textarea() ?>
        </div>
        <div class="col-sm-4">
            <h3>English version</h3>
            <?= $form->field($model, 'name_en')->textInput(['maxlength' => 255]) ?>
            <?= $form->field($model, 'text_en')->textarea() ?>
            <?php echo $form->field($model, 'upload_image')->widget(FileInput::classname(), [
                'options' => ['accept' => 'image/*'],
                'pluginOptions' => [
                    'initialPreviewShowDelete' => true,
                    'allowedFileExtensions' => ['jpg', 'gif', 'png', 'svg'],
                    'showCaption' => false,
                    'showRemove' => false,
                    'showUpload' => false,
                    'browseClass' => 'btn btn-primary btn-block',
                    'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                    'browseLabel' => 'Выбрать картинку',
                    'initialPreview' => Html::img($model->img->imgSrc),
                    'deleteUrl' => Url::toRoute(['infoblocks-howtouse/delete-img', 'id_img' => $model->img->id]),
                    //'initialPreviewAsData'=>true,
                ],
            ]);
            ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
