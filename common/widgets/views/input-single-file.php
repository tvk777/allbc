<?php
use kartik\file\FileInput;
?>

<?= FileInput::widget([
    'name' => 'image',
    'options' => [
        'multiple'=>false,
        'accept' => 'image/*',
        'id' => 'imageFile'
    ],
    'pluginOptions' => [
        'deleteUrl' => $deleteAction,
        'initialPreview'=> $initialPreview,
        'initialPreviewConfig'=>$initialPreviewConfig,
        'maxFileCount' => 1,
        'overwriteInitial'=>false,
        'uploadUrl' => $uploadAction,
        'fileActionSettings' => [
            'showZoom' => false,
            'showRemove' => true,
            'showUpload' => true,
        ],
        'validateInitialCount' => true,
    ],
    'pluginEvents' => [
        'fileselect' => new \yii\web\JsExpression('function(event, files){
                 jQuery("#imageFile").fileinput("upload");
            }'),
        'fileuploaded' => new \yii\web\JsExpression('function(event, data, previewId, index) {
                 var key = data.response.initialPreviewConfig[0].key;
                 $(".upfile").val(key);
            }'),
        'filedeleted' => new \yii\web\JsExpression('function(event, key, jqXHR, data) {
                 deleted.push(key);
                 $(".delfile").val(deleted);
                 $(".upfile").val("");
            }'),
    ],

]); ?>

<?= $form->field($model, 'upfile')->hiddenInput(['class' => 'upfile'])->label(false) ?>
<?= $form->field($model, 'delfile')->hiddenInput(['class' => 'delfile'])->label(false) ?>

<?php
$script = <<< JS
   // initialize array    
   var deleted = [];  
JS;
$this->registerJs($script);
?>
