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
 * This is the model class for table "seo_catalog_urls".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property string $price
 * @property string $m2
 * @property int $commission
 * @property int $target
 * @property int $bc_commission
 * @property string $redirect
 * @property int $show_all
 */
class SeoCatalogUrls extends ActiveRecord
{
    public $alias;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'seo_catalog_urls';
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
                'langForeignKey' => 'seo_id',
                'tableName' => "{{%seo_catalog_urlsLang}}",
                'attributes' => [
                    'name', 'short_content', 'content', 'title', 'description', 'keywords', 'crumbs', 'links', 'links2', 'links3', 'main_rent_link_href', 'main_sell_link_href'
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
            ['alias', 'unique',
                'targetClass' => Slugs::className(),
                'targetAttribute' => 'slug',
                'message' => Yii::t('app', 'This slug is already exist'),
                'when' => function ($model) {
                    if (!$model->isNewRecord) {
                        return $model->alias !== $model->slug->getOldAttribute('slug');
                    } else {
                        return true;
                    }
                },
            ],
            [['created_at', 'updated_at'], 'safe'],
            [['commission', 'target'], 'required'],
            [['commission', 'target', 'bc_commission', 'show_all'], 'integer'],
            [['price', 'redirect'], 'string', 'max' => 255],
            [['m2'], 'string', 'max' => 10],
            [['name', 'short_content', 'content', 'title', 'description', 'keywords', 'crumbs', 'links', 'links2', 'links3', 'main_rent_link_href', 'main_sell_link_href'], 'string'],
            [['name_ru', 'short_content_ru', 'content_ru', 'title_ru', 'description_ru', 'keywords_ru', 'crumbs_ru', 'links_ru', 'links2_ru', 'links3_ru', 'main_rent_link_href_ru', 'main_sell_link_href_ru', 'name_ua', 'short_content_ua', 'content_ua', 'title_ua', 'description_ua', 'keywords_ua', 'crumbs_ua', 'links_ua', 'links2_ua', 'links3_ua', 'main_rent_link_href_ua', 'main_sell_link_href_ua', 'name_en', 'short_content_en', 'content_en', 'title_en', 'description_en', 'keywords_en', 'crumbs_en', 'links_en', 'links2_en', 'links3_en', 'main_rent_link_href_en', 'main_sell_link_href_en'], 'safe'],];
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
            'price' => Yii::t('app', 'Price'),
            'm2' => Yii::t('app', 'M2'),
            'commission' => Yii::t('app', 'Commission'),
            'target' => Yii::t('app', 'Target'),
            'bc_commission' => Yii::t('app', 'Bc Commission'),
            'redirect' => Yii::t('app', 'Redirect'),
            'show_all' => Yii::t('app', 'Show All'),
        ];
    }
    public static function find()
    {
        return new MultilingualQuery(get_called_class());
    }

    public function getSlug()
    {
        return $this->hasOne(Slugs::className(), ['model_id' => 'id'])->andWhere(['model' => self::tableName()]);
    }

    public function getClasses()
    {
        return $this->hasMany(SeoCatalogUrlsBcclasses::className(), ['catalog_url_id' => 'id']);
    }
    public function getBranch()
    {
        return $this->hasMany(SeoCatalogUrlsBranch::className(), ['catalog_url_id' => 'id']);
    }
    public function getCity()
    {
        return $this->hasOne(SeoCatalogUrlsCities::className(), ['catalog_url_id' => 'id']);
    }
    public function getCountry()
    {
        return $this->hasOne(SeoCatalogUrlsCountries::className(), ['catalog_url_id' => 'id']);
    }
    public function getDistricts()
    {
        return $this->hasMany(SeoCatalogUrlsDistricts::className(), ['catalog_url_id' => 'id']);
    }
    public function getStatuses()
    {
        return $this->hasMany(SeoCatalogUrlsStatuses::className(), ['catalog_url_id' => 'id']);
    }
    public function getSubways()
    {
        return $this->hasMany(SeoCatalogUrlsSubways::className(), ['catalog_url_id' => 'id']);
    }
    






    public function beforeValidate()
    {
        if (empty($this->alias)) {
            $this->alias = Slugs::generateSlug($this->tableName(), $this->id, $this->name);
        }
        return parent::beforeValidate();
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
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            Slugs::deleteAll(['model_id'=>$this->id, 'model' => $this->tableName()]);
            return true;
        } else {
            return false;
        }
    }



}
