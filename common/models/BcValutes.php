<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bc_valutes".
 *
 * @property int $id
 * @property string $name
 * @property double $rate
 * @property string $ind
 * @property string $short_name
 */
class BcValutes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bc_valutes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'rate', 'ind', 'short_name'], 'required'],
            [['rate'], 'number'],
            [['name', 'ind', 'short_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'rate' => Yii::t('app', 'Rate'),
            'ind' => Yii::t('app', 'Ind'),
            'short_name' => Yii::t('app', 'Short Name'),
        ];
    }
    
    public static function getRate($id){
        $rate_query = self::find()->select(['rate', 'short_name'])->where(['id' => $id])->asArray()->one();
        return $rate_query;
    }
}
