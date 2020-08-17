<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

//use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel common\models\BcItemsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Bc Items');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bc-items-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin() ?>

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= Html::beginForm(['delete-selected'], 'post', ['class' => 'batch-action']); ?>
    <p>
        <?= Html::a(Yii::t('app', 'Create Bc Items'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::submitButton('Удалить выбранное', ['class' => 'btn btn-primary remove-selection']); ?>
    </p>
    <?= GridView::widget([
        'tableOptions' => [
            'class' => 'table table-striped table-bordered table-hover table-condensed'
        ],
        'rowOptions' => function ($model) {
            return [
                'class' => 'linkable',
                'data-link' => Url::to(['/bc-items/update', 'id' => $model->id])
            ];
        },
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'options' => ['style' => 'table-layout:fixed'],
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
                'checkboxOptions' => function ($model) {
                    return ['value' => $model->id];
                },
                'contentOptions' => ['class' => 'action-column'],
            ],
            ['class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['class' => 'action-column'],
            ],
            'id',
            [
                'attribute' => 'name',
                'headerOptions' => ['style' => 'max-width:50px'],
            ],
            [
                'label' => 'link',
                'attribute' => 'link',
                'value' => function ($data) {
                    return $data->link;
                }
            ],
            [
                'attribute' => 'class_id',
                'value' => function ($data) {
                    return $data->class->mid_name;
                }
            ],
            [
                'attribute' => 'city_id',
                'value' => function ($data) {
                    return $data->city->name;
                }
            ],

            [
                'attribute' => 'approved',
                'label' => 'Проверенный',
                'format' => 'text',
                'value' => function ($model) {
                    return ($model->approved == 1) ? 'Да' : 'Нет';
                }
            ],
            'sort_order',
            'percent_commission',
            'title',
            'keywords',
            'description',
        ],
    ]); ?>
    <?= Html::endForm(); ?>
    <?php Pjax::end() ?>
</div>
