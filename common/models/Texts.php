<?php

namespace common\models;

use Yii;
use omgdef\multilingual\MultilingualQuery;
use omgdef\multilingual\MultilingualBehavior;

/**
 * This is the model class for table "texts".
 *
 * @property int $id
 * @property string $text_type
 */
class Texts extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            'ml' => [
                'class' => MultilingualBehavior::className(),
                'languages' => [
                    'ru' => 'Russian',
                    'ua' => 'Ukrainian',
                    'en' => 'English',
                ],
                'defaultLanguage' => 'ru',
                'langForeignKey' => 'texts_id',
                'tableName' => "{{%textsLang}}",
                'attributes' => [
                    'content',
                ]
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'texts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text_type'], 'required'],
            [['text_type'], 'string', 'max' => 15],
            [['title', 'content', 'content_ru', 'content_ua', 'content_en',], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'text_type' => Yii::t('app', 'Text Type'),
        ];
    }

    public static function find()
    {
        return new MultilingualQuery(get_called_class());
    }

}
