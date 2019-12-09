<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use omgdef\multilingual\MultilingualTrait;
use omgdef\multilingual\MultilingualQuery;
use omgdef\multilingual\MultilingualBehavior;
use yii\web\UploadedFile;



/**
 * This is the model class for table "infoblocks_howtouse".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 */
class InfoblocksHowtouse extends ActiveRecord
{
    public $upload_image;

    public function behaviors()
    {
        return [
            'ml' => [
                'class' => MultilingualBehavior::className(),
                'languages' => [
                    'ru' => 'Russian',
                    'ua' => 'Ukrainian',
                    'en' => 'English',
                ],
                'defaultLanguage' => 'ru',
                'langForeignKey' => 'howtouse_id',
                'tableName' => "{{%infoblocks_howtouseLang}}",
                'attributes' => [
                    'name', 'text',
                ]
            ],
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],


        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'infoblocks_howtouse';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['upload_image'], 'file', 'extensions' => 'svg', 'skipOnEmpty' => true],
            [['created_at', 'updated_at'], 'integer'],
            [['name', 'text', 'name_ru', 'text_ru', 'name_ua', 'text_ua', 'name_en', 'text_en',], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'image' => Yii::t('app', 'Image'),
        ];
    }

    public static function find()
    {
        return new MultilingualQuery(get_called_class());
    }


    public function getImg(){
        return $this->hasOne(SystemFiles::className(), ['attachment_id' => 'id'])->andWhere(['attachment_type'=>self::tableName()]);
    }


    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            if($this->img){$this->img->delete();}
            return true;
        } else {
            return false;
        }
    }

}
