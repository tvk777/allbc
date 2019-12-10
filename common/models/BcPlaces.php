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
            [['name', 'name_ua', 'name_en', 'fio', 'fio_ua', 'fio_en', 'stage_name', 'phone', 'email'], 'string', 'max' => 255],
            [['comment', 'comment_ua', 'comment_en'], 'string'],
            [['uploaded', 'deleted', 'upfile', 'delfile'], 'safe'],
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
            'comment' => Yii::t('app', 'Comment'),
            'comment_ua' => Yii::t('app', 'Comment'),
            'comment_en' => Yii::t('app', 'Comment'),
            'fio' => Yii::t('app', 'fio'),
            'fio_ua' => Yii::t('app', 'fio'),
            'fio_en' => Yii::t('app', 'fio'),
            'name' => Yii::t('app', 'name/h1'),
            'name_ua' => Yii::t('app', 'name/h1'),
            'name_en' => Yii::t('app', 'name/h1'),
        ];
    }

    public function getImages()
    {
        return $this->hasMany(SystemFiles::className(), ['attachment_id' => 'id'])->andWhere(['attachment_type' => self::tableName()])->andWhere(['field' => 'imgs'])->orderBy('sort_order');
    }

    //картинка БЦ (на случай если у places нет картинки)
    public function getBcimg(){
        return $this->bcitem->images[0];
    }


    public function getStageImg()
    {
        return $this->hasOne(SystemFiles::className(), ['attachment_id' => 'id'])
            ->andWhere(['attachment_type' => self::tableName()])
            ->andWhere(['field' => 'stage_img']);
    }

    public function getPrices()
    {
        return $this->hasMany(BcPlacesPrice::className(), ['place_id' => 'id']);
    }


    public function getPeriod()
    {
        return $this->hasOne(BcPeriods::className(), ['id' => 'price_period']);
    }

    public function getBcitem()
    {
        return $this->hasOne(BcItems::className(), ['id' => 'item_id']);
    }


    public function getShowPrice()
    {
        if ($this->con_price != 1) {
            $str = $this->price . ' за ';
            $str .= $this->period->name;
            return ($str);
        } else {
            return ('дог.');
        }
    }

    public function getShowm2()
    {
        if (isset($this->m2min) && $this->m2min != null) {
            return ($this->m2min . '-' . $this->m2);
        }
        return ($this->m2);
    }

    public function beforeValidate()
    {
        $m2 = explode('-', $this->showm2);
        if (count($m2) == 2) {
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
            if ($this->stageImg) $this->stageImg->delete();
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
            $delfile = explode(',', $this->delfile);
            SystemFiles::deleteAll(['in', 'id', $delfile]);
        }
        parent::afterSave($insert, $changedAttributes);
    }

    public function createName()
    {
        $name = [];
        $sqm_text='';
        $sqm_text_ua='';
        $sqm_text_en='';

        $arenda = Synonyms::find()->where(['series' => 1])->orderBy('counter')->one();
        $arenda->counter++;
        $arenda->save();
        $arenda_ru = $arenda->word;
        $arenda_ua = $arenda->word_ua;
        $arenda_en = $arenda->word_en;

        $sqm = $this->m2min ? $this->m2min : $this->m2;
        if($sqm>0) {
            $sqm_model = Synonyms::find()->where(['series' => 2])->orderBy('counter')->one();
            $sqm_model->counter++;
            $sqm_model->save();

            $sqm_text = ' площадью ' .$sqm.' '.$sqm_model->word;
            $sqm_text_ua = ' площею ' .$sqm.' '.$sqm_model->word;
            $sqm_text_en = ' area of '.$sqm.' '.$sqm_model->word_en;
        }

        $city = $this->bcitem->city;
        $city_ru = $city->name;
        $city_ua = $city->name_ua;
        $city_en = $city->name_en;

        $name['ru'] = $arenda_ru . $sqm_text.' г.' . $city_ru;
        $name['ua'] = $arenda_ua . $sqm_text_ua .' м.' . $city_ua;
        $name['en'] = $arenda_en . $sqm_text_en . ' - ' . $city_en;

        $this->name = $name['ru'];
        $this->name_ua = $name['ua'];
        $this->name_en = $name['en'];
        $this->save();

        return $name;
    }


}
