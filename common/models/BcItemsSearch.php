<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\BcItems;
use common\models\BcPlaces;
use common\models\BcPlacesSell;
use yii\helpers\ArrayHelper;
use yii\data\Pagination;

/**
 * BcItemsSearch represents the model behind the search form of `common\models\BcItems`.
 */
class BcItemsSearch extends BcItems
{
    public $m2;
    public $city;
    public $link;
    public $searchString;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'sort_order', 'class_id', 'percent_commission', 'active', 'hide', 'hide_contacts', 'approved', 'single_office'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at', 'address', 'slug', 'contacts_admin', 'redirect', 'email', 'email_name'], 'safe'],
            [['lat', 'lng'], 'number'],
            [['name', 'content', 'title', 'keywords', 'description', 'annons', 'mgr_content', 'shuttle', 'contacts'], 'string'],
            [['city_id', 'country_id', 'district_id', 'm2', 'city', 'link', 'searchString'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = BcItems::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->joinWith(['slug', 'city', 'class']);
        $dataProvider->sort->attributes['link'] = [
            'asc' => ['slugs.slug' => SORT_ASC],
            'desc' => ['slugs.slug' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['city_id'] = [
            'asc' => ['geo_cities.name' => SORT_ASC],
            'desc' => ['geo_cities.name' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['class_id'] = [
            'asc' => ['bc_classes.mid_name' => SORT_ASC],
            'desc' => ['bc_classes.mid_name' => SORT_DESC],
        ];


        $this->load($params);

        $query->orFilterWhere(['like', 'bc_items.name', $this->searchString])
            ->orFilterWhere(['like', 'bc_items.title', $this->searchString])
            ->orFilterWhere(['like', 'bc_items.keywords', $this->searchString])
            ->orFilterWhere(['like', 'bc_items.description', $this->searchString])
            ->orFilterWhere(['like', 'geo_cities.name', $this->searchString])
            ->orFilterWhere(['like', 'slugs.slug', $this->searchString]);

        return $dataProvider;
    }

    protected function initParams($params)
    {
        //$params['page'] = !empty($params['page']) ? $params['page'] : null;
        $params['city'] = !empty($params['city']) ? $params['city'] : null;
        $params['country'] = !empty($params['country']) ? $params['country'] : null;
        $params['percent_commission'] = !empty($params['percent_commission']) ? $params['percent_commission'] : null;
        $params['classes'] = !empty($params['classes']) ? $params['classes'] : null;
        $params['districts'] = !empty($params['districts']) ? $params['districts'] : null;
        $params['subways'] = !empty($params['subways']) ? $params['subways'] : null;
        $params['walk_dist'] = !empty($params['walk_dist']) ? $params['walk_dist'] : null;
        $params['m2min'] = !empty($params['m2min']) ? $params['m2min'] : null;
        $params['m2max'] = !empty($params['m2max']) ? $params['m2max'] : null;
        $params['pricemin'] = !empty($params['pricemin']) ? $params['pricemin'] : null;
        $params['pricemax'] = !empty($params['pricemax']) ? $params['pricemax'] : null;
        $params['currency'] = !empty($params['currency']) ? $params['currency'] : 1;
        $params['result'] = !empty($params['result']) ? $params['result'] : 'offices';
        $params['target'] = !empty($params['target']) ? $params['target'] : 1;
        $params['lang'] = !empty($params['lang']) ? $params['lang'] : 'ua';
        return $params;
    }

    protected function filterConditions($query, $params, $exclude = false)
    {
        if (!empty($params['visibles'])) {
            if ($params['result'] == 'bc') {
                $query->andFilterWhere(['in', 'id', $params['visibles']]);
            } else {
                $query->andFilterWhere(['in', 'pid', $params['visibles']]);
            }
            return $query;
        }

        $query->andFilterWhere([
            'active' => 1,
            'approved' => 1,
            'hide' => 0,
            'phide' => 0,
            'city_id' => $params['city'],
            'country_id' => $params['country'],
            'percent_commission' => $params['commission']
        ]);

        if (!empty($params['user'])) {
            $userItemsIds = $this->getItemsByUser($params['user']);
            $query->andFilterWhere(['in', 'id', $userItemsIds]);
            return $query;
        }

        if ($params['result'] == 'bc') {
            $query->andWhere(['no_bc' => null]);
        }
        $query->andFilterWhere(['in', 'class_id', $params['classes']]);
        $query->andFilterWhere(['in', 'district_id', $params['districts']]);
        $query->andFilterWhere(['in', 'status_id', $params['statuses']]);
        $query->andFilterWhere(['in', 'subway_id', $params['subways']]);
        //$query->andFilterWhere(['<=', 'walk_distance', $params['walk_dist']]);
        $query->andFilterWhere(['or', ['is', 'walk_distance', NULL], ['<=', 'walk_distance', $params['walk_dist']]]);

        if (!$exclude) {
            if (!empty($params['m2min']) && !empty($params['m2max'])) {
                $query->andWhere([
                    'and',
                    ['or', ['<=', 'm2min', $params['m2max']], ['is', 'm2min', NULL]],
                    ['and', ['>=', 'm2', $params['m2min']], ['<=', 'm2', $params['m2max']]]
                ]);

            } elseif (!empty($params['m2min'])) {
                $query->andWhere([
                    'and',
                    ['>=', 'm2', $params['m2min']]
                ]);
            } elseif (!empty($params['m2max'])) {
                $query->andWhere([
                    'or',
                    ['<=', 'm2min', $params['m2max']],
                    ['and', ['is', 'm2min', NULL], ['<=', 'm2', $params['m2max']]]
                ]);
            }

            switch ($params['currency']) {
                case 1:
                    if ($params['type'] == 1) {
                        $query->andFilterWhere(['>=', 'uah_price', $params['pricemin']]);
                        $query->andFilterWhere(['<=', 'uah_price', $params['pricemax']]);
                    } else {
                        $query->andFilterWhere(['>=', 'uah_price_all', $params['pricemin']]);
                        $query->andFilterWhere(['<=', 'uah_price_all', $params['pricemax']]);
                    }
                    break;
                case 2:
                    if ($params['type'] == 1) {
                        $query->andFilterWhere(['>=', 'usd_price', $params['pricemin']]);
                        $query->andFilterWhere(['<=', 'usd_price', $params['pricemax']]);
                    } else {
                        $query->andFilterWhere(['>=', 'usd_price_all', $params['pricemin']]);
                        $query->andFilterWhere(['<=', 'usd_price_all', $params['pricemax']]);
                    }
                    break;
                case 3:
                    if ($params['type'] == 1) {
                        $query->andFilterWhere(['>=', 'eur_price', $params['pricemin']]);
                        $query->andFilterWhere(['<=', 'eur_price', $params['pricemax']]);
                    } else {
                        $query->andFilterWhere(['>=', 'eur_price_all', $params['pricemin']]);
                        $query->andFilterWhere(['<=', 'eur_price_all', $params['pricemax']]);
                    }
                    break;
                case 4:
                    if ($params['type'] == 1) {
                        $query->andFilterWhere(['>=', 'rub_price', $params['pricemin']]);
                        $query->andFilterWhere(['<=', 'rub_price', $params['pricemax']]);
                    } else {
                        $query->andFilterWhere(['>=', 'rub_price_all', $params['pricemin']]);
                        $query->andFilterWhere(['<=', 'rub_price_all', $params['pricemax']]);
                    }
                    break;
            }
        }
        return $query;
    }

    protected function filterConditionByStreet($query, $params)
    {
        switch ($params['lang']) {
            case 'ua':
                $streetField = 'street_ua';
                break;
            case 'ru':
                $streetField = 'street';
                break;
            case 'en':
                $streetField = 'street_en';
                break;
            default:
                $streetField = 'street_ua';
                break;
        }

        $street = $this->getStreetName($params['streetId'], $params['target'], $streetField);
        $query->andFilterWhere(['like', $streetField, $street]);
        return [$query, $street];
    }


    protected function orderByConditions($query, $params)
    {
        if (!empty($params['sort'])) {
            switch ($params['sort']) {
                case 'price_desc':
                    $query->orderBy('con_price, uah_price DESC');
                    break;
                case 'price_asc':
                    $query->orderBy('con_price, uah_price ASC');
                    break;
                case 'm2_desc':
                    $query->orderBy('m2 DESC');
                    break;
                case 'm2_asc':
                    $query->orderBy('m2 ASC');
                    break;
                default:
                    $query->orderBy('updated_at DESC');
                    break;
            }
        } else {
            $query->orderBy('updated_at DESC');
        }
        return $query;
    }

    protected function getMapMarkers($array, $params)
    {
        //debug($params['result']); die();
        //формирование маркеров для карты
        $markers = [];
        $markers['type'] = 'FeatureCollection';
        $markers['result'] = $params['result'];
        $markers['lang'] = $params['lang'];
        $markers['features'] = [];
        foreach ($array as $item) {
            if ($params['result'] === 'bc') {
                $id = $item->id;
                $addres = $item->address;
                $coord = [$item->lng, $item->lat];
                $img = isset($item->bcitem->images[0]) ? $item->bcitem->images[0]->imgSrc : '';
                $class = $item->bcitem->class->short_name;
                $name = getDefaultTranslate('name', $params['lang'], $item, true);
            } else {
                $id = $item->pid;
                $coord = $item->hide_bc == 1 ? [$item->lng_str, $item->lat_str] : [$item->lng, $item->lat];
                $addres = '';
                $img = '';
                $class = '';
                $name = '';

            }
            $feature = [
                'type' => 'Feature',
                'geometry' => [
                    'type' => 'Point',
                    'coordinates' => $coord
                ],
                'properties' => [
                    'id' => $id,
                    'title' => $name,
                    'address' => $addres,
                    'img' => $img,
                    'class' => $class
                ]
            ];
            $markers['features'][] = $feature;
        }
        return $markers;
    }


    public function seoSearchFromView($params)
    {
        $params = $this->initParams($params);
        $pageSize = Yii::$app->settings->page_size;
        $streetName = null;

        //запрос всех строк по условиям фильтра
        if ($params['target'] == 1) {
            $fullQuery = BcPlacesView::find()
                ->with('place', 'place.images');
            if ($params['result'] == 'bc') {
                $fullQuery = $fullQuery->with('bcitem', 'bcitem.images', 'bcitem.subways', 'bcitem.class', 'bcitem.subways.subwayDetails', 'bcitem.city', 'bcitem.slug');
            }
        } else {
            $fullQuery = BcPlacesSellView::find()
                ->with('place', 'place.images');
            if ($params['result'] == 'bc') {
                $fullQuery = $fullQuery->with('bcitem', 'bcitem.images', 'bcitem.subways', 'bcitem.class', 'bcitem.subways.subwayDetails', 'bcitem.city', 'bcitem.slug');
            }
        }

        $filtredQuery = $this->filterConditions($fullQuery, $params);
        $filtredQuery = $this->orderByConditions($filtredQuery, $params);

        if ($params['result'] == 'offices' && !empty($params['streetId'])) {
            $streetQuery = clone $filtredQuery;
            $streetParams = $this->filterConditionByStreet($streetQuery, $params);
            $streetQuery = $streetParams[0];
            $streetName = $streetParams[1];
            $streetQuery = $streetQuery->all();
            $fullStreetsPlaces = getUniqueArray('pid', $streetQuery);
        }

        $filtredQuery = $filtredQuery->all();//Полный запрос всех отфильтрованных и отсортированных строк

        $fullPlaces = getUniqueArray('pid', $filtredQuery);
        $allForPage = [];

        if ($params['result'] == 'bc') {
            //только для выдачи БЦ
            $fullBcItems = getUniqueArray('id', $filtredQuery);
            $itemsForMarkers = $fullBcItems;

            $pages = new Pagination(['totalCount' => count($fullBcItems), 'pageSize' => $pageSize]);
            $pages->pageSizeParam = false;
            $pages->forcePageParam = false;
            $bcItemsForPage = array_slice($fullBcItems, $pages->offset, $pageSize);
            $idsBcitems = ArrayHelper::getColumn($bcItemsForPage, 'id');
            $placesForBcItems = array_filter($fullPlaces, function ($var) use ($idsBcitems) {
                return in_array($var->id, $idsBcitems);
            });

            foreach ($bcItemsForPage as $key => $item) {
                $allForPage[$key]['bc'] = $item;
                $places = [];
                foreach ($placesForBcItems as $place) {
                    if ($place['id'] == $item['id']) {
                        $places = ArrayHelper::merge($places, [$place]);
                        $allForPage[$key]['places'] = $places;
                    }
                }
                $arr = array_filter(ArrayHelper::getColumn($places, 'uah_price'));
                if (!empty($arr)) {
                    $allForPage[$key]['bc']->minPrice = min($arr);
                }

                $arrM2 = array_filter(ArrayHelper::getColumn($places, 'm2'));
                $arrM2min = array_filter(ArrayHelper::getColumn($places, 'm2min'));
                $arr = array_filter(ArrayHelper::merge($arrM2, $arrM2min));
                if (!empty($arr)) {
                    $allForPage[$key]['bc']->minM2 = min($arr);
                    $allForPage[$key]['bc']->maxM2 = max($arr);
                }
            }
        } else {
            $itemsForMarkers = $fullPlaces;
            if ($params['result'] == 'offices' && !empty($params['streetId'])) {
                $fullPlaces = $fullStreetsPlaces;
            }
            $pages = new Pagination(['totalCount' => count($fullPlaces), 'pageSize' => $pageSize]);
            $pages->pageSizeParam = false;
            $pages->forcePageParam = false;
            $allForPage = array_slice($fullPlaces, $pages->offset, $pageSize);
        }

        $markers = $this->getMapMarkers($itemsForMarkers, $params);
        $count_ofices = count($fullPlaces); //count offices

        if ($params['target'] == 1) {
            $forChartsQuery = BcPlacesView::find();
        } else {
            $forChartsQuery = BcPlacesSellView::find();
        }
        $forChartsQuery = $forChartsQuery->andFilterWhere(
            [
                'active' => 1,
                'approved' => 1,
                'hide' => 0,
                'phide' => 0,
                'city_id' => $params['city'],
                'country_id' => $params['country'],
            ]
        )->all();
        //$forChartsQuery = $this->filterConditions($forChartsQuery, $params, true)->all(); //условия фильтра для графиков, если они нужны

        $m2 = ArrayHelper::getColumn($forChartsQuery, 'm2'); //m2 array
        $m2min = ArrayHelper::getColumn($forChartsQuery, 'm2min'); //m2min array
        $m2ForChart = array_filter(ArrayHelper::merge($m2, $m2min)); //all m2 array for chart
        $pricesForChart = array_filter(ArrayHelper::getColumn($forChartsQuery, 'uah_price'));
        $center = !empty($markers['features'][0]['geometry']['coordinates']) ? $markers['features'][0]['geometry']['coordinates'] : null;
//debug($streetName); die();
        $result = [];
        $result['streetName'] = $streetName;
        $result['params'] = $params;
        $result['center'] = $center;
        $result['count_ofices'] = $count_ofices; //количество найденных офисов
        $result['m2ForChart'] = $m2ForChart; //массив кв.м. для графика
        $result['pricesForChart'] = $pricesForChart; //массив цен для графика [0] => 425(uah_price) [1] => 45(m2)
        $result['markers'] = json_encode($markers);
        $result['pages'] = $pages;
        /*массив данных для страницы
        выдача БЦ 'bc' => bcitem, 'places' =>[place1, place2 ... ]
        выдача офисов BcPlacesView Object [place] => common\models\BcPlaces Object
        */
        $result['allForPage'] = $allForPage; //

        return $result;
    }


    protected function getItemsByUser($id)
    {
        $userItems = BcItemsUsers::find()->where(['user_id' => $id])->asArray()->all();
        $userItemsIds = ArrayHelper::getColumn($userItems, 'item_id');
        return $userItemsIds;
    }

    protected function getStreetName($id, $target, $field)
    {
        $query = $target == 1 ? BcPlacesView::find() : BcPlacesSellView::find();
        $street = $query->select($field)->where(['pid' => $id])->asArray()->one();
        return $street[$field];
    }

}


