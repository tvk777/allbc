<?php

use common\widgets\MultiLangTabsWidget;
?>
<div class="col-sm-6">
<?= MultiLangTabsWidget::widget([
    'model' => $model,
    'attributes' => [
        'title' => 0,
        'keywords' => 0,
        'description' => 0,
    ],
    'form' => $form]); ?>

<?= $form->field($model, 'redirect')->textInput() ?>
</div>

