<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bc_slider".
 *
 * @property int $id
 * @property int $item_id
 * @property int $slider_id
 */
class BcSlider extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bc_slider';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item_id', 'slider_id'], 'required'],
            [['item_id', 'slider_id'], 'integer'],
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
            'slider_id' => Yii::t('app', 'Slider ID'),
        ];
    }

    public function getBcitem()
    {
        return $this->hasOne(BcItems::className(), ['id' => 'item_id']);
    }

}
