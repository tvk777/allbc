<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use common\widgets\MultiLangTabsWidget;

/* @var $this yii\web\View */
/* @var $model common\models\Texts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="texts-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= MultiLangTabsWidget::widget(['model' => $model, 'attributes' => ['content' => 1], 'form' => $form]) ?>

    <?= $form->field($model, 'text_type')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
