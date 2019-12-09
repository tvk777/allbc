<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GeoCountries */

$this->title = Yii::t('app', 'Create Geo Countries');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Geo Countries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="geo-countries-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
