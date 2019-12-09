<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\Url;

debug($model->imageFile);
?>
<div class="infoblocks-howtouse-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="row">
        <div class="col-sm-12">
            <?php echo FileInput::widget([
                'name' => 'attachment[]',
                'options' => [
                    'multiple' => true
                ],
                'pluginOptions' => [
                    'previewThumbTags' => [
                        ['{TAG_VALUE}' => 'title1'],
                    ],
                    'initialPreview' => [
                        "http://upload.wikimedia.org/wikipedia/commons/thumb/e/e1/FullMoon2010.jpg/631px-FullMoon2010.jpg",
                        "http://upload.wikimedia.org/wikipedia/commons/thumb/6/6f/Earth_Eastern_Hemisphere.jpg/600px-Earth_Eastern_Hemisphere.jpg"
                    ],
                    'initialPreviewAsData' => true,
                    'initialCaption' => "The Moon and the Earth",
                    'initialPreviewConfig' => [
                        ['caption' => 'Moon.jpg', 'title' => 'title1'],
                        ['caption' => 'Earth.jpg', 'title' => 'title2'],
                    ],
                    'initialPreviewThumbTags' => [
                        ['{TAG_VALUE}' => 'title1'],
                        ['{TAG_VALUE}' => 'title2'],
                    ],
                    'overwriteInitial' => false,
                    'maxFileSize' => 2800,
                    'layoutTemplates' => [
                        'modal' => '<div class="modal-dialog modal-lg{rtl}" role="document"><div class="modal-content"><div class="modal-header"><div class="kv-zoom-actions pull-right">{toggleheader}{fullscreen}{borderless}{close}</div><h3 class="modal-title">{heading} <small><span class="kv-zoom-title"></span></small></h3></div><div class="modal-body"><div class="floating-buttons"></div><input type="text" name="title" value="{TAG_VALUE}"/><div class="kv-zoom-body file-zoom-content"></div>{prev} {next}</div></div></div>',
                        //'footer' => '<div class="file-caption-name" style="width:{width}">{caption}</div><input type="text" name="title" value="{title}"/>'
                    ],
                    'otherActionButtons' => '<button class="set-main" type="button"><i class="glyphicon glyphicon-star"></i></button>',
                    'fileActionSettings' => [
                        //'showZoom' => false,
                        'showDelete' => true,
                    ],
                    'showRemove' => false,
                    'showUpload' => false,
                ],
                /*'pluginEvents' => [
                    'change' => 'function(event) {
                alert("File changed");
            }'
                ]*/
            ]); ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

