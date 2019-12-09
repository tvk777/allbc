<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Infoblocks Howtouses');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="infoblocks-howtouse-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create New'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'text',
            [
                'attribute' => 'Image',
                'format' => 'raw',
                'value' => function ($model) {
                    if ($model->img->disk_name != '') {
                        $img = Html::img($model->img->imgSrc, ['width' => '50px']);
                        return $img;
                    } else {
                        return 'no image';
                    }
                },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
