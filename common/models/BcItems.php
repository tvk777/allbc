<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use omgdef\multilingual\MultilingualTrait;
use omgdef\multilingual\MultilingualQuery;
use omgdef\multilingual\MultilingualBehavior;
use common\models\Geo;
use yii\helpers\ArrayHelper;


/**
 * This is the model class for table "bc_items".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property int $city_id
 * @property int $country_id
 * @property int $district_id
 * @property string $street
 * @property string $lat
 * @property string $lng
 * @property int $sort_order
 * @property int $class_id
 * @property int $percent_commission
 * @property int $active
 * @property string $contacts_admin
 * @property int $hide
 * @property string $redirect
 * @property int $hide_contacts
 * @property string $email
 * @property string $email_name
 * @property int $approved
 */
class BcItems extends ActiveRecord
{
    public $alias;
    public $latlng;
    public $uploaded;
    public $deleted;
    public $cityName;
    public $countryName;
    public $districtName;
    public $filteredPlace;
    public $minm2;
    public $maxm2;
    public $minprice;
    public $maxprice;
    public $formCharacteristics;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bc_items';
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
                'langForeignKey' => 'item_id',
                'tableName' => "{{%bc_itemsLang}}",
                'attributes' => [
                    'name', 'content', 'title', 'keywords', 'description', 'annons', 'mgr_content', 'shuttle', 'contacts'
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
            [['name', 'content', 'title', 'keywords', 'description', 'annons', 'mgr_content', 'shuttle', 'contacts'], 'string'],
            [['name_ru', 'content_ru', 'title_ru', 'keywords_ru', 'description_ru', 'annons_ru', 'mgr_content_ru', 'shuttle_ru', 'contacts_ru', 'name_ua', 'content_ua', 'title_ua', 'keywords_ua', 'description_ua', 'annons_ua', 'mgr_content_ua', 'shuttle_ua', 'contacts_ua', 'name_en', 'content_en', 'title_en', 'keywords_en', 'description_en', 'annons_en', 'mgr_content_en', 'shuttle_en', 'contacts_en', 'city_id', 'country_id', 'district_id'], 'safe'],
            [['created_at', 'updated_at', 'deleted_at', 'uploaded', 'deleted'], 'safe'],
            [['sort_order', 'class_id', 'percent_commission', 'active', 'hide', 'hide_contacts', 'approved', 'count_view'], 'integer'],
            [['city_id', 'country_id', 'street', 'lat', 'lng', 'sort_order', 'class_id', 'active', 'hide'], 'required'],
            [['lat', 'lng', 'total_m2'], 'number'],
            [['contacts_admin'], 'string'],
            [['street', 'redirect', 'email', 'email_name'], 'string', 'max' => 255],
            [['minm2', 'maxm2', 'minprice', 'maxprice'], 'safe'],
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
            'deleted_at' => Yii::t('app', 'Deleted At'),
            'city_id' => Yii::t('app', 'City ID'),
            'country_id' => Yii::t('app', 'Country ID'),
            'district_id' => Yii::t('app', 'District ID'),
            'street' => Yii::t('app', 'Street'),
            'lat' => Yii::t('app', 'Lat'),
            'lng' => Yii::t('app', 'Lng'),
            'sort_order' => Yii::t('app', 'Sort Order'),
            'class_id' => Yii::t('app', 'Class'),
            'percent_commission' => Yii::t('app', 'Percent Commission'),
            'active' => Yii::t('app', 'Published'),
            'contacts_admin' => Yii::t('app', 'Contacts Admin'),
            'hide' => Yii::t('app', 'Hide'),
            'redirect' => Yii::t('app', 'Redirect'),
            'hide_contacts' => Yii::t('app', 'Hide Contacts'),
            'email' => Yii::t('app', 'Email'),
            'email_name' => Yii::t('app', 'Email Name'),
            'approved' => Yii::t('app', 'Approved'),
            'name' => Yii::t('app', 'Name'),
            'annons' => Yii::t('app', 'Annons'),
            'content' => Yii::t('app', 'Content'),
            'mgr_content' => Yii::t('app', 'Mgr_content'),
            'shuttle' => Yii::t('app', 'Shuttle'),
            'cityName' => Yii::t('app', 'Город'),
            'countryName' => Yii::t('app', 'Страна'),
            'districtName' => Yii::t('app', 'Район'),
            'total_m2' => Yii::t('app', 'Общая площадь здания, кв.м.'),
            'count_view' => 'Количество просмотров'
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

    public function getClass()
    {
        return $this->hasOne(BcClasses::className(), ['id' => 'class_id']);
    }

    public function getUsers()
    {
        return $this->hasMany(BcItemsUsers::className(), ['item_id' => 'id'])->andWhere(['model' => $this->tableName()]);
    }

    public function getBrokers()
    {
        return $this->hasMany(BcItemsBrokers::className(), ['item_id' => 'id'])->andWhere(['model' => $this->tableName()]);
    }

    public function getOwners()
    {
        return $this->hasMany(BcItemsOwners::className(), ['item_id' => 'id'])->andWhere(['model' => $this->tableName()]);
    }

    public function getCharacteristics()
    {
        return $this->hasMany(BcItemsCharacteristics::className(), ['item_id' => 'id'])->orderBy('sort_order');
    }


    public function getSubways()
    {
        return $this->hasMany(BcItemsSubways::className(), ['item_id' => 'id'])->andWhere(['model' => $this->tableName()]);
    }

    public function getPlaces()
    {
        return $this->hasMany(BcPlaces::className(), ['item_id' => 'id'])->andWhere(['archive' => 0])->andWhere(['bc_places.hide' => 0]);
    }

    public function getPlacesSell()
    {
        return $this->hasMany(BcPlacesSell::className(), ['item_id' => 'id'])->andWhere(['archive' => 0])->andWhere(['hide' => 0]);
    }

    public function getArchivePlaces()
    {
        return $this->hasMany(BcPlaces::className(), ['item_id' => 'id'])->andWhere(['archive' => 1])->andWhere(['hide' => 0]);
    }

    public function getArchivePlacesSell()
    {
        return $this->hasMany(BcPlacesSell::className(), ['item_id' => 'id'])->andWhere(['archive' => 1])->andWhere(['hide' => 0]);
    }


    public function getImages()
    {
        return $this->hasMany(SystemFiles::className(), ['attachment_id' => 'id'])->andWhere(['attachment_type' => self::tableName()])->orderBy('sort_order');
    }

    public function getThumbs300x200()
    {
        $thumbs = [];
        if (count($this->images) > 0) {
            foreach ($this->images as $img) {
                $thumbs[] = $img->thumb300x200Src;
            }
        }
        return $thumbs;
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


    public function getCity()
    {
        return $this->hasOne(GeoCities::className(), ['id' => 'city_id']);
    }

    public function getCountry()
    {
        return $this->hasOne(GeoCountries::className(), ['id' => 'country_id']);
    }

    public function getDistrict()
    {
        return $this->hasOne(GeoDistricts::className(), ['id' => 'district_id']);
    }

    public function beforeValidate()
    {
        if (empty($this->alias)) {
            $this->alias = Slugs::generateSlug($this->tableName(), $this->id, $this->name);
        }

        if ($this->sort_order == null) {
            $this->sort_order = BcItems::find()->max('sort_order') + 1;
        }
        //$this->total_m2 = str_replace(',', '.', $this->total_m2);
        return parent::beforeValidate();
    }

    public function beforeSave($insert)
    {
        //debug($this->city_id); die();
        //debug(Yii::$app->request->post('Subways')); die();
        $city_id = Geo::getCityValue($this->city_id);
        $country_id = Geo::getCountryValue($this->country_id);
        $district_id = Geo::getDistrictValue($this->district_id);
        //Geo::getSubwaysValue($old, $new);
        if ($city_id === 0 || $country_id === 0) {
            $this->city_id = $this->oldAttributes['city_id'];
            $this->country_id = $this->oldAttributes['country_id'];
            return false;
        }
        if (parent::beforeSave($insert)) {
            $this->city_id = $city_id;
            $this->country_id = $country_id;
            $this->district_id = $district_id;
            return true;
        } else {
            return false;
        }
    }

    public function saveCharacteristics($bcitem)
    {
        $flag=false;
        $id = $bcitem->id;
        $characteristics = $bcitem->formCharacteristics;
        BcItemsCharacteristics::deleteAll(['and', ['item_id' => $id],['not in', 'characteristic_id', array_keys($characteristics)]]);

        foreach ($characteristics as $key => $char) {
            $model = BcItemsCharacteristics::find()->where(['item_id' => $id])->andWhere(['characteristic_id' => $key])->one();
            if(!$model){
                $model = new BcItemsCharacteristics();
                $model->item_id = $id;
                $model->characteristic_id = $key;
            }
            $model->value = '';
            $model->value_ua = '';
            $model->value_en = '';
            foreach($char as $lng => $val){
                switch ($lng){
                    case 'ua':
                        $model->value_ua = $val;
                        break;
                    case 'ru':
                        $model->value = $val;
                        break;
                    case 'en':
                        $model->value_en = $val;
                        break;
                }
            }


            $flag = $model->save();
        }
        return $flag;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        //debug($this->formCharacteristics); die();
        if(!empty($this->formCharacteristics)){
            if(!$this->saveCharacteristics($this)) echo 'error';
        }

        if ($insert) {
            Slugs::initialize($this->tableName(), $this->id, $this->alias);
        } else {
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
        if (!empty($this->deleted)) {
            $deleted = explode(',', $this->deleted);
            SystemFiles::deleteAll(['in', 'id', $deleted]);
        }

        $bc_count = BcItems::find()->where(['city_id' => $this->city_id])->andWhere(['active' => 1])->count();
        $city = GeoCities::findOne($this->city_id);

        $city->bc_count = $bc_count;
        $city->save();

        $new_subways = Yii::$app->request->post('Subways');
        //debug($new_subways); die();
        if (!empty($new_subways)) {
            $old_subways = ArrayHelper::map($this->subways, 'subway_id', 'subway_id');
            foreach ($new_subways as $one) {
                if ($one['subway_id'] && !in_array($one['subway_id'], $old_subways)) {
                    $itemSubway = new BcItemsSubways();
                    $itemSubway->item_id = $this->id;
                    $itemSubway->subway_id = $one['subway_id'];
                    $itemSubway->walk_distance = $one['walk_distance'];
                    $itemSubway->walk_seconds = $one['walk_seconds'] * 60;
                    $itemSubway->model = $this->tableName();
                    $itemSubway->save();
                }
                if (isset($old_subways[$one['subway_id']])) {
                    unset($old_subways[$one['subway_id']]);
                }
            }
            BcItemsSubways::deleteAll(['subway_id' => $old_subways]);
        }

    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            Slugs::deleteAll(['model_id' => $this->id]);
            BcItemsCharacteristics::deleteAll(['item_id' => $this->id]);
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

    public function getFilteredPlaces($places, $target)
    {
        $placesIds = ArrayHelper::getColumn($places, 'id');
        $itemPlaces = $target == 1 ? $this->places : $this->placesSell;
        $filteredPlaces = [];
        foreach ($itemPlaces as $place) {
            if (in_array($place->id, $placesIds)) {
                $filteredPlaces[] = $place;
            }
        }
        return $filteredPlaces;
    }

    public function getMinMaxM2($places)
    {
        $MinMaxM2 = [];
        $m2s = ArrayHelper::getColumn($places, 'm2');
        $m2mins = ArrayHelper::getColumn($places, 'm2min');
        $min = !empty($m2s) ? min($m2s) : 0;
        $min2 = !empty($m2mins) ? min($m2mins) : 0;
        if ($min2 > 0 && $min2 < $min) {
            $MinMaxM2['min'] = $min2;
        } else {
            $MinMaxM2['min'] = $min;
        }
        $MinMaxM2['max'] = !empty($m2s) ? max($m2s) : 0;

        if ($MinMaxM2['max'] == $MinMaxM2['min']) {
            return $MinMaxM2['max'];
        }
        return $MinMaxM2;
    }

    public function getMinPrice($places)
    {
        $in = ArrayHelper::getColumn($places, 'id');
        $result = (new \yii\db\Query())
            ->select(['price'])
            ->from('bc_places_price')
            ->where(['in', 'place_id', $in])
            ->andWhere(['period_id' => 1])
            ->andWhere(['valute_id' => 1])
            ->orderBy('price')
            ->one();
        if ($result) {
            return $result;
        } else {
            return 0;
        }
    }

    public function getPlacesInfo($places)
    {
        //debug($places);
        if ($places) {
            $placesInfo = [];
            foreach ($places as $v) {
                $placesInfo[$v['id']]['m2'] = $v['m2min'] ? $v['m2min'] . '-' . $v['m2'] : $v['m2'];
                if (isset($v['stageImg']['disk_name'])) {
                    $placesInfo[$v['id']]['img'][] = $this->getImgSrc($v['stageImg']['disk_name']);
                }
                if (!empty($v['images'])) {
                    foreach ($v['images'] as $img) {
                        $placesInfo[$v['id']]['img'][] = $this->getImgSrc($img['disk_name']);
                    }
                }
                if (!empty($v['prices'])) {
                    foreach ($v['prices'] as $price) {
                        if ($price['valute_id'] == 1 && $price['period_id'] == 1)
                            $placesInfo[$v['id']]['for_m2'] = $price['price'];
                        if ($price['valute_id'] == 1 && $price['period_id'] == 100)
                            $placesInfo[$v['id']]['for_all'] = $price['price'];
                        if ($price['valute_id'] == 1 && $price['period_id'] == 102)
                            $placesInfo[$v['id']]['all_for_m2'] = $price->price;
                    }
                } else {
                    $placesInfo[$v['id']]['for_m2'] = Yii::t('app', 'con.');
                    $placesInfo[$v['id']]['for_all'] = Yii::t('app', 'con.');
                }
            }
            return $placesInfo;
        }
        return 0;
    }

    protected function getImgSrc($name)
    {
        $dir0 = '/uploads/';
        $dir1 = substr($name, 0, 3) . '/';
        $dir2 = substr($name, 3, 3) . '/';
        $dir3 = substr($name, 6, 3) . '/';
        return $dir0 . $dir1 . $dir2 . $dir3 . $name;
    }

    /**
     * Счетчик просмотров страницы БЦ с записью id в сессию
     * данный подход исключает накрутку просмотров за сессию
     * @return bool
     */
    public function processCountViewBcItem()
    {
        $session = Yii::$app->session;
        // Если в сессии отсутствуют данные,
        // создаём, увеличиваем счетчик, и записываем в бд
        if (!isset($session['bcitem_view'])) {
            $session->set('bcitem_view', [$this->id]);
            $this->updateCounters(['count_view' => 1]);
            // Если в сессии уже есть данные то проверяем засчитывался ли данный пост
            // если нет то увеличиваем счетчик, записываем в бд и сохраняем в сессию просмотр этого поста
        } else {
            if (!ArrayHelper::isIn($this->id, $session['bcitem_view'])) {
                $array = $session['bcitem_view'];
                array_push($array, $this->id);
                $session->remove('bcitem_view');
                $session->set('bcitem_view', $array);
                $this->updateCounters(['count_view' => 1]);
            }
        }
        return true;
    }

}


