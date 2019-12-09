<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bc_characteristics".
 *
 * @property int $id
 * @property string $name
 * @property string $name_ua
 * @property string $name_en
 * @property string $img
 */
class BcCharacteristics extends \yii\db\ActiveRecord
{
    public $value;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bc_characteristics';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['sort_order', 'integer'],
            ['sort_order', 'required'],
            [['name', 'name_ua', 'name_en', 'img'], 'string', 'max' => 64],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name Ru'),
            'name_ua' => Yii::t('app', 'Name Ua'),
            'name_en' => Yii::t('app', 'Name En'),
            'img' => Yii::t('app', 'Img'),
        ];
    }

    public function beforeValidate()
    {
        if ($this->sort_order == null) {
            $this->sort_order = BcCharacteristics::find()->max('sort_order') + 1;
        }
        return parent::beforeValidate();
    }
}
