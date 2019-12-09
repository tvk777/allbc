<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bc_classes".
 *
 * @property int $id
 * @property string $name
 * @property string $name_ua
 * @property string $name_en
 * @property string $created_at
 * @property string $updated_at
 * @property string $short_name
 * @property string $short_name_ua
 * @property string $short_name_en
 * @property string $slug
 */
class BcClasses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bc_classes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'name_ua', 'name_en', 'short_name', 'short_name_ua', 'short_name_en'], 'string', 'max' => 255],
            [['slug'], 'string', 'max' => 15],
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
            'name_ua' => Yii::t('app', 'Name Ua'),
            'name_en' => Yii::t('app', 'Name En'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'short_name' => Yii::t('app', 'Short Name'),
            'short_name_ua' => Yii::t('app', 'Short Name Ua'),
            'short_name_en' => Yii::t('app', 'Short Name En'),
            'slug' => Yii::t('app', 'Slug'),
        ];
    }
}
