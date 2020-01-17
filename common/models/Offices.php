<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

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

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['target', 'city_id', 'country_id'], 'required'],
            [['target', 'percent_commission'], 'integer'],
            [['city_id', 'country_id', 'district_id', 'class_id'], 'safe'],
            [['shuttle', 'shuttle_ua', 'shuttle_en'], 'string'],];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'target' => Yii::t('app', 'Target'),
            'city_id' => Yii::t('app', 'City ID'),
            'country_id' => Yii::t('app', 'Country ID'),
            'district_id' => Yii::t('app', 'District ID'),
            'class_id' => Yii::t('app', 'Class ID'),
            'percent_commission' => Yii::t('app', 'Percent Commission'),
            'shuttle' => Yii::t('app', 'Как добраться'),
        ];
    }

    public function getPlace()
    {
        return $this->hasOne(BcPlaces::className(), ['item_id' => 'id'])->andWhere(['archive' => 0])->andWhere(['hide' => 0]);
    }

    public function getPlacesell()
    {
        return $this->hasOne(BcPlacesSell::className(), ['item_id' => 'id'])->andWhere(['archive' => 0])->andWhere(['hide' => 0]);
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

    public function getSubways()
    {
        return $this->hasMany(BcItemsSubways::className(), ['item_id' => 'id'])->andWhere(['model' => $this->tableName()]);
    }

    public function getUsers()
    {
        return $this->hasMany(BcItemsUsers::className(), ['item_id' => 'id'])->andWhere(['model' => $this->tableName()]);
    }

    public function getBrokers()
    {
        return $this->hasMany(BcItemsBrokers::className(), ['item_id' => 'id'])->andWhere(['model' => $this->tableName()]);
    }

    public function getOwners()
    {
        return $this->hasMany(BcItemsOwners::className(), ['item_id' => 'id'])->andWhere(['model' => $this->tableName()]);
    }


    public function beforeSave($insert)
    {
        $city_id = Geo::getCityValue($this->city_id);
        $country_id = Geo::getCountryValue($this->country_id);
        $district_id = Geo::getDistrictValue($this->district_id);
        if ($city_id === 0 || $country_id === 0) {
            $this->city_id = $this->oldAttributes['city_id'];
            $this->country_id = $this->oldAttributes['country_id'];
            return false;
        }
        if (parent::beforeSave($insert)) {
            $this->city_id = $city_id;
            $this->country_id = $country_id;
            $this->district_id = $district_id;
            return true;
        } else {
            return false;
        }
    }


    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $new_subways = Yii::$app->request->post('Subways');
        //debug($new_subways); die();
        if (!empty($new_subways)) {
            $old_subways = ArrayHelper::map($this->subways, 'subway_id', 'subway_id');
            foreach ($new_subways as $one) {
                if ($one['subway_id'] && !in_array($one['subway_id'], $old_subways)) {
                    $itemSubway = new BcItemsSubways();
                    $itemSubway->item_id = $this->id;
                    $itemSubway->subway_id = $one['subway_id'];
                    $itemSubway->walk_distance = $one['walk_distance'];
                    $itemSubway->walk_seconds = $one['walk_seconds'] * 60;
                    $itemSubway->model = $this->tableName();
                    $itemSubway->save();
                }
                if (isset($old_subways[$one['subway_id']])) {
                    unset($old_subways[$one['subway_id']]);
                }
            }
            BcItemsSubways::deleteAll(['subway_id' => $old_subways]);
        }

    }

}
