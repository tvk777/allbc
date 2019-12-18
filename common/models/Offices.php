<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "offices".
 *
 * @property int $id
 * @property int $place_id
 * @property int $target
 * @property int $city_id
 * @property int $country_id
 * @property int $district_id
 * @property int $class_id
 * @property int $percent_commission
 */
class Offices extends ActiveRecord
{
    public $cityName;
    public $countryName;
    public $districtName;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'offices';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['place_id', 'target'], 'required'],
            [['place_id', 'target', 'city_id', 'country_id', 'district_id', 'class_id', 'percent_commission'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            '' => Yii::t('app', 'Place ID'),
            'target' => Yii::t('app', 'Target'),
            'city_id' => Yii::t('app', 'City ID'),
            'country_id' => Yii::t('app', 'Country ID'),
            'district_id' => Yii::t('app', 'District ID'),
            'class_id' => Yii::t('app', 'Class ID'),
            'percent_commission' => Yii::t('app', 'Percent Commission'),
        ];
    }

    public function getPlace()
    {
        if($this->target == 1) return $this->hasOne(BcPlaces::className(), ['id' => 'place_id'])->andWhere(['archive' => 0])->andWhere(['hide' => 0]);
        return $this->hasOne(BcPlacesSell::className(), ['id' => 'place_id'])->andWhere(['archive' => 0])->andWhere(['hide' => 0]);
    }


    public function getClass()
    {
        return $this->hasOne(BcClasses::className(), ['id' => 'class_id']);
    }

    public function getCity()
    {
        return $this->hasOne(GeoCities::className(), ['id' => 'city_id']);
    }

    public function getCountry()
    {
        return $this->hasOne(GeoCountries::className(), ['id' => 'country_id']);
    }

    public function getDistrict()
    {
        return $this->hasOne(GeoDistricts::className(), ['id' => 'district_id']);
    }




}
