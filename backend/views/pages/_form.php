<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\widgets\MultiLangTabsWidget;

/* @var $this yii\web\View */
/* @var $model common\models\Pages */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pages-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <? echo  $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>


    <?= MultiLangTabsWidget::widget([
        'model' => $model,
        'attributes' => [
            'name' => 0,
            'content' => 1,
            'title' => 0,
            'description' => 0,
            'keywords' => 0,
        ], 
        'form' => $form])
    ?>

    <?= $form->field($model, 'enable')->radio(); ?>




    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
