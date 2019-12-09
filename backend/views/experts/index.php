<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Наши эксперты');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="experts-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_text', [
        'model' => $text,
    ]) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'sort_order',
            'active',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <p>

        <?= $this->render('create', [
            'searchModel' => $searchModel,
            'usersProvider' => $usersProvider,
        ]);

        ?>

    </p>
</div>
