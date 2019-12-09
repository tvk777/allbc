<?php

use common\widgets\UploadImagesWidget;
//debug($model->images);
?>
<div class="images-form">
    <?= UploadImagesWidget::widget([
        'form' => $form,
        'model' => $model,
    ])
    ?>
</div>

