<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\widgets\ActiveForm */


$model->tmpid = uniqid('post', true);
if($model->id){
    $attachment_id = $model->id;    
} else{
    $attachment_id = $model->tmpid;
}
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tmpid')->hiddenInput()->label(false) ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'enabled')->checkbox(['0', '1',])  ?>



    <?= FileInput::widget([
        'name' => 'Images[attachment]',
        'options' => [
            'multiple'=>true,
            'id' => 'imageFiles'
        ],
        'pluginOptions' => [
            'deleteUrl' => Url::toRoute(['delete-img']),
            'initialPreview'=> $model->imagesPreview,
            'initialPreviewConfig'=>$model->imagesLinksData,
            //'initialPreviewAsData'=>true,
            'overwriteInitial'=>false,
            'allowedFileExtensions' =>  ['jpg', 'png','gif'],
            'uploadUrl' => Url::to(['upload-images']),
            'uploadExtraData' => [
                'attachment_id' => $attachment_id,
                'attachment_type' => $model->tableName(),
                'model' => $model
            ],
            'showRemove' => false,
            'showCancel' => false,
        ],
        'pluginEvents' => [
            'filebatchselected' => new \yii\web\JsExpression('function(event, files){
                 jQuery("#imageFiles").fileinput("upload");
            }')
        ],

    ]); ?>



    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>



</div>
