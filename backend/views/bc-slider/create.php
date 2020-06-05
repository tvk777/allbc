<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\BcSlider */

$this->title = Yii::t('app', 'Create Bc Slider');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bc Sliders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bc-slider-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
