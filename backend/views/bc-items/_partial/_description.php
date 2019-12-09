<?php

use common\widgets\MultiLangTabsWidget;
use common\models\BcClasses;
?>
<div class="col-sm-6">
    <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'class_id')->dropDownList(
        \yii\helpers\ArrayHelper::map(BcClasses::find()->all(), 'id', 'name')
    ) ?>

    <?= $form->field($model, 'percent_commission')->textInput() ?>
    <?= $form->field($model, 'total_m2')->textInput() ?>
    <?= $form->field($model, 'active')->checkbox(['0', '1',]) ?>
    <?= $form->field($model, 'hide')->checkbox(['0', '1',]) ?>
    <?= $form->field($model, 'hide_contacts')->checkbox(['0', '1',]) ?>
    <?= $form->field($model, 'approved')->checkbox(['0', '1',]) ?>
</div>
<div class="col-sm-6">
<?= MultiLangTabsWidget::widget([
    'model' => $model,
    'attributes' => [
        'name' => 0,
        'annons' => 1,
        'content' => 1,
        'mgr_content' => 1,
    ],
    'form' => $form]); ?>
</div>

