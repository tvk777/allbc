<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bc_items_subways".
 *
 * @property int $item_id
 * @property int $subway_id
 * @property int $walk_distance
 * @property int $walk_seconds
 */
class BcItemsSubways extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bc_items_subways';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item_id'], 'required'],
            [['item_id', 'subway_id', 'walk_distance', 'walk_seconds'], 'integer'],
            [['model'], 'string']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'item_id' => Yii::t('attr', 'Item ID'),
            'subway_id' => Yii::t('attr', 'Subway ID'),
            'walk_distance' => Yii::t('attr', 'Walk Distance'),
            'walk_seconds' => Yii::t('attr', 'Walk Seconds'),
        ];
    }

    public function getSubwayDetails()
    {
        return $this->hasOne(GeoSubways::className(), ['id' => 'subway_id']);
    }
    


}
