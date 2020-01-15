<?php

use common\widgets\MultiLangTabsWidget;
use yii\helpers\ArrayHelper;
use common\models\BcClasses;
use common\models\BcStatuses;
?>
<div class="col-sm-6">
    <? //echo $form->field($office, 'target')->dropDownList(['1' => 'Аренда', '2' => 'Продажа']) ?>

    <?= $form->field($place, 'alias')->textInput(['maxlength' => true]) ?>
    <?= $form->field($place, 'showm2')->textInput() ?>


    <?= $form->field($office, 'class_id')->dropDownList(
        ArrayHelper::map(BcClasses::find()->all(), 'id', 'name')
    ) ?>

    <?= $form->field($office, 'percent_commission')->textInput() ?>
    <?= $form->field($place, 'status_id')->dropDownList(
        ArrayHelper::map(BcStatuses::find()->all(), 'id', 'name')
    ) ?>
    <?= $form->field($place, 'con_price')->checkbox(['0', '1',]) ?>

    <?= $form->field($place, 'price')->textInput() ?>
    <?= $form->field($place, 'valute_id')->textInput() ?>
    <?= $form->field($place, 'price_period')->textInput() ?>

    <? if($office->target===1) echo $form->field($place, 'opex')->textInput(['maxlength' => true]) ?>
    <?= $form->field($place, 'tax')->textInput(['maxlength' => true]) ?>
    <?= $form->field($place, 'kop')->textInput(['maxlength' => true]) ?>

    <?= $form->field($place, 'ai')->checkbox(['0', '1',]) ?>
    <?= $form->field($place, 'commission')->checkbox(['0', '1',]) ?>
    <?= $form->field($place, 'hide')->checkbox(['0', '1',]) ?>
    <?= $form->field($place, 'archive')->checkbox(['0', '1',]) ?>
    <?= $form->field($place, 'hide_bc')->checkbox(['0', '1',]) ?>

</div>
<div class="col-sm-6">
    <?= MultiLangTabsWidget::widget([
        'model' => $place,
        'attributes' => [
            'name' => 0,
            'comment' => 1,
        ],
        'form' => $form]); ?>

</div>

