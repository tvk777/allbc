<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\widgets\MultiLangTabsWidget;
use kartik\file\FileInput;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model common\models\Services */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="services-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= MultiLangTabsWidget::widget([
        'model' => $model,
        'attributes' => [
            'name' => 0,
            'short_content' => 0,
            'content' => 1,
            'title' => 0,
            'description' => 0,
            'keywords' => 0,
        ], 
        'form' => $form])
    ?>

    <?= $form->field($model, 'upload_image')->widget(FileInput::classname(), [
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
        ],
    ]);
    ?>

    <?=  $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'enable')->radio(); ?>




    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
