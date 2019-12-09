<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "seo_catalog_urls_districts".
 *
 * @property int $catalog_url_id
 * @property int $district_id
 */
class SeoCatalogUrlsDistricts extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'seo_catalog_urls_districts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['catalog_url_id', 'district_id'], 'required'],
            [['catalog_url_id', 'district_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'catalog_url_id' => Yii::t('app', 'Catalog Url ID'),
            'district_id' => Yii::t('app', 'District ID'),
        ];
    }
    public function getDistrict()
    {
        return $this->hasOne(GeoDistricts::className(), ['id' => 'district_id']);
    }

}
