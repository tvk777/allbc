<?php
use yii\helpers\Html;
use yii\bootstrap\Tabs;

//debug($characteristics);
?>
<?= $form->field($model, 'total_m2')->textInput() ?>

<? echo Tabs::widget([
    'items' => [
        [
            'label' => 'ru',
            'content' => $this->render('_langchar', [
                'characteristics' => $characteristics,
                'lng' => 'ru'
            ]),
            'active' => true
        ],
        [
            'label' => 'ua',
            'content' => $this->render('_langchar', [
                'characteristics' => $characteristics,
                'lng' => 'ua'
            ]),
        ],
        [
            'label' => 'en',
            'content' => $this->render('_langchar', [
                'characteristics' => $characteristics,
                'lng' => 'en'
            ]),
        ],
    ],
]); ?>

