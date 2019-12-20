<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Offices */

$this->title = Yii::t('app', 'Update Offices: {name}', [
    'name' => $office->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Offices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $office->id, 'url' => ['view', 'id' => $office->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="offices-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'office' => $office,
        'place' => $place
    ]) ?>

</div>
