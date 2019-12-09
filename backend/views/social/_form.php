<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Social */
/* @var $form yii\widgets\ActiveForm */

$script = "
   $('link-del').click(function(e){
    e.preventDefault();
    $.ajax({
             type:'POST',
             cache: false,
             url: '".Url::to(['deleteimage', 'id' => $model->id])."',
             success  : function(response) {
                 $('.link-del').html(response);
                 $('.postImg').remove();
             }
     });
    });
    
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $('#social-file').change(function(){
        readURL(this);
    });
    
    ";
$this->registerJs($script);


?>

<div class="social-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?php if (!empty($model->icon)) {
        echo Html::img('/uploads/' . $model->icon, $options = ['class' => 'postImg', 'style' => ['width' => '180px']]);
    } ?>
    <img id="blah" />
    <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['deleteimage', 'id' => $model->id], ['class' => 'link-del']); ?>
    <?= $form->field($model, 'file')->fileInput() ?>
    <?= $form->field($model, 'sort_order')->textInput(['maxlength' => true]) ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
