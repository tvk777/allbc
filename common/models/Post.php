<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use omgdef\multilingual\MultilingualTrait;
use omgdef\multilingual\MultilingualQuery;
use omgdef\multilingual\MultilingualBehavior;
use yii\behaviors\SluggableBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;


/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property int $enabled
 */
class Post extends ActiveRecord
{
    public $uploaded;
    public $deleted;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
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
            ],
            'ml' => [
                'class' => MultilingualBehavior::className(),
                'languages' => [
                    'ru' => 'Russian',
                    'ua' => 'Ukrainian',
                    'en' => 'English',
                ],
                //'languageField' => 'language',
                //'localizedPrefix' => '',
                //'requireTranslations' => true,
                //'dynamicLangClass' => true',
                //'langClassName' => PostLang::className(), // or namespace/for/a/class/PostLang
                'defaultLanguage' => 'ru',
                'langForeignKey' => 'post_id',
                'tableName' => "{{%postLang}}",
                'attributes' => [
                    'title', 'content',
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
            [['created_at', 'updated_at', 'enabled', 'uploaded', 'deleted'], 'safe'],
            [['title', 'title_ru', 'title_en', 'title_ua', 'content', 'content_ru', 'content_en', 'content_ua'], 'safe'],
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
            'enabled' => Yii::t('app', 'Enabled'),
        ];
    }

    public static function find()
    {
        return new MultilingualQuery(get_called_class());
    }


    /*begin functions for multiply images upload*/
    public function getImages()
    {
        return $this->hasMany(SystemFiles::className(), ['attachment_id' => 'id'])->andWhere(['attachment_type' => self::tableName()])->orderBy('sort_order');
    }

/*    public function getImagesPreview()
     {
         $Preview = [];
         foreach ($this->images as $img) {
             $Preview[] = Html::a(Html::img($img->imgSrc), ['/system-files/update', 'id' => $img->id], ['class' => 'modal-form size-middle']);
         }
         return $Preview;
     }

     public function getImagesLinksData()
     {
         $images = $this->images;
         return ArrayHelper::toArray($this->images, [
                 SystemFiles::className() => [
                     'caption' => function ($images) {
                         return $images->title ? $images->title : $images->file_name;
                     },
                     'key' => 'id',
                 ]]
         );
     }*/

     public function beforeDelete()
     {
         if (parent::beforeDelete()) {
             $flag = true;
             if ($this->images) {
                 foreach ($this->images as $img) {
                     if (!$img->delete()) {
                         $flag = false;
                     }
                 }
             }
             return $flag;
         } else {
             return false;
         }
     }

     public function afterSave($insert, $changedAttributes)
     {
         parent::afterSave($insert, $changedAttributes);
         if (!empty($this->uploaded)) {
             $uploaded = explode(',', $this->uploaded);
             SystemFiles::updateAll([
                 'attachment_id' => $this->id,
                 'attachment_type' => $this->tableName(),
             ], ['in', 'id', $uploaded]);
         }
         if (!empty($this->deleted)) {
             $deleted = explode(',', $this->deleted);
             SystemFiles::deleteAll(['in', 'id', $deleted]);
         }
     }
    /*end functions for multiply images upload*/

}
