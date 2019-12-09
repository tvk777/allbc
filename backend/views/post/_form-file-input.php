<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\widgets\ActiveForm */
$allwoedFiles = implode(['jpg', 'png', 'svg'], '-');
//debug($allwoedFiles);
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'enabled')->checkbox(['0', '1',])  ?>


    <? echo FileInput::widget([
        'name' => 'Images[attachment]',
        'options' => [
            'multiple'=>true,
            'accept' => 'image/*',
            'id' => 'imageFiles'
        ],
        'pluginOptions' => [
            'deleteUrl' => Url::toRoute(['delete-img']),
            'initialPreview'=> $model->imagesPreview,
            'initialPreviewConfig'=>$model->imagesLinksData,
            'maxFileCount' => 10,
            //'initialPreviewAsData'=>true,
            'overwriteInitial'=>false,
            //'allowedFileExtensions' =>  ['jpg', 'png','gif'],
            'uploadUrl' => Url::to(['upload-images', 'allwoedFiles' => $allwoedFiles]),
            /*'uploadExtraData' => [
                'attachment_id' => $attachment_id,
                'attachment_type' => $model->tableName(),
                'model' => $model
            ],*/
            //'showRemove' => false,
           // 'showCancel' => false,
            'fileActionSettings' => [
                'showZoom' => false,
                'showRemove' => true,
                'showUpload' => false,
            ],
            'validateInitialCount' => true,
        ],
        'pluginEvents' => [
            'filebatchselected' => new \yii\web\JsExpression('function(event, files){
                 //var filesCount = $("#imageFiles").fileinput("getFilesCount");
                 //var plugin = $("#imageFiles").data("fileinput");
                 //console.log(plugin.initialPreview); // get initialPreview
                 jQuery("#imageFiles").fileinput("upload");
            }'),
			'fileuploaded' => new \yii\web\JsExpression('function(event, data, previewId, index) {
                 var key = data.response.initialPreviewConfig[0].key;
                     uploaded.push(data.response.initialPreviewConfig[0].key);
                 console.log(uploaded);
                 $(".uploaded").val(uploaded);
            }'),
			'filedeleted' => new \yii\web\JsExpression('function(event, key, jqXHR, data) {
                 deleted.push(key);
                 console.log(deleted);
                 $(".deleted").val(deleted);
            }')
        ],

    ]); ?>

    <?= $form->field($model, 'uploaded')->hiddenInput(['class' => 'uploaded'])->label(false) ?>
    <?= $form->field($model, 'deleted')->hiddenInput(['class' => 'deleted'])->label(false) ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>




</div>
<?php
$script = <<< JS
   // initialize array    
   var deleted = [],uploaded = [];  
JS;
$this->registerJs($script);
?>
