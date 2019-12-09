<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\widgets\MultiLangTabsWidget;


/* @var $this yii\web\View */
/* @var $model common\models\Services */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="services-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'enable')->textInput() ?>

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




    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
