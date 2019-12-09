<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\i18n\Formatter;

/* @var $this yii\web\View */
/* @var $model common\models\InfoblocksHowtouse */
$this->title = Yii::t('app', 'Update').' '.$model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Infoblocks Howtouses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="infoblocks-howtouse-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'created_at',
                'format' =>  ['date', 'dd.MM.Y'],
            ],
            [
                'attribute' => 'updated_at',
                'format' =>  ['date', 'dd.MM.Y'],
            ],
            'name',
            'text',
            'name_ua',
            'text_ua',
            'name_en',
            'text_en',
            [
                'attribute' => 'Image',
                'format' => 'raw',
                'value' => function ($model) {
                    if ($model->img->disk_name != '') {
                        $img = Html::img($model->img->imgSrc, ['width' => '100px']);
                        return $img;
                    } else {
                        return 'no image';
                    }
                },
            ],

        ],
    ]) ?>

</div>
