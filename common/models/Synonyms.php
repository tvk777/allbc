<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "synonyms".
 *
 * @property int $id
 * @property int $series
 * @property int $counter
 * @property string $word
 * @property string $word_ua
 * @property string $word_en
 */
class Synonyms extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'synonyms';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['series', 'word_ua', 'word_en'], 'required'],
            [['series', 'counter'], 'integer'],
            [['word', 'word_ua', 'word_en'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'series' => Yii::t('app', 'Series'),
            'counter' => Yii::t('app', 'Counter'),
            'word' => Yii::t('app', 'Word'),
            'word_ua' => Yii::t('app', 'Word Ua'),
            'word_en' => Yii::t('app', 'Word En'),
        ];
    }
}
