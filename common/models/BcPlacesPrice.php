<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bc_places_price".
 *
 * @property int $place_id
 * @property int $valute_id
 * @property int $period_id
 * @property string $price
 * @property int $city_id
 */
class BcPlacesPrice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bc_places_price';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['place_id', 'valute_id', 'period_id', 'price', 'city_id'], 'required'],
            [['place_id', 'valute_id', 'period_id', 'price', 'city_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'place_id' => Yii::t('app', 'Place ID'),
            'valute_id' => Yii::t('app', 'Valute ID'),
            'period_id' => Yii::t('app', 'Period ID'),
            'price' => Yii::t('app', 'Price'),
            'city_id' => Yii::t('app', 'City ID'),
        ];
    }

    public function getPlace()
    {
        return $this->hasOne(BcPlaces::className(), ['id' => 'place_id']);
    }

}
