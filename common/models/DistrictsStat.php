<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "districts_stat".
 *
 * @property int $id
 * @property int $district_id
 * @property string $price
 * @property int $count
 * @property string $vacancy
 */
class DistrictsStat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'districts_stat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['district_id', 'count', 'count_sell', 'price', 'price_sell'], 'integer'],
            [['free_m2', 'free_sell_m2', 'total_m2'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'district_id' => Yii::t('app', 'District ID'),
            'price' => Yii::t('app', 'Price'),
            'count' => Yii::t('app', 'Count'),
        ];
    }

    public function getDistrict()
    {
        return $this->hasOne(GeoDistricts::className(), ['id' => 'district_id']);
    }

    public function getItems()
    {
        return $this->hasMany(BcItems::className(), ['district_id' => 'district_id'])->multilingual();
    }

    public function getSumItemsM2()
    {
        return $this->hasMany(BcItems::className(), ['district_id' => 'district_id'])->sum('total_m2');
    }

    public function getVacancy()
    {
        $vacancy = $this->total_m2>0 ? round(($this->free_m2/$this->total_m2)*100) : '';
        return $vacancy;
    }



}
