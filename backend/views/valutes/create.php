<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\BcValutes */

$this->title = Yii::t('app', 'Create Bc Valutes');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bc Valutes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bc-valutes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
