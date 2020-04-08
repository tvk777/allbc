<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "bc_places_sell".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property int $item_id
 * @property int $price
 * @property int $m2
 * @property int $m2min
 * @property int $con_price
 * @property int $valute_id
 * @property string $stage_name
 * @property int $price_period
 * @property string $tax
 * @property string $kop
 * @property int $ai
 * @property int $commission
 * @property string $comment
 * @property int $plan_comment
 * @property int $hide
 * @property int $archive
 * @property string $fio
 * @property string $phone
 * @property string $email
 * @property int $status_id
 * @property int $sell
 * @property string $hits
 * @property int $hide_contacts
 */
class BcPlacesSell extends ActiveRecord
{
    public $alias;
    public $latlng;
    public $uploaded;
    public $deleted;
    public $upfile;
    public $delfile;
    public $showm2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bc_places_sell';
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
            [['item_id', 'm2', 'valute_id', 'price_period', 'ai', 'plan_comment', 'hide', 'archive', 'con_price'], 'required'],
            [['item_id', 'm2', 'm2min', 'valute_id', 'price_period', 'ai', 'commission', 'plan_comment', 'hide', 'archive', 'price', 'con_price', 'status_id', 'sell', 'hits', 'hide_contacts', 'hide_bc'], 'integer'],
            [['tax', 'kop'], 'number'],
            [['name', 'name_ua', 'name_en', 'fio', 'fio_ua', 'fio_en', 'stage_name', 'phone', 'email'], 'string', 'max' => 255],
            [['title', 'title_ua', 'title_en', 'keywords', 'keywords_ua', 'keywords_en', 'description', 'description_ua', 'description_en'], 'string', 'max' => 255],
            [['comment', 'comment_ua', 'comment_en', 'stage_name'], 'string'],
            [['uploaded', 'deleted', 'upfile', 'delfile'], 'safe'],
            ['no_bc', 'default', 'value' => null],
            [['hide_bc', 'sell'], 'default', 'value' => 1],
            ['plan_comment', 'default', 'value' => 0],
            ['showm2', 'required', 'message' => 'Необходимо указать площадь помещения в кв.м.'],
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
            'price' => Yii::t('app', 'Price'),
            'm2' => Yii::t('app', 'M2'),
            'm2min' => Yii::t('app', 'M2min'),
            'con_price' => Yii::t('app', 'Con Price'),
            'valute_id' => Yii::t('app', 'Valute ID'),
            'stage_name' => Yii::t('app', 'Stage Name'),
            'price_period' => Yii::t('app', 'Price Period'),
            'tax' => Yii::t('app', 'Tax'),
            'kop' => Yii::t('app', 'Kop'),
            'ai' => Yii::t('app', 'Ai'),
            'commission' => Yii::t('app', 'Commission'),
            'comment' => Yii::t('app', 'Comment'),
            'plan_comment' => Yii::t('app', 'Plan Comment'),
            'hide' => Yii::t('app', 'Hide'),
            'archive' => Yii::t('app', 'Archive'),
            'fio' => Yii::t('app', 'Fio'),
            'phone' => Yii::t('app', 'Phone'),
            'email' => Yii::t('app', 'Email'),
            'status_id' => Yii::t('app', 'Status ID'),
            'sell' => Yii::t('app', 'Sell'),
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
        return $this->hasMany(SystemFiles::className(), ['attachment_id' => 'id'])->andWhere(['attachment_type' => self::tableName()])->andWhere(['field'=>'imgs'])->orderBy('sort_order');
    }


    public function getStageImg(){
        return $this->hasOne(SystemFiles::className(), ['attachment_id' => 'id'])
            ->andWhere(['attachment_type'=>self::tableName()])
            ->andWhere(['field'=>'stage_img']);
    }

    public function getSlides()
    {
        $slides = [];
        if (count($this->images) > 0) {
            foreach ($this->images as $i => $img) {
                $slides[$i]['thumb'] = $img->thumb300x200Src;
                $slides[$i]['big'] = $img->imgSrc;
            }
        }
        return $slides;
    }

    public function getPrices()
    {
        return $this->hasMany(BcPlacesSellPrice::className(), ['place_id' => 'id']);
    }

    //цена в грн. за кв.м.
    public function getPriceSqm()
    {
        return $this->hasOne(BcPlacesSellPrice::className(), ['place_id' => 'id'])
            ->andWhere((['bc_places_sell_price.valute_id' => 1]))
            ->andWhere((['bc_places_sell_price.period_id' => 1]));
    }


    public function getPeriod(){
        return $this->hasOne(BcPeriodsSell::className(), ['id'  => 'price_period']);
    }

    public function getPricePeriod($prices){
        $pricesPeriod = [];
        foreach($prices as $price){
            if($price->valute_id ==1){
                switch ($price->period_id){
                    case 1:
                        $pricesPeriod['uah']['m2'] = $price->price;
                        break;
                    case 2:
                        $pricesPeriod['uah']['value'] = $price->price;
                        break;
                    case 100:
                        $pricesPeriod['uah']['full'] = $price->price;
                        break;
                }
            }
            elseif ($price->valute_id ==2){
                switch ($price->period_id){
                    case 1:
                        $pricesPeriod['usd']['m2'] = $price->price;
                        break;
                    case 2:
                        $pricesPeriod['usd']['value'] = $price->price;
                        break;
                    case 100:
                        $pricesPeriod['usd']['full'] = $price->price;
                        break;
                }
            }
            elseif ($price->valute_id ==3){
                switch ($price->period_id){
                    case 1:
                        $pricesPeriod['eur']['m2'] = $price->price;
                        break;
                    case 2:
                        $pricesPeriod['eur']['value'] = $price->price;
                        break;
                    case 100:
                        $pricesPeriod['eur']['full'] = $price->price;
                        break;
                }
            }
            elseif ($price->valute_id ==4){
                switch ($price->period_id){
                    case 1:
                        $pricesPeriod['rub']['m2'] = $price->price;
                        break;
                    case 2:
                        $pricesPeriod['rub']['value'] = $price->price;
                        break;
                    case 100:
                        $pricesPeriod['rub']['full'] = $price->price;
                        break;
                }
            }
        }
        return $pricesPeriod;
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

    public function getM2range()
    {
        if (isset($this->m2min) && $this->m2min != null) {
            return ($this->m2min . '-' . $this->m2);
        }
        return ($this->m2);
    }

    public function getBcitem()
    {
        return $this->hasOne(BcItems::className(), ['id' => 'item_id'])->with('translations');
    }

    public function getOffice()
    {
        return $this->hasOne(Offices::className(), ['id' => 'item_id']);
    }

    public function getSlug()
    {
        return $this->hasOne(Slugs::className(), ['model_id' => 'id'])->andWhere(['model' => self::tableName()]);
    }

    public function getStatus()
    {
        return $this->hasOne(BcStatuses::className(), ['id' => 'status_id']);
    }

    public function beforeValidate()
    {
        if (!$this->isNewRecord) {
            if (empty($this->alias)) {
                $item = $this->no_bc===1 ? $this->office : $this->bcitem;
                $slug = 'prodazha-ofica-' . $this->m2 . '-m2-' . $item->city->name . '-id' . $this->id;
                $this->alias = Slugs::generateSlug($this->tableName(), $this->id, $slug);
            }
        }

        $m2 = explode('-', $this->showm2);
        if (count($m2)==2) {
            $this->m2min = $m2[0];
            $this->m2 = $m2[1];
        } else {
            $this->m2 = $this->showm2;
        }

        if (empty($this->name) || empty($this->name_ua) || empty($this->name_en)) {
            $name = $this->createName();
            $this->name = $name['ru'];
            $this->name_ua = $name['ua'];
            $this->name_en = $name['en'];
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
        $this->calcPrice();

        if ($insert) {
            if(empty($this->alias)) {
                $item = $this->no_bc===1 ? $this->office : $this->bcitem;
                $slug = 'prodazha-ofica-' . $this->m2 . '-m2-' . $item->city->name . '-id' . $this->id;
                $this->alias = Slugs::generateSlug($this->tableName(), $this->id, $slug);
            }
            Slugs::initialize($this->tableName(), $this->id, $this->alias);
        } else {
            if (isset($changedAttributes['price']) && $changedAttributes['price'] != $this->price ||
                isset($changedAttributes['valute_id']) && $changedAttributes['valute_id'] != $this->valute_id ||
                isset($changedAttributes['price_period']) && $changedAttributes['price_period'] != $this->price_period ||
                isset($changedAttributes['con_price']) && $changedAttributes['con_price'] != $this->con_price
            ) $this->calcPrice();

            if ($this->alias != $this->slug->slug) {
                Slugs::updateSlug($this->tableName(), $this->id, $this->alias);
            }
        }

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
            $delfile = explode(',', $this->delfile);
            SystemFiles::deleteAll(['in', 'id', $delfile]);
        }
        parent::afterSave($insert, $changedAttributes);
    }

    public function createName()
    {
        $name = [];
        $sqm_text = '';
        $sqm_text_ua = '';
        $sqm_text_en = '';

        $prodazha = Synonyms::find()->where(['series' => 3])->orderBy('counter')->one();
        $prodazha->counter++;
        $prodazha->save();
        $prodazha_ru = $prodazha->word;
        $prodazha_ua = $prodazha->word_ua;
        $prodazha_en = $prodazha->word_en;

        $sqm = !empty($this->m2min) ? $this->m2min : $this->m2;
        if ($sqm > 0) {
            $sqm_model = Synonyms::find()->where(['series' => 2])->orderBy('counter')->one();
            $sqm_model->counter++;
            $sqm_model->save();

            $sqm_text = ' площадью ' . $sqm . ' ' . $sqm_model->word;
            $sqm_text_ua = ' площею ' . $sqm . ' ' . $sqm_model->word;
            $sqm_text_en = ' area of ' . $sqm . ' ' . $sqm_model->word_en;
        }
        $city = $this->no_bc===1 ? $this->office->city : $this->bcitem->city;
        $city_ru = $city->name;
        $city_ua = $city->name_ua;
        $city_en = $city->name_en;

        $name['ru'] = $prodazha_ru . $sqm_text . ' г.' . $city_ru;
        $name['ua'] = $prodazha_ua . $sqm_text_ua . ' м.' . $city_ua;
        $name['en'] = $prodazha_en . $sqm_text_en . ' - ' . $city_en;

        return $name;
    }

    public function calcPrice()
    {
        $item = $this->no_bc===1 ? $this->office : $this->bcitem;
        BcPlacesSellPrice::deleteAll(['place_id' => $this->id]);
        if ($this->con_price == 1 || $this->price < 1) return (0);

        $valutes = BcValutes::find()->asArray()->all();
        $valutes = ArrayHelper::map($valutes, 'id', 'rate');

        if ($this->price_period == 1)
            $price_m2 = $this->price;
        elseif ($this->price_period == 2)
            $price_m2 = $this->price / $this->m2;

        $price_m2 = $price_m2 * $valutes[$this->valute_id];
        //$opex = floatval($this->opex) * $valutes[$this->valute_id];
        $tax = floatval($this->tax);
        $kop = floatval($this->kop);
        foreach ($valutes as $k => $v) {
            $price_m2 = round($price_m2 / $v, 0);
            $full_price = $price_m2 * $this->m2;
            /*****************m2*********************/
            $data = new BcPlacesSellPrice();
            $data->place_id = $this->id;
            $data->valute_id = $k;
            $data->period_id = 1;
            $data->price = $price_m2;
            $data->city_id = $item->city->id;
            $data->save();
            //debug($data->getErrors());
            /*****************Full*********************/
            $data = new BcPlacesSellPrice();
            $data->place_id = $this->id;
            $data->valute_id = $k;
            $data->period_id = 2;
            $data->price = $full_price;
            $data->city_id = $item->city->id;
            $data->save();
            //debug($data->getErrors());
            /******************All In Full********************/
            $data = new BcPlacesSellPrice();
            $data->place_id = $this->id;
            $data->valute_id = $k;
            $data->period_id = 100;
            $data->price = round((1 * $full_price) +(1 * $full_price * $tax / 100) +(1 * $full_price * $kop / 100),0);
            $data->city_id = $item->city->id;
            $data->save();
            //debug($data->getErrors());
        }
    }

    public function getCountView()
    {
        return $this->hasOne(ViewsCounter::className(), ['item_id' => 'id'])->andWhere(['model' => self::tableName()]);
    }


}
