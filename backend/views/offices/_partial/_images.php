<?php

use common\widgets\UploadImagesWidget;
//debug($model->images);
?>
<div class="images-form">
    <?= UploadImagesWidget::widget([
        'form' => $form,
        'model' => $place,
        'uploadAction' => '/bc-places/upload-image',
        'deleteAction' => '/bc-places/delete-image'
])
    ?>
</div>

