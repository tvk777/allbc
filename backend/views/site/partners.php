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
            'multiple'=>true
        ],
        'pluginOptions' => [
            'deleteUrl' => Url::toRoute(['delete-image']),
            'initialPreview'=> $imagesLinks,
            'initialPreviewAsData'=>true,
            'overwriteInitial'=>false,
            'initialPreviewConfig'=>$imagesLinksData,
            'allowedFileExtensions' =>  ['jpg','png','gif'],
            'uploadUrl' => Url::to(['upload-image']),
            'showRemove' => false,
            'showCancel' => false,
            'uploadExtraData' => [
                'Images[class]' => 'partners'
            ],
        ],
        'pluginEvents' => [
            'filesorted' => new \yii\web\JsExpression('function(event, params){
                  $.post("'.Url::toRoute(["sort-image"]).'",{sort: params});
            }'),
        ],

    ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

</div>

