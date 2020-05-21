<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "taxes".
 *
 * @property int $id
 * @property string $description
 * @property string $value
 */
class Taxes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'taxes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'required'],
            [['value'], 'number'],
            [['description'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'description' => Yii::t('app', 'Description'),
            'value' => Yii::t('app', 'Value'),
        ];
    }
}
