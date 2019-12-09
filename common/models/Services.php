<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use omgdef\multilingual\MultilingualTrait;
use omgdef\multilingual\MultilingualQuery;
use omgdef\multilingual\MultilingualBehavior;

/**
 * This is the model class for table "services".
 *
 * @property int $id
 * @property int $created_at
 * @property string $slug
 * @property int $updated_at
 * @property int $enable
 */
class Services extends ActiveRecord
{
    public $alias;
    public $upload_image;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'services';
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
                'defaultLanguage' => 'ru',
                'langForeignKey' => 'services_id',
                'tableName' => "{{%servicesLang}}",
                'attributes' => [
                    'name', 'short_content','content','title', 'description', 'keywords'
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
            [['upload_image'], 'file', 'extensions' => 'jpg, png, svg', 'skipOnEmpty' => true],
            [['name', 'enable'], 'required'],
            [['created_at', 'updated_at', 'sort_order'], 'integer'],
            [['name','short_content', 'content', 'title', 'description', 'keywords'], 'string'],
            ['alias', 'unique',
                'targetClass' => Slugs::className(),
                'targetAttribute' => 'slug',
                'message'=>Yii::t('app','This slug is already exist'),
                'when' => function ($model) {
                    if(!$model->isNewRecord){
                        return $model->alias !== $model->slug->getOldAttribute('slug');}
                    else {
                        return true;
                    }
                },
            ],
            [['name_ru', 'name_en', 'name_ua',
              'short_content_ru', 'short_content_en', 'short_content_ua',
              'content_ru', 'content_en', 'content_ua',
              'title_ru', 'title_en', 'title_ua',
              'description_ru', 'description_en', 'description_ua',
              'keywords_ru', 'keywords_en', 'keywords_ua',
            ], 'safe'],
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
            'enable' => Yii::t('app', 'Enable'),
            'name' => Yii::t('app', 'Name'),
            'short_content' => Yii::t('app', 'Short Content'),
            'content' => Yii::t('app', 'Content'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Meta Description'),
            'keywords' => Yii::t('app', 'Meta Keywords'),
            'sort_order' => Yii::t('app', 'Sort Order'),
        ];
    }

    public static function find()
    {
        return new MultilingualQuery(get_called_class());
    }

    public function getSlug(){
        return $this->hasOne(Slugs::className(), ['model_id' => 'id'])->andWhere(['model'=>self::tableName()]);
    }
    
    public function getImg(){
        return $this->hasOne(SystemFiles::className(), ['attachment_id' => 'id'])->andWhere(['attachment_type'=>self::tableName()]);
    }


    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            Slugs::initialize($this->tableName(),$this->id, $this->alias);
        }else {
            if ($this->alias != $this->slug->slug) {
                Slugs::updateSlug($this->tableName(),$this->id, $this->alias);
            }
        }
        parent::afterSave($insert, $changedAttributes);
    }

    public function beforeValidate()
    {
        if (empty($this->alias)) {
            $this->alias = Slugs::generateSlug($this->tableName(), $this->id, $this->name);
        }
        return parent::beforeValidate();
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            Slugs::deleteAll(['model_id'=>$this->id, 'model' => $this->tableName()]);
            if($this->img){$this->img->delete();}
            return true;
        } else {
            return false;
        }
    }

}
