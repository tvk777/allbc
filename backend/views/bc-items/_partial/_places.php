<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
yii\bootstrap\Modal::begin([
    'id' =>'placeModal',
    'header' => '',
]);
yii\bootstrap\Modal::end();

?>

<?php \yii\widgets\Pjax::begin(); ?>
<p>Аренда</p>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'summary'=> '',
    'rowOptions'=>function ($model, $key){
        $class='modal-view';
        return [
            'data-url'=>Url::to(['/bc-places/update', 'id' => $model->id]),
            'class'=>$class,
            'target' => '#placeModal',
            'toggle' => 'modal',
            'backdrop' => 'static',
        ];
    },

    'columns' => [
        ['attribute' => 'id',
        'filter' => false,
        ],
        ['attribute' => 'stage_name',
            'filter' => false
        ],
        [
            'label' => 'Планировка',
            'format' => 'raw',
            'filter' => false,
            'value' => function ($data) {
                $stageImg = '';
                if($data->stageImg){
                    $stageImg = Html::img($data->stageImg->imgSrc, ['width' => '50px', 'height' => '50px']);
                }
                return $stageImg;
            }

        ],
        [
            'label' => 'Аренда',
            'filter' => false,
            'value' => function ($data) {
                return $data->showPrice;
            }
        ],
            ['attribute' => 'hits',
                'filter' => false
            ],
    ],
]); ?>
<p>Архив аренды</p>
<?= GridView::widget([
    'dataProvider' => $dataProviderArh,
    'summary'=> '',
    'rowOptions'=>function ($model, $key){
        $class='modal-view';
        return [
            'data-url'=>Url::to(['/bc-places/update', 'id' => $model->id]),
            'class'=>$class,
            'target' => '#placeModal',
            'toggle' => 'modal',
            'backdrop' => 'static',
        ];
    },

    'columns' => [
        ['attribute' => 'id',
            'filter' => false,
        ],
        ['attribute' => 'stage_name',
            'filter' => false
        ],
        [
            'label' => 'Планировка',
            'format' => 'raw',
            'filter' => false,
            'value' => function ($data) {
                $stageImg = '';
                if($data->stageImg){
                    $stageImg = Html::img($data->stageImg->imgSrc, ['width' => '50px', 'height' => '50px']);
                }
                return $stageImg;
            }

        ],
        [
            'label' => 'Аренда',
            'filter' => false,
            'value' => function ($data) {
                return $data->showPrice;
            }
        ],
        ['attribute' => 'hits',
            'filter' => false
        ],
    ],
]); ?>

<? $this->registerJs("$(function() {
$('.modal-view').click(function(e) {
$('#placeModal').modal('show').find('.modal-body').load($(this).data('url'));
});
});"); ?>


<?php \yii\widgets\Pjax::end(); ?>




