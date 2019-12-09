<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GeoBranch */

$this->title = Yii::t('app', 'Create Geo Branch');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Geo Branches'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="geo-branch-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
