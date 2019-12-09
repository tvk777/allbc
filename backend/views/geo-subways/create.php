<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GeoSubways */

$this->title = Yii::t('app', 'Create Geo Subways');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Geo Subways'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="geo-subways-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
