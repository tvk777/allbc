<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Bc Places');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bc-places-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Bc Places'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'created_at',
            'updated_at',
            'item_id',
            'm2',
            //'m2min',
            //'valute_id',
            //'stage_name',
            //'price_period',
            //'ai',
            //'commission',
            //'opex',
            //'plan_comment',
            //'hide',
            //'archive',
            //'price',
            //'con_price',
            //'tax',
            //'kop',
            //'phone',
            //'email:email',
            //'status_id',
            //'rent',
            //'hits',
            //'hide_contacts',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
