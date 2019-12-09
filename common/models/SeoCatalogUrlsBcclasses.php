<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "seo_catalog_urls_bcclasses".
 *
 * @property int $catalog_url_id
 * @property int $bc_class_id
 */
class SeoCatalogUrlsBcclasses extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'seo_catalog_urls_bcclasses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['catalog_url_id', 'bc_class_id'], 'required'],
            [['catalog_url_id', 'bc_class_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'catalog_url_id' => Yii::t('app', 'Catalog Url ID'),
            'bc_class_id' => Yii::t('app', 'Bc Class ID'),
        ];
    }
}
