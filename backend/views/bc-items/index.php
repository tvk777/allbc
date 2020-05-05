<?php

use yii\helpers\Html;
/*use yii\grid\GridView;*/
use kartik\grid\GridView;
use kartik\editable\Editable;
/* @var $this yii\web\View */
/* @var $searchModel common\models\BcItemsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Bc Items');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bc-items-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Bc Items'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        //'options' => [ 'style' => 'table-layout:fixed' ],
        'columns' => [
            ['class' => 'yii\grid\ActionColumn'],
            'id',
            'name',
            [
                'attribute' => 'name',
                //'headerOptions' => ['style' => 'width:50px'],
            ],
            [
                'attribute' => 'slug.slug',
                'value' => function ($data) {
                    return $data->slug->slug;
                }
            ],
            [
                'attribute' => 'class_id',
                'value' => function ($data) {
                    return $data->class->name;
                }
            ],

            'city_id',
            [
                'attribute' => 'approved',
                'label' => 'Проверенный',
                'format' => 'text',
                'value' => function ($model) {
                    return ($model->approved == 1) ? 'Да' : 'Нет';
                }
            ],
            'sort_order',
            /*[
                'class'=>'kartik\grid\EditableColumn',
                'attribute'=>'sort_order',
                'editableOptions'=>[
                    'header'=>'Buy Amount',
                    //'inputType'=>\kartik\editable\Editable::INPUT_SPIN,
                    'options'=>['pluginOptions'=>['min'=>0, 'max'=>5000]]
                ],
                'hAlign'=>'right',
                'vAlign'=>'middle',
                'width'=>'100px',
                'format'=>['decimal', 2],
                'pageSummary'=>true
            ],*/
            'percent_commission',
            'title',
            'keywords',
            'description',
        ],
    ]); ?>


</div>
