<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "seo_catalog_urls_cities".
 *
 * @property int $catalog_url_id
 * @property int $city_id
 */
class SeoCatalogUrlsCities extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'seo_catalog_urls_cities';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['catalog_url_id', 'city_id'], 'required'],
            [['catalog_url_id', 'city_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'catalog_url_id' => Yii::t('app', 'Catalog Url ID'),
            'city_id' => Yii::t('app', 'City ID'),
        ];
    }
    public function getCity()
    {
        return $this->hasOne(GeoCities::className(), ['id' => 'city_id']);
    }

}
