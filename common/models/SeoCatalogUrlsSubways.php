<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "seo_catalog_urls_subways".
 *
 * @property int $catalog_url_id
 * @property int $subway_id
 */
class SeoCatalogUrlsSubways extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'seo_catalog_urls_subways';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['catalog_url_id', 'subway_id'], 'required'],
            [['catalog_url_id', 'subway_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'catalog_url_id' => Yii::t('app', 'Catalog Url ID'),
            'subway_id' => Yii::t('app', 'Subway ID'),
        ];
    }
}
