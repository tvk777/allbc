<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ServicesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Services');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="services-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Services'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            [
                'attribute' => 'slug.slug',
                'value' => function ($data) {
                    return $data->slug->slug;
                }
            ],
            [
                'attribute' => 'Image',
                'format' => 'raw',
                'value' => function ($model) {
                    if ($model->img->disk_name != '') {
                        $img = Html::img($model->img->imgSrc, ['width' => '150px']);
                        return $img;
                    } else {
                        return 'no image';
                    }
                },
            ],
            [
                'attribute' => 'enable',
                //'label' => Yii::t('app', 'Publish status'),
                'format' => 'text',
                'value' => function ($model) {
                    return $model->enable ? Yii::t('app', 'Published') : Yii::t('app', 'Not Published');
                }
            ],


            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
