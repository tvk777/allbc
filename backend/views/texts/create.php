<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Texts */

$this->title = Yii::t('app', 'Create Texts');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Texts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="texts-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
