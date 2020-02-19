<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$login = Yii::t('app', 'Login');
$signin = Yii::t('app', 'Sign in');
$signup = Yii::t('app', 'Sign up');
$resetpass = Yii::t('app', 'Reset password');

$this->title = $signin;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contact_popup">
    <div class="contact_popup_header">
        <button type="button" class="close close_btn" data-dismiss="modal" aria-label="Close"><i
                class="close_white"></i></button>

        <div class="contact_person_desc">
                <h1><?= Html::encode($this->title) ?></h1>
        </div>
    </div>
    <div class="contact_form_wrapp">
        <div class="contact_form2">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <div class="input_wrapp_2">
                <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => 'E-mail'])->label(false) ?>
            </div>

            <div class="input_wrapp_2">
                <?= $form->field($model, 'password')->passwordInput(['placeholder' => $model->getAttributeLabel('password')])->label(false) ?>
            </div>

                <?= $form->field($model, 'rememberMe')->checkbox(['template' => '<div class="checkbox">{input}{label}{error}{hint}</div>']) ?>

            <div class="input_buttons">
                <?= Html::submitButton($login, ['class' => 'green_pill', 'name' => 'login-button']) ?>
                <?= Html::a($signup, ['site/signup'], ['class' => 'green_pill modal-form size-middle']) ?>
            </div>

            <?php ActiveForm::end(); ?>
            <div>
                <?= Html::a($resetpass, ['site/request-password-reset'], ['class' => 'pass_link']) ?>
            </div>
        </div>
    </div>
</div>
