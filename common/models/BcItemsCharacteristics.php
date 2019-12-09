<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bc_items_characteristics".
 *
 * @property int $id
 * @property int $item_id
 * @property int $characteristic_id
 * @property string $value
 * @property string $value_ua
 * @property string $value_en
 */
class BcItemsCharacteristics extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bc_items_characteristics';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item_id', 'characteristic_id', 'sort_order'], 'required'],
            [['item_id', 'characteristic_id', 'sort_order'], 'integer'],
            [['value', 'value_ua', 'value_en'], 'string', 'max' => 512],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'item_id' => Yii::t('app', 'Item ID'),
            'characteristic_id' => Yii::t('app', 'Characteristic ID'),
            'value' => Yii::t('app', 'Value Ru'),
            'value_ua' => Yii::t('app', 'Value Ua'),
            'value_en' => Yii::t('app', 'Value En'),
        ];
    }
    public function getCharacteristic()
    {
        return $this->hasOne(BcCharacteristics::className(), ['id' => 'characteristic_id']);
    }

    public function beforeValidate()
    {
        if ($this->sort_order == null) {
            $this->sort_order = $this->characteristic->sort_order;
        }
        return parent::beforeValidate();
    }

}
