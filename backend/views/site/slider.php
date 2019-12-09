<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\Url;

?>

<div class="partnerss-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= FileInput::widget([
        'name' => 'Images[]',
        'options' => [
            'multiple' => true,
            'accept' => 'image/*',
            'id' => 'imageFiles'
        ],
        'pluginOptions' => [
            'deleteUrl' => Url::toRoute(['delete-slide']),
            'initialPreview' => $imagesLinks,
            'initialPreviewConfig' => $imagesLinksData,
            'overwriteInitial' => false,
            'allowedFileExtensions' => ['jpg', 'png', 'gif'],
            'uploadUrl' => Url::to(['upload-slide']),
            'fileActionSettings' => [
                'showZoom' => false,
                'showRemove' => true,
                'showUpload' => false,
            ],
        ],
        'pluginEvents' => [
            'filebatchselected' => new \yii\web\JsExpression('function(event, files){
                 jQuery("#imageFiles").fileinput("upload");
            }'),
            'filesorted' => new \yii\web\JsExpression('function(event, params){
                  $.post("' . Url::toRoute(["sort-slide"]) . '",{sort: params});
            }'),
        ],

    ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

</div>

