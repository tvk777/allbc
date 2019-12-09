<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Experts */

$this->title = Yii::t('app', 'Users');
Modal::begin([
    'id' => 'modal-users',
    'header' => '<h1>Users</h1>',
    'toggleButton' => ['label' => Yii::t('app', 'Create Experts')],
]);

?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(['enablePushState' => false]); ?>

    <?php echo $this->render('_search', ['model' => $searchModel]);?>

    <?php $form = ActiveForm::begin([
        'id' => 'updateExperts',
        'action' => ['update'],
    ]); ?>

    <?= GridView::widget([
        'id' => 'grid',
        'dataProvider' => $usersProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //'id',
            [
                'class' => 'yii\grid\CheckboxColumn',
                'checkboxOptions' => function ($data, $key, $index, $column) {
                    return ['value' => $data->id];
                }
            ],
            [
                'attribute' => 'name',
                'filter' => false,
            ],
            [
                'attribute' => 'username',
                'filter' => false,
            ],
            [
                'attribute' => 'phone',
                'filter' => false,
            ],
            [
                'label' => 'Avatar',
                'format' => 'html',
                'value' => function ($data) {
                    $ava = $data->avatar ? Html::img($data->avatar->thumb260x260Src) : '';
                    return $ava;
                },

            ],
        ],
    ]); ?>
    <?= Html::submitButton(Yii::t('app', 'Добавить выбранное'), ['class' => 'btn btn-success']) ?>
    <?= Html::button('Отменить', ['class' => 'close-btn']) ?>
    <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>

</div>

<? Modal::end(); ?>
