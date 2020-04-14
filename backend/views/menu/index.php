<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Menus');
$this->params['breadcrumbs'][] = $this->title;
//debug($menu);
?>
<div class="menu-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Menu Item'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?php
    /*echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'text',
            'url',
            'coll',
            'sort_order',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{update}{delete}',
            ],
        ],
    ]); */
    ?>
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>№</th>
            <th>Текст</th>
            <th>Ссылка</th>
            <th>Порядок</th>
            <th class="action-column">&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <tr><td colspan="5">Меню в шапке</td></tr>
        <?php foreach ($topmenu as $key => $item): ?>
            <tr data-key="1">
                <td><?= $key+1 ?></td>
                <td><?= $item->text ?></td>
                <td><?= $item->url ?></td>
                <td><?= $item->sort_order ?></td>
                <td>
                    <a href="/backend/menu/update?id=<?= $item->id ?>" title="Update" aria-label="Update" data-pjax="0">
                        <span class="glyphicon glyphicon-pencil"></span>
                    </a>
                    <a href="/backend/menu/delete?id=<?= $item->id ?>" title="Delete" aria-label="Delete" data-pjax="0"
                       data-confirm="Are you sure you want to delete this item?" data-method="post">
                        <span class="glyphicon glyphicon-trash"></span>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        <tr><td colspan="5">Меню в футере</td></tr>
        <?php foreach ($footmenu as $key => $coll): ?>
            <tr><td colspan="5">Колонка <?= $key ?></td></tr>
            <?php foreach ($coll as $index => $item) : ?>
                <tr data-key="1">
                    <td><?= $index+1 ?></td>
                    <td><?= $item->text ?></td>
                    <td><?= $item->url ?></td>
                    <td><?= $item->sort_order ?></td>
                    <td>
                        <a href="/backend/menu/update?id=<?= $item->id ?>" title="Update" aria-label="Update" data-pjax="0">
                            <span class="glyphicon glyphicon-pencil"></span>
                        </a>
                        <a href="/backend/menu/delete?id=<?= $item->id ?>" title="Delete" aria-label="Delete" data-pjax="0"
                           data-confirm="Are you sure you want to delete this item?" data-method="post">
                            <span class="glyphicon glyphicon-trash"></span>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
