<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $model common\models\BcItems */
/* @var $form yii\widgets\ActiveForm */
//debug($office);
?>

<div class="bc-items-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($place); ?>
    <?= $form->errorSummary($office); ?>

    <? echo Tabs::widget([
        'items' => [
            [
                'label' => 'Описание',
                'content' => $this->render('_partial/_description', [
                    'office' => $office,
                    'place' => $place,
                    'form' => $form
                ]),
                'active' => true
            ],
            [
                'label' => 'Geo',
                'content' => $this->render('_partial/_geo', [
                    'office' => $office,
                    'place' => $place,
                    'form' => $form
                ]),
            ],
            [
                'label' => 'Изображения',
                'content' => $this->render('_partial/_images', [
                    'place' => $place,
                    'form' => $form
                ]),
            ],
            /*[
                            'label' => 'SEO',
                            'content' => $this->render('_partial/_seo', [
                                'office' => $office,
                                'place' => $place,
                                'form' => $form
                            ]),
                        ],
                        [
                            'label' => 'Изображения',
                            'content' => $this->render('_partial/_images', [
                                'office' => $office,
                                'place' => $place,
                                'form' => $form
                            ]),
               ],*/

        ],
    ]); ?>
    <span class="clearfix">&nbsp;</span>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['name' => 'save', 'value' => 1, 'class' => 'btn btn-success form-buttons']) ?>
        <?= Html::submitButton(Yii::t('app', 'Save and Close'), ['name' => 'close', 'class' => 'btn btn-success form-buttons']) ?>
        <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-primary form-buttons']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
