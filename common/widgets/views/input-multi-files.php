<?php
use kartik\file\FileInput;
?>

<?= FileInput::widget([
    'name' => 'Images[attachment]',
    'options' => [
        'multiple'=>true,
        'accept' => 'image/*',
        'id' => 'imageFiles'
    ],
    'pluginOptions' => [
        'deleteUrl' => $deleteAction,
        'initialPreview'=> $initialPreview,
        'initialPreviewConfig'=>$initialPreviewConfig,
        'maxFileCount' => $maxFileCount,
        'overwriteInitial'=>false,
        'uploadUrl' => $uploadAction,
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
                 $(".uploaded").val(uploaded);
            }'),
        'filedeleted' => new \yii\web\JsExpression('function(event, key, jqXHR, data) {
                 deleted.push(key);
                 $(".deleted").val(deleted);
            }'),
        'filesorted' => new \yii\web\JsExpression('function(event, params){
                  $.post("'.$sortAction.'",{sort: params});
            }')

    ],

]); ?>

<?= $form->field($model, 'uploaded')->hiddenInput(['class' => 'uploaded'])->label(false) ?>
<?= $form->field($model, 'deleted')->hiddenInput(['class' => 'deleted'])->label(false) ?>

<?php
$script = <<< JS
   // initialize array    
   var deleted = [],uploaded = [];  
JS;
$this->registerJs($script);
?>

