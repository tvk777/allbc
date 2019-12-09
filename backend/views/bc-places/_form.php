<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\widgets\MultiLangTabsWidget;
use yii\bootstrap\Tabs;
use common\widgets\UploadImagesWidget;
use kartik\file\FileInput;
use yii\helpers\Url;
$config = [];
$preview = [];

if($model->stageImg) {
    $caption = $model->stageImg->title ? $model->stageImg->title : $model->stageImg->file_name;
    $key = $model->stageImg->id;
    $config = [[
        'caption' => $caption,
        'key' => $key
    ]];
    $preview[] = Html::a(Html::img($model->stageImg->imgSrc), ['/system-files/update', 'id' => $model->stageImg->id]);
}



/* @var $this yii\web\View */
/* @var $model common\models\BcPlaces */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="bc-places-form">
    <div class="tabs0">
        <?= Tabs::widget([
            'items' => [
            ],
        ]); ?>
    </div>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'showm2')->textInput() ?>
    <?= $form->field($model, 'stage_name')->textInput(['maxlength' => true]) ?>
    <?= FileInput::widget([
        'name' => 'stageImg',
        'options' => [
            'accept' => 'image/*',
            'id' => 'stageFile',
            'multiple'=>false
        ],
        'pluginOptions' => [
            'deleteUrl' => Url::to(['delete-image']),
            'initialPreview'=> $preview,
            'initialPreviewConfig' => $config,
            'uploadUrl' => Url::to(['upload-stage-image']),
            'fileActionSettings' => [
                'showZoom' => false,
                'showRemove' => true,
                'showUpload' => false,
            ],
        ],
        'pluginEvents' => [
            'fileselect' => new \yii\web\JsExpression('function(event, files){
                 jQuery("#stageFile").fileinput("upload");
            }'),
            'fileuploaded' => new \yii\web\JsExpression('function(event, data, previewId, index) {
                 $(".upfile").val(data.response.initialPreviewConfig[0].key);
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


    <?= MultiLangTabsWidget::widget([
        'model' => $model,
        'attributes' => [
            'comment' => 0,
        ],
        'form' => $form]); ?>

    <?= $form->field($model, 'plan_comment')->checkbox(['0', '1',]) ?>
    <?= $form->field($model, 'status_id')->textInput() ?>
    <?= $form->field($model, 'con_price')->checkbox(['0', '1',]) ?>

    <?= $form->field($model, 'price')->textInput() ?>
    <?= $form->field($model, 'valute_id')->textInput() ?>
    <?= $form->field($model, 'price_period')->textInput() ?>

    <?= $form->field($model, 'opex')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'tax')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'kop')->textInput(['maxlength' => true]) ?>

    <? echo UploadImagesWidget::widget([
        'form' => $form,
        'model' => $model,
    ])
    ?>


    <?= $form->field($model, 'ai')->checkbox(['0', '1',]) ?>
    <?= $form->field($model, 'commission')->checkbox(['0', '1',]) ?>
    <?= $form->field($model, 'hide')->checkbox(['0', '1',]) ?>
    <?= $form->field($model, 'archive')->checkbox(['0', '1',]) ?>

    <?= MultiLangTabsWidget::widget([
        'model' => $model,
        'attributes' => [
            'fio' => 0,
        ],
        'form' => $form]); ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'hide_contacts')->checkbox(['0', '1',]) ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        <?= Html::button(Yii::t('app', 'Cancel'), ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

