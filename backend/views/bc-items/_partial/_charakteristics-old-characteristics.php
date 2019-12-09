<?php
use unclead\multipleinput\MultipleInput;
use yii\bootstrap\Tabs;
$data = new stdClass();
$data->col1 = '';
$data->col2 = '';

$ru = $form->field($model, 'characteristics')->widget(MultipleInput::className(), [
        'addButtonPosition' => MultipleInput::POS_FOOTER,
        'allowEmptyList' => true,
        'columns' => [
            [
                'name' => 'col1',
                'value' => $data->col1,
                'enableError' => true,
            ],
            [
                'name' => 'col2',
                'enableError' => true,
                'value' => $data->col2,
            ],

        ]

    ]);
$ua = $form->field($model, 'characteristics_ua')->widget(MultipleInput::className(), [
    'addButtonPosition' => MultipleInput::POS_FOOTER,
    'allowEmptyList' => true,
    'columns' => [
        [
            'name' => 'col1',
            'value' => $data->col1,
            'enableError' => true,
        ],
        [
            'name' => 'col2',
            'enableError' => true,
            'value' => $data->col2,
        ],

    ]

]);
$en = $form->field($model, 'characteristics_en')->widget(MultipleInput::className(), [
    'addButtonPosition' => MultipleInput::POS_FOOTER,
    'allowEmptyList' => true,
    'columns' => [
        [
            'name' => 'col1',
            'value' => $data->col1,
            'enableError' => true,
        ],
        [
            'name' => 'col2',
            'enableError' => true,
            'value' => $data->col2,
        ],

    ]

]);
?>

<div class="characteristics-form">

<?= Tabs::widget([
        'items' => [
                [
                    'label' => 'ru',
                    'content' => $ru,
                    'active' => true
                ],
            [
                'label' => 'ua',
                'content' => $ua,
            ],
            [
                'label' => 'en',
                'content' => $en,
            ],
        ],
]); ?>


</div>

