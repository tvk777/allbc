<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bc_items_users".
 *
 * @property int $item_id
 * @property int $user_id
 */
class BcItemsUsers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bc_items_users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item_id', 'user_id'], 'required'],
            [['item_id', 'user_id'], 'integer'],
            [['model'], 'string']
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
    public function getUserInfo()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

}


/* запрос для заполнения поля model данными
UPDATE `bc_items_users` SET `model`='bc_items'
*/
