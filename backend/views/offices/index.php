<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\OfficesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Offices');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="offices-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Office for Rent'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Create Office for Sale'), ['create-sell'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            [
                'label' => 'Название',
                'value' => function ($data) {
                    return $data->target===1 ? $data->place->name : $data->placesell->name;
                },
                'filter' => false,
            ],
            [
                'attribute' => 'target',
                'label' => 'Аренда/Продажа',
                'format' => 'text',
                'filter' => ['1' => 'Аренда', '2' => 'Продажа'],
                'value' => function ($data) {
                    return $data['target'] == 1 ? 'Аренда' : 'Продажа';
                }
            ],


            //'city_id',
            //'country_id',
            //'district_id',
            //'class_id',
            //'percent_commission',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}'
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',

                'urlCreator'=>function($action, $data, $key, $index){
                    $action = $data['target'] == 1 ? $action : $action.'-sell';
                    return [$action,'id'=>$data->id];
                },
            ],
        ],
    ]); ?>


</div>
