<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\widgets\MultiLangTabsWidget;
use yii\jui\DatePicker;
use common\widgets\UploadImagesWidget;


/* @var $this yii\web\View */
/* @var $model common\models\Services */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <? echo  $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>

    <? echo UploadImagesWidget::widget([
        'form' => $form,
        'model' => $model,
        'multi' => false,
    ])
    ?>


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

    <?= $form->field($model, 'published_at')->widget(DatePicker::class, [
        'language' => 'ru',
        'dateFormat' => 'dd-MM-yyyy',
    ]) ?>

    <?= $form->field($model, 'enable')->radio(); ?>




    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
