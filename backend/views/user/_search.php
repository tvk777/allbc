<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\UserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-search">

    <?php $form = ActiveForm::begin([
        'id' => 'globalSearch',
        'action' => ['index'],
        'method' => 'get',
        'options' => ['data-pjax' => 1]
    ]); ?>

    <?= $form->field($model, 'globalSearch')->textInput([
        'class' => 'global-search',
        'onmouseover' => 'this.setSelectionRange(this.value.length,this.value.length);',
        'onfocus' => 'this.setSelectionRange(this.value.length,this.value.length);'
    ]); ?>

    <?php ActiveForm::end(); ?>

</div>
