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

    <?= MultiLangTabsWidget::widget(['model' => $model, 'attributes' => ['content'], 'form' => $form]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    
        <h3>Перевод на русский</h3>
        <?= $form->field($model, 'content_ru')->widget(CKEditor::className(), [
            'editorOptions' => ElFinder::ckeditorOptions('elfinder', [/* Some CKEditor Options */]),
        ]);
        ?>
        <h3>Перевод на украинский</h3>
        <?= $form->field($model, 'content_ua')->widget(CKEditor::className(), [
            'editorOptions' => ElFinder::ckeditorOptions('elfinder'),
        ]);
        ?>
        <h3>English version</h3>
        <?= $form->field($model, 'content_en')->widget(CKEditor::className(), [
            'editorOptions' => ElFinder::ckeditorOptions('elfinder'),
        ]);
        ?>

    <?= $form->field($model, 'text_type')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
