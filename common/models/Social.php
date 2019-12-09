<?php

namespace common\models;

use Yii;
/**
 * This is the model class for table "social".
 *
 * @property int $id
 * @property string $name
 * @property string $url
 * @property string $icon
 */
class Social extends \yii\db\ActiveRecord
{
    public $file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'social';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'url'], 'required'],
            [['name'], 'string', 'max' => 127],
            [['sort_order'], 'integer'],
            [['url', 'icon'], 'string', 'max' => 255],
            [['file'], 'file'],
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
            'url' => Yii::t('app', 'Url'),
            'icon' => Yii::t('app', 'Icon'),
        ];
    }
}
