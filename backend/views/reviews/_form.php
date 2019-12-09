<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\widgets\MultiLangTabsWidget;
use common\widgets\UploadImagesWidget;
use kartik\file\FileInput;
$config = [];
$preview = [];

if($model->logo) {
    $caption = $model->logo->file_name;
    $key = $model->logo->id;
    $config = [[
        'caption' => $caption,
        'key' => $key
    ]];
    $preview[] = Html::img($model->logo->imgSrc);
}
/* @var $this yii\web\View */
/* @var $model common\models\Reviews */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reviews-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= FileInput::widget([
        'name' => 'logo',
        'options' => [
            'multiple'=>false,
            'accept' => 'image/*',
            'id' => 'logoFile'
        ],
        'pluginOptions' => [
            'deleteUrl' => Url::to(['delete-image']),
            'initialPreview'=> $preview,
            'initialPreviewConfig'=>$config,
            'maxFileCount' => 1,
            'overwriteInitial'=>false,
            'uploadUrl' => Url::to(['upload-logo']),
            'fileActionSettings' => [
                'showZoom' => false,
                'showRemove' => true,
                'showUpload' => true,
            ],
            'validateInitialCount' => true,
        ],
        'pluginEvents' => [
            'fileselect' => new \yii\web\JsExpression('function(event, files){
                 jQuery("#logoFile").fileinput("upload");
            }'),
            'fileuploaded' => new \yii\web\JsExpression('function(event, data, previewId, index) {
                 var key = data.response.initialPreviewConfig[0].key;
                 $(".uplogo").val(key);
            }'),
            'filedeleted' => new \yii\web\JsExpression('function(event, key, jqXHR, data) {
                 deleted.push(key);
                 $(".dellogo").val(deleted);
                 $(".uplogo").val("");
            }'),
        ],

    ]); ?>

    <?= $form->field($model, 'uplogo')->hiddenInput(['class' => 'uplogo'])->label(false) ?>
    <?= $form->field($model, 'dellogo')->hiddenInput(['class' => 'dellogo'])->label(false) ?>
    
    
    
    <?= MultiLangTabsWidget::widget([
        'model' => $model,
        'attributes' => [
            'text' => 1,
            'name' => 0,
            'position' => 0,
        ],
        'form' => $form]); ?>

    <?= UploadImagesWidget::widget([
        'form' => $form,
        'model' => $model,
        'multi' => false,
    ])
    ?>


    <?= $form->field($model, 'video')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'is_public')->checkbox(['0', '1',]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
