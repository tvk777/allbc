<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bc_classes".
 * `disk_name`, `file_name`, `file_size`, `content_type`, `title`, `description`, `sort_order`
 * @property int $id
 * @property string $disk_name
 * @property string $file_name
 * @property int $file_size
 * @property string $content_type
 * @property string $title
 * @property string $description
 * @property int $sort_order
 */
class TempImages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'temp_images';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['disk_name', 'file_name', 'file_size', 'content_type' ], 'required'],
            [['file_size', 'sort_order'], 'integer'],
            [['disk_name', 'file_name', 'content_type', 'title', 'description'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'disk_name' => Yii::t('app', 'disk_name'),
            'file_name' => Yii::t('app', 'file_name'),
            'file_size' => Yii::t('app', 'file_size'),
            'content_type' => Yii::t('app', 'content_type'),
            'title' => Yii::t('app', 'title'),
            'description' => Yii::t('app', 'description'),
            'sort_order' => Yii::t('app', 'sort_order'),
        ];
    }
}
