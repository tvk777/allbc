<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\BcPlaces */

$this->title = Yii::t('app', 'Create Bc Places');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bc Places'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bc-places-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
