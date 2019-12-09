<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\BcItems */

$this->title = Yii::t('app', 'Create Bc Items');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bc Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bc-items-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form-create', [
        'model' => $model,
        'characteristics' => $characteristics
    ]) ?>

</div>
