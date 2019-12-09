<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GeoCities */

$this->title = Yii::t('app', 'Create Geo Cities');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Geo Cities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="geo-cities-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
