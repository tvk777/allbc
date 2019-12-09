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
 * This is the model class for table "bc_places".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property int $item_id
 * @property int $m2
 * @property int $m2min
 * @property int $valute_id
 * @property string $stage_name
 * @property int $price_period
 * @property int $ai
 * @property int $commission
 * @property string $opex
 * @property int $plan_comment
 * @property int $hide
 * @property int $archive
 * @property int $price
 * @property int $con_price
 * @property string $tax
 * @property string $kop
 * @property string $phone
 * @property string $email
 * @property int $status_id
 * @property int $rent
 * @property int $hits
 * @property int $hide_contacts
 */
class BcPlaces extends ActiveRecord
{
    public $uploaded;
    public $deleted;
    public $upfile;
    public $delfile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bc_places';
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
                'langForeignKey' => 'places_id',
                'tableName' => "{{%bc_placesLang}}",
                'attributes' => [
                    'comment', 'fio'
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
            [['item_id', 'm2', 'valute_id', 'stage_name', 'price_period', 'ai', 'plan_comment', 'hide', 'archive', 'con_price'], 'required'],
            [['item_id', 'm2', 'm2min', 'valute_id', 'price_period', 'ai', 'commission', 'plan_comment', 'hide', 'archive', 'price', 'con_price', 'status_id', 'rent', 'hits', 'hide_contacts'], 'integer'],
            [['opex', 'tax', 'kop'], 'number'],
            [['fio', 'stage_name', 'phone', 'email'], 'string', 'max' => 255],
            [['comment'], 'string'],
            [['comment_ru', 'fio_ru', 'comment_ua', 'fio_ua', 'comment_en', 'fio_en'], 'safe'],
            [['uploaded', 'deleted','upfile', 'delfile'], 'safe'],
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
            'item_id' => Yii::t('app', 'Item ID'),
            'm2' => Yii::t('app', 'M2'),
            'm2min' => Yii::t('app', 'M2min'),
            'valute_id' => Yii::t('app', 'Valute ID'),
            'stage_name' => Yii::t('app', 'Stage Name'),
            'price_period' => Yii::t('app', 'Price Period'),
            'ai' => Yii::t('app', 'Ai'),
            'commission' => Yii::t('app', 'Commission'),
            'opex' => Yii::t('app', 'Opex'),
            'plan_comment' => Yii::t('app', 'Использовать комментарий к офису взамен изображения планировки'),
            'hide' => Yii::t('app', 'Hide'),
            'archive' => Yii::t('app', 'Archive'),
            'price' => Yii::t('app', 'Price'),
            'con_price' => Yii::t('app', 'Con Price'),
            'tax' => Yii::t('app', 'Tax'),
            'kop' => Yii::t('app', 'Kop'),
            'phone' => Yii::t('app', 'Phone'),
            'email' => Yii::t('app', 'Email'),
            'status_id' => Yii::t('app', 'Status ID'),
            'rent' => Yii::t('app', 'Rent'),
            'hits' => Yii::t('app', 'Hits'),
            'hide_contacts' => Yii::t('app', 'Hide Contacts'),
            'showm2' => Yii::t('app', 'Площадь, можно указывать "от-до", например "20-40" '),
        ];
    }

    public static function find()
    {
        return new MultilingualQuery(get_called_class());
    }
    public function getImages()
    {
        return $this->hasMany(SystemFiles::className(), ['attachment_id' => 'id'])->andWhere(['attachment_type' => self::tableName()])->andWhere(['field'=>'imgs'])->orderBy('sort_order');
    }


    public function getStageImg(){
        return $this->hasOne(SystemFiles::className(), ['attachment_id' => 'id'])
            ->andWhere(['attachment_type'=>self::tableName()])
            ->andWhere(['field'=>'stage_img']);
    }

    
    public function getPeriod(){
        return $this->hasOne(BcPeriods::className(), ['id'  => 'price_period']);
    }

    public function getShowPrice()
    {
        if($this->con_price!=1)
        {
            $str=$this->price.' за ';
            $str.= $this->period->name;
            return($str);
        }
        else
        {
            return('дог.');
        }
    }
    public function getShowm2()
    {
        if(isset($this->m2min) && $this->m2min!=null)
        {
            return($this->m2min.'-'.$this->m2);
        }
        return($this->m2);
    }

    public function beforeValidate()
    {
        $m2 = explode('-', $this->showm2);
        if (count($m2)==2) {
            $this->m2min = $m2[0];
            $this->m2 = $m2[1];
        } else {
            $this->m2 = $this->showm2;
        }
        return parent::beforeValidate();
    }

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
        if (!empty($this->uploaded)) {
            $uploaded = explode(',', $this->uploaded);
            SystemFiles::updateAll([
                'attachment_id' => $this->id,
                'attachment_type' => $this->tableName(),
            ], ['in', 'id', $uploaded]);
        }
        if (!empty($this->upfile)) {
            $upfile = (int)$this->upfile;
            if($this->stageImg) $this->stageImg->delete();
            $stageImage = SystemFiles::find()->where(['id' => $upfile])->one();
           $values = [
                'attachment_id' => $this->id,
                'attachment_type' => $this->tableName(),
            ];
            $stageImage->attributes = $values;
            $stageImage->save();
        }
        if (!empty($this->deleted)) {
            $deleted = explode(',', $this->deleted);
            SystemFiles::deleteAll(['in', 'id', $deleted]);
        }
        if (!empty($this->delfile)) {
            $delfile = (int)$this->delfile;
            $stageImage = SystemFiles::find()->where(['id' => $delfile])->one();
            $stageImage->delete();
        }
        parent::afterSave($insert, $changedAttributes);
    }



}
