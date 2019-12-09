<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bc_statuses".
 *
 * @property int $id
 * @property string $name
 * @property string $name_ua
 * @property string $name_en
 */
class BcStatuses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bc_statuses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'name_ua', 'name_en'], 'string', 'max' => 255],
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
        ];
    }
}
