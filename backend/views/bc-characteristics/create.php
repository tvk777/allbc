<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\BcCharacteristics */

$this->title = Yii::t('app', 'Create Bc Characteristics');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bc Characteristics'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bc-characteristics-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
