<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use omgdef\multilingual\MultilingualTrait;
use omgdef\multilingual\MultilingualQuery;
use omgdef\multilingual\MultilingualBehavior;
use yii\helpers\ArrayHelper;

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
            [['item_id', 'm2', 'm2min', 'valute_id', 'price_period', 'ai', 'commission', 'plan_comment', 'hide', 'archive', 'price', 'con_price', 'status_id', 'rent', 'hits', 'hide_contacts', 'hide_bc'], 'integer'],
            [['opex', 'tax', 'kop', 'opex_tax', 'kop_type'], 'number'],
            [['name', 'name_ua', 'name_en', 'fio', 'fio_ua', 'fio_en', 'stage_name', 'phone', 'email'], 'string', 'max' => 255],
            [['title', 'title_ua', 'title_en', 'keywords', 'keywords_ua', 'keywords_en', 'description', 'description_ua', 'description_en'], 'string', 'max' => 255],
            [['comment', 'comment_ua', 'comment_en', 'stage_name'], 'string'],
            [['uploaded', 'deleted', 'upfile', 'delfile'], 'safe'],
            ['no_bc', 'default', 'value' => null],
            ['hide_bc', 'default', 'value' => 1],
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


    public function getStageImg()
    {
        return $this->hasOne(SystemFiles::className(), ['attachment_id' => 'id'])
            ->andWhere(['attachment_type' => self::tableName()])
            ->andWhere(['field' => 'stage_img']);
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
        return $this->hasMany(BcPlacesPrice::className(), ['place_id' => 'id']);
    }

    public function getPeriod()
    {
        return $this->hasOne(BcPeriods::className(), ['id' => 'price_period']);
    }

    public function getAllPrices($rates)
    {
        if ($this->con_price === 1) {
            return null;
        }

        $rate = $rates[$this->valute_id];

        return $rate;
    }

    //цены за кв.м. в месяц
    protected function getMainPrice($rates)
    {
        if ($this->con_price === 1) {
            return null;
        }
        $rate = $rates[$this->valute_id];
        $price = $this->price;
        switch ($this->price_period) {
            case 1:
                $price = round($price * $rate);
                break;
            case 2:
                $price = round($price * $rate / 12);
                break;
            case 3:
                $price = round($price * $rate / $this->m2);
                break;
            default:
                break;
        }

        return $price;
    }

    protected function calculatedPrice($price, $rates, $taxes)
    {
        $taxIndex = (int) $this->tax;
        $opexIndex = (int) $this->opex_tax;

        $stavkaTax = $this->tax == 1 || $this->tax == 4
            ? $price + ($price * $taxes[$taxIndex]) / 100
            : $price;
        $opexValuteId = !empty($this->opex_valute_id) ? $this->opex_valute_id : 1;
        $opex_uah = $this->opex * $rates[$opexValuteId];
        $opex = ($this->opex_tax == 1 || $this->opex_tax == 4)
            ? ($opex_uah + ($opex_uah * $taxes[$opexIndex]) / 100)
            : $opex_uah;
        $stavka = round($stavkaTax + $opex);

        return $stavka;
    }
    
    protected function getPlaceKop() {
      return $this->kop > 0 ? ($this->m2 + ($this->m2 * $this->kop) / 100) : $this->m2;  
    }

    public function getPricePeriod($rates, $taxes)
    {
        if ($this->con_price === 1 || $this->price == 0) {
            return null;
        }
        $price = $this->getMainPrice($rates);
        $pricesPeriod = [];
        $pricesPeriod['uah']['m2'] = $price;
        $pricesPeriod['usd']['m2'] = round($price/$rates[2]);
        $pricesPeriod['eur']['m2'] = round($price/$rates[3]);
        $pricesPeriod['rub']['m2'] = round($price/$rates[4]);

        $calculatedPrice = $this->calculatedPrice($price, $rates, $taxes);
        $pricesPeriod['uah']['m2_2'] = $calculatedPrice;
        $pricesPeriod['usd']['m2_2'] = round($calculatedPrice/$rates[2]);
        $pricesPeriod['eur']['m2_2'] = round($calculatedPrice/$rates[3]);
        $pricesPeriod['rub']['m2_2'] = round($calculatedPrice/$rates[4]);

        $forMonth = $calculatedPrice * $this->getPlaceKop();
        $forYear = $forMonth*12;

        $pricesPeriod['uah']['month'] = $forMonth;
        $pricesPeriod['usd']['month'] = round($forMonth/$rates[2]);
        $pricesPeriod['eur']['month'] = round($forMonth/$rates[3]);
        $pricesPeriod['rub']['month'] = round($forMonth/$rates[4]);

        $pricesPeriod['uah']['year'] = $forYear;
        $pricesPeriod['usd']['year'] = round($forYear/$rates[2]);
        $pricesPeriod['eur']['year'] = round($forYear/$rates[3]);
        $pricesPeriod['rub']['year'] = round($forYear/$rates[4]);

        return $pricesPeriod;
    }



    public function _getPricePeriod($prices)
    {
        $pricesPeriod = [];
        foreach ($prices as $price) {
            if ($price->valute_id == 1) {
                switch ($price->period_id) {
                    case 1:
                        $pricesPeriod['uah']['m2'] = $price->price;
                        break;
                    case 100:
                        $pricesPeriod['uah']['month'] = $price->price;
                        break;
                    case 101:
                        $pricesPeriod['uah']['year'] = $price->price;
                        break;
                    case 102:
                        $pricesPeriod['uah']['m2_2'] = $price->price;
                        break;
                }
            } elseif ($price->valute_id == 2) {
                switch ($price->period_id) {
                    case 1:
                        $pricesPeriod['usd']['m2'] = $price->price;
                        break;
                    case 100:
                        $pricesPeriod['usd']['month'] = $price->price;
                        break;
                    case 101:
                        $pricesPeriod['usd']['year'] = $price->price;
                        break;
                    case 102:
                        $pricesPeriod['usd']['m2_2'] = $price->price;
                        break;
                }
            } elseif ($price->valute_id == 3) {
                switch ($price->period_id) {
                    case 1:
                        $pricesPeriod['eur']['m2'] = $price->price;
                        break;
                    case 100:
                        $pricesPeriod['eur']['month'] = $price->price;
                        break;
                    case 101:
                        $pricesPeriod['eur']['year'] = $price->price;
                        break;
                    case 102:
                        $pricesPeriod['eur']['m2_2'] = $price->price;
                        break;
                }
            } elseif ($price->valute_id == 4) {
                switch ($price->period_id) {
                    case 1:
                        $pricesPeriod['rub']['m2'] = $price->price;
                        break;
                    case 100:
                        $pricesPeriod['rub']['month'] = $price->price;
                        break;
                    case 101:
                        $pricesPeriod['rub']['year'] = $price->price;
                        break;
                    case 102:
                        $pricesPeriod['rub']['m2_2'] = $price->price;
                        break;
                }
            }
        }
        return $pricesPeriod;
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

    public function getM2range()
    {
        if (isset($this->m2min) && $this->m2min != null) {
            return ($this->m2min . '-' . $this->m2);
        }
        return ($this->m2);
    }

    public function getBcitem()
    {
        return $this->hasOne(BcItems::className(), ['id' => 'item_id']);
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
                $item = $this->no_bc === 1 ? $this->office : $this->bcitem;
                $slug = 'arenda-ofica-' . $this->m2 . '-m2-' . $item->city->name . '-id' . $this->id;
                $this->alias = Slugs::generateSlug($this->tableName(), $this->id, $slug);
            }
        }

        $m2 = explode('-', $this->showm2);

        if (count($m2) == 2) {
            $this->m2min = $m2[0];
            $this->m2 = $m2[1];
        } else {
            $this->m2 = $this->showm2;
            $this->m2min = null;
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
            Slugs::deleteAll(['model_id' => $this->id, 'model' => $this->tableName()]);
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
            if (empty($this->alias)) {
                $item = $this->no_bc === 1 ? $this->office : $this->bcitem;
                $slug = 'arenda-ofica-' . $this->m2 . '-m2-' . $item->city->name . '-id' . $this->id;
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
        $sqm_text = '';
        $sqm_text_ua = '';
        $sqm_text_en = '';

        $arenda = Synonyms::find()->where(['series' => 1])->orderBy('counter')->one();
        $arenda->counter++;
        $arenda->save();
        $arenda_ru = $arenda->word;
        $arenda_ua = $arenda->word_ua;
        $arenda_en = $arenda->word_en;

        $sqm = !empty($this->m2min) ? $this->m2min : $this->m2;
        if ($sqm > 0) {
            $sqm_model = Synonyms::find()->where(['series' => 2])->orderBy('counter')->one();
            $sqm_model->counter++;
            $sqm_model->save();

            $sqm_text = ' площадью ' . $sqm . ' ' . $sqm_model->word;
            $sqm_text_ua = ' площею ' . $sqm . ' ' . $sqm_model->word;
            $sqm_text_en = ' area of ' . $sqm . ' ' . $sqm_model->word_en;
        }
        $city = $this->no_bc === 1 ? $this->office->city : $this->bcitem->city;
        $city_ru = $city->name;
        $city_ua = $city->name_ua;
        $city_en = $city->name_en;

        $name['ru'] = $arenda_ru . $sqm_text . ' г.' . $city_ru;
        $name['ua'] = $arenda_ua . $sqm_text_ua . ' м.' . $city_ua;
        $name['en'] = $arenda_en . $sqm_text_en . ' - ' . $city_en;

        /*$this->name = $name['ru'];
        $this->name_ua = $name['ua'];
        $this->name_en = $name['en'];
        $this->save();*/

        return $name;
    }

    public function calcPrice()
    {
        $item = $this->no_bc === 1 ? $this->office : $this->bcitem; //debug($this->offfice);
        BcPlacesPrice::deleteAll(['place_id' => $this->id]);
        if ($this->con_price == 1 || $this->price < 1) return (0);

        $valutes = BcValutes::find()->asArray()->all();
        $valutes = ArrayHelper::map($valutes, 'id', 'rate');

        if ($this->price_period == 1)
            $price_m2 = $this->price;
        elseif ($this->price_period == 2)
            $price_m2 = $this->price / 12;
        elseif ($this->price_period == 3)
            $price_m2 = $this->price / $this->m2;

        $price_m2_uah = $price_m2 * $valutes[$this->valute_id]; //цена в грн.
        // echo $price_m2; die();
        $opex = floatval($this->opex) * $valutes[$this->valute_id]; //0
        $tax = floatval($this->tax); //0
        $kop = floatval($this->kop); //0
        foreach ($valutes as $k => $v) {
            //if($k==3) {echo $v.' - '.$price_m2; die();}
            $price_m2 = round($price_m2_uah / $v, 0);
            //if($k==3) {echo $v.' - '.$price_m2; die();}
            /*****************m2*********************/
            $data = new BcPlacesPrice();
            $data->place_id = $this->id;
            $data->valute_id = $k;
            $data->period_id = 1;
            $data->price = $price_m2;
            $data->city_id = $item->city->id;
            $data->save();
            //debug($data->getErrors());
            /*****************m2 Year*********************/
            $data = new BcPlacesPrice();
            $data->place_id = $this->id;
            $data->valute_id = $k;
            $data->period_id = 2;
            $data->price = $price_m2 * 12;
            $data->city_id = $item->city->id;
            $data->save();
            //debug($data->getErrors());
            /******************Month********************/
            $data = new BcPlacesPrice();
            $data->place_id = $this->id;
            $data->valute_id = $k;
            $data->period_id = 3;
            $data->price = $price_m2 * $this->m2;
            $data->city_id = $item->city->id;
            $data->save();
            //debug($data->getErrors());
            /*****************All In Month*********************/
            $data = new BcPlacesPrice();
            $price_and_opex = round($price_m2 + $opex / $v);
            $data->place_id = $this->id;
            $data->valute_id = $k;
            $data->period_id = 100;
            $data->price = round($this->m2 * ($price_and_opex) +
                ($this->m2 * ($price_and_opex) * $tax / 100) +
                ($this->m2 * ($price_and_opex) * $kop / 100), 0);
            $data->city_id = $item->city->id;
            $allInMonth = $data->price;
            $data->save();
            //debug($data->getErrors());
            /*******************All In Year*******************/
            $data = new BcPlacesPrice();
            $data->place_id = $this->id;
            $data->valute_id = $k;
            $data->period_id = 101;
            $data->price = $allInMonth * 12;
            $data->city_id = $item->city->id;
            $data->save();
            //debug($data->getErrors());
            /*******************All In M2*******************/
            $data = new BcPlacesPrice();
            $data->place_id = $this->id;
            $data->valute_id = $k;
            $data->period_id = 102;
            $data->price = round(1 * ($price_and_opex) +
                (1 * ($price_and_opex) * $tax / 100) +
                (1 * ($price_and_opex) * $kop / 100), 0);
            $data->city_id = $item->city->id;
            $data->save();
            //debug($data->getErrors());
        }
    }

    public function getCountView()
    {
        return $this->hasOne(ViewsCounter::className(), ['item_id' => 'id'])->andWhere(['model' => self::tableName()]);
    }

    public function TempgetAllPrices()
    {
        $valutes = BcValutes::find()->asArray()->all();
        $valutes = ArrayHelper::map($valutes, 'id', 'rate');
        $prices = [];
        foreach ($valutes as $k => $v) {
            $prices[$k] = [
                'stavka' => ['forM2month' => 100, 'forM2year' => 1200, 'forAllMonth' => 100 * $this->m2]
            ];
        }
        return $prices;
    }


}
