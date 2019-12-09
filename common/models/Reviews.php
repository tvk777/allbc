<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use omgdef\multilingual\MultilingualTrait;
use omgdef\multilingual\MultilingualQuery;
use omgdef\multilingual\MultilingualBehavior;

/**
 * This is the model class for table "reviews".
 *
 * @property int $id
 * @property string $text
 * @property string $text_ua
 * @property string $text_en
 * @property string $name
 * @property string $name_ua
 * @property string $name_en
 * @property string $position
 * @property string $position_ua
 * @property string $position_en
 * @property string $video
 */
class Reviews extends \yii\db\ActiveRecord
{
    public $upfile;
    public $delfile;
    public $uplogo;
    public $dellogo;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reviews';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
            'ml' => [
                'class' => MultilingualBehavior::className(),
                'languages' => [
                    'ru' => 'Russian',
                    'ua' => 'Ukrainian',
                    'en' => 'English',
                ],
                'defaultLanguage' => 'ru',
                'langForeignKey' => 'review_id',
                'tableName' => "{{%reviewsLang}}",
                'attributes' => [
                    'name', 'text', 'position'
                ]
            ],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['is_public', 'sort_order'], 'integer'],
            [['text', 'name', 'position'], 'string'],
            [['uplogo', 'dellogo','upfile', 'delfile', 'text_ru', 'text_ua', 'text_en', 'name_ru', 'name_ua', 'name_en', 'position_ru', 'position_ua', 'position_en'], 'safe'],
            [['video'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'created_at' => Yii::t('attr', 'Created At'),
            'updated_at' => Yii::t('attr', 'Updated At'),
            'sort_order' => Yii::t('attr', 'Sort Order'),
            'text' => Yii::t('app', 'Text'),
            'name' => Yii::t('app', 'Name'),
            'position' => Yii::t('app', 'Position'),
            'video' => Yii::t('app', 'Video'),
            'is_public' => Yii::t('app', 'Is Public'),
        ];
    }

    public static function find()
    {
        return new MultilingualQuery(get_called_class());
    }

    public function getLogo(){
        return $this->hasOne(SystemFiles::className(), ['attachment_id' => 'id'])
            ->andWhere(['attachment_type'=>self::tableName()])
            ->andWhere(['field'=>'logo']);
    }
    public function getImage(){
        return $this->hasOne(SystemFiles::className(), ['attachment_id' => 'id'])
            ->andWhere(['attachment_type'=>self::tableName()])
            ->andWhere(['field'=>'review_img']);
    }



    public function beforeValidate()
    {
        if ($this->sort_order == null) {
            $this->sort_order = Reviews::find()->max('sort_order') + 1;
        }
        return parent::beforeValidate();
    }

    public function afterSave($insert, $changedAttributes)
    {
        //debug($this);
        if (!empty($this->upfile)) {
            $upfile = (int)$this->upfile;
            $image = SystemFiles::find()->where(['id' => $upfile])->one();
            $values = [
                'attachment_id' => $this->id,
                'attachment_type' => $this->tableName(),
            ];
            $image->attributes = $values;
            $image->save();
            SystemFiles::saveThumb($image, 610, 412);
        }

        if (!empty($this->delfile)) {
            $delfile = explode(',', $this->delfile);
            /*SystemFiles::deleteAll(['in', 'id', $delfile]);*/
            foreach($delfile as $one) {
                SystemFiles::find()->where(['id' => $one])->one()->delete();
            }
        }

        if (!empty($this->uplogo)) {
            $uplogo = (int)$this->uplogo;
            $image = SystemFiles::find()->where(['id' => $uplogo])->one();
            $values = [
                'attachment_id' => $this->id,
                'attachment_type' => $this->tableName(),
            ];
            $image->attributes = $values;
            $image->save();
            SystemFiles::saveThumb($image, 160, 80);
        }

        if (!empty($this->dellogo)) {
            $dellogo = explode(',', $this->dellogo);
            foreach($dellogo as $one) {
                SystemFiles::find()->where(['id' => $one])->one()->delete();
            }
        }


        parent::afterSave($insert, $changedAttributes);
    }
    
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            if ($this->image) $this->image->delete();
            if ($this->logo) $this->logo->delete();
            return true;
        } else {
            return false;
        }
    }
}
