<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\Inflector;
use dosamigos\transliterator\TransliteratorHelper;


/**
 * This is the model class for table "geo_cities".
 *
 * @property int $id
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 * @property int $active
 * @property int $country_id
 * @property string $place_id
 * @property string $lat
 * @property string $lng
 * @property string $slug
 * @property int $sort_order
 * @property int $bc_count
 * @property string $phone
 * @property int $contacts_open
 * @property int $offices_open
 * @property int $zoom
 * @property string $openstreetmapid
 * @property string $inflect
 * @property string $slug_sell
 */
class GeoCities extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'geo_cities';
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
            [['name', 'active', 'country_id', 'place_id', 'lat', 'lng', 'sort_order'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['active', 'country_id', 'sort_order', 'bc_count', 'contacts_open', 'offices_open', 'zoom'], 'integer'],
            [['lat', 'lng'], 'number'],
            [['openstreetmapid'], 'string'],
            [['name', 'name_ua', 'name_en', 'inflect', 'inflect_ua', 'slug_sell'], 'string', 'max' => 255],
            [['place_id'], 'string', 'max' => 200],
            [['phone'], 'string', 'max' => 50],
            [['slug'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'City'),
            'name_ua' => Yii::t('app', 'City'),
            'name_en' => Yii::t('app', 'City'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'active' => Yii::t('app', 'Active'),
            'country_id' => Yii::t('app', 'Country ID'),
            'place_id' => Yii::t('app', 'Place ID'),
            'lat' => Yii::t('app', 'Lat'),
            'lng' => Yii::t('app', 'Lng'),
            'sort_order' => Yii::t('app', 'Sort Order'),
            'bc_count' => Yii::t('app', 'Bc Count'),
            'phone' => Yii::t('app', 'Phone'),
            'contacts_open' => Yii::t('app', 'Contacts Open'),
            'offices_open' => Yii::t('app', 'Offices Open'),
            'zoom' => Yii::t('app', 'Zoom'),
            'openstreetmapid' => Yii::t('app', 'Openstreetmapid'),
            'inflect' => Yii::t('app', 'Склонение "Где?", напр: Киеве '),
            'inflect_ua' => Yii::t('app', 'Склонение "Где?", напр: Киеве '),
            'slug' => Yii::t('app', 'Slug'),
            'slug_sell' => Yii::t('app', 'Slug Sell'),
        ];
    }

/*    public function getSlug()
    {
        return $this->hasOne(Slugs::className(), ['model_id' => 'id'])->andWhere(['model' => self::tableName()]);
    }*/
    public function getCountry()
    {
        return $this->hasOne(GeoCountries::className(), ['id' => 'country_id']);
    }

    public function getDistricts()
    {
        return $this->hasMany(GeoDistricts::className(), ['id' => 'city_id']);
    }





    public function beforeValidate()
    {
        if (empty($this->slug)) {
            $this->slug = Inflector::slug(TransliteratorHelper::process($this->name), '-', true);
        }

        if ($this->country_id == null) {
            $place_info = Geo::getLocationByAddress($this->lat . "," . $this->lng);
            if (isset($place_info['country'])) {
                $country = GeoCountries::find()->where(['place_id' => $place_info['country']['place_id']])->one();
                if ($country) {
                    $this->country_id = $country->id;
                } else {
                    $country = new GeoCountries();
                    $country->place_id = $place_info['country']['place_id'];
                    $country->name = $place_info['country']['name'];
                    $country->lat = $place_info['country']['lat'];
                    $country->lng = $place_info['country']['lng'];
                    $country->save();
                    $this->country_id = $country->id;
                }
            }
        }

        if ($this->sort_order == null) {
            $this->sort_order = GeoCities::find()->max('sort_order') + 1;
        }
        return parent::beforeValidate();
    }

    /*public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            Slugs::initialize($this->tableName(), $this->id, $this->alias);
        } else {
            //debug($this); die();
            if ($this->alias != $this->slug->slug) {
                Slugs::updateSlug($this->tableName(), $this->id, $this->alias);
            }
        }

        parent::afterSave($insert, $changedAttributes);
    }*/

}
