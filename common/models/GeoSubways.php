<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;


/**
 * This is the model class for table "geo_subways".
 *
 * @property int $id
 * @property string $name
 * @property string $place_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $lat
 * @property string $lng
 * @property int $city_id
 * @property int $branch_id
 */
class GeoSubways extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'geo_subways';
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
            [['created_at', 'updated_at'], 'safe'],
            [['lat', 'lng'], 'number'],
            [['city_id'], 'required'],
            [['city_id', 'branch_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['place_id'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'place_id' => Yii::t('app', 'Place ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'lat' => Yii::t('app', 'Lat'),
            'lng' => Yii::t('app', 'Lng'),
            'city_id' => Yii::t('app', 'City ID'),
            'branch_id' => Yii::t('app', 'Branch ID'),
        ];
    }

    public function getBranch()
    {
        return $this->hasOne(GeoBranch::className(), ['id' => 'branch_id']);
    }

    public function getCity()
    {
        return $this->hasOne(GeoCities::className(), ['id' => 'city_id']);
    }


    public function beforeValidate()
    {
        if ($this->city_id == null) {
            $place_info = Geo::getLocationByAddress($this->lat.",".$this->lng);
            if(isset($place_info['city']))
            {
                $city = GeoCities::find()->where(['place_id' => $place_info['city']['place_id']])->one();
                if($city){
                    $this->city_id = $city->id;
                } else{
                    $city = new GeoCities();
                    $city->place_id = $place_info['city']['place_id'];
                    $city->name = $place_info['city']['name'];
                    $city->lat = $this->lat;
                    $city->lng = $this->lng;
                    $city->active = 1;
                    $city->save();
                    $this->city_id = $city->id;
                }
            }
        }
        return parent::beforeValidate();
    }


}
