<?php
use yii\helpers\Html;

//debug($characteristics);
?>
<div class="container">
    <?php foreach ($characteristics as $char): ?>
    <div class="row char">
            <div class="col-sm-4">
                <?= Html::img('/img/' . $char->img, ['width' => '50px']) ?>
                <span><?= $char->name ?></span>
            </div>
            <div class="col-sm-8">
                <div class="col-sm-12"><?= Html::input('text', 'characteristics['.$char->id.']['.$lng.']', $char->value[$lng]) ?></div>
            </div>
    </div>
    <?php endforeach; ?>
</div>
