<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "seo_catalog_urls_branch".
 *
 * @property int $catalog_url_id
 * @property int $branch_id
 */
class SeoCatalogUrlsBranch extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'seo_catalog_urls_branch';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['catalog_url_id', 'branch_id'], 'required'],
            [['catalog_url_id', 'branch_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'catalog_url_id' => Yii::t('app', 'Catalog Url ID'),
            'branch_id' => Yii::t('app', 'Branch ID'),
        ];
    }
}
