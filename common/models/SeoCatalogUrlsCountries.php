<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "seo_catalog_urls_countries".
 *
 * @property int $catalog_url_id
 * @property int $country_id
 */
class SeoCatalogUrlsCountries extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'seo_catalog_urls_countries';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['catalog_url_id', 'country_id'], 'required'],
            [['catalog_url_id', 'country_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'catalog_url_id' => Yii::t('app', 'Catalog Url ID'),
            'country_id' => Yii::t('app', 'Country ID'),
        ];
    }
}
