<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "geo_districts".
 *
 * @property int $id
 * @property string $name
 * @property string $place_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $lat
 * @property string $lng
 * @property int $city_id
 */
class GeoDistricts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'geo_districts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['lat', 'lng'], 'number'],
            [['city_id'], 'integer'],
            [['name'], 'string', 'max' => 2500],
            [['place_id'], 'string', 'max' => 200],
            [['place_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'District'),
            'place_id' => Yii::t('app', 'Place ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'lat' => Yii::t('app', 'Lat'),
            'lng' => Yii::t('app', 'Lng'),
            'city_id' => Yii::t('app', 'City ID'),
        ];
    }

    public function getItems()
    {
        return $this->hasMany(BcItems::className(), ['district_id' => 'id'])->andWhere(['active' => 1])->andWhere(['hide' => 0]);
    }

    public function getCity()
    {
        return $this->hasOne(GeoCities::className(), ['id' => 'city_id']);
    }

}
