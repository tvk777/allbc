<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\GeoSubwaysSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Geo Subways');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="geo-subways-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Geo Subways'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'place_id',
            'created_at',
            'updated_at',
            //'lat',
            //'lng',
            //'city_id',
            //'branch_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
