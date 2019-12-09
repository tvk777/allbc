<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GeoDistricts */

$this->title = Yii::t('app', 'Create Geo Districts');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Geo Districts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="geo-districts-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
