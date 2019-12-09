<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\InfoblocksHowtouse */

$this->title = Yii::t('app', 'Create Infoblocks Howtouse');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Infoblocks Howtouses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="infoblocks-howtouse-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
