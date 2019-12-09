<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bc_items_brokers".
 *
 * @property int $item_id
 * @property int $user_id
 */
class BcItemsBrokers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bc_items_brokers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item_id', 'user_id'], 'required'],
            [['item_id', 'user_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'item_id' => Yii::t('app', 'Item ID'),
            'user_id' => Yii::t('app', 'User ID'),
        ];
    }
}
