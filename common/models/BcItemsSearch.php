<?php

namespace common\models;

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

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'sort_order', 'class_id', 'percent_commission', 'active', 'hide', 'hide_contacts', 'approved', 'single_office'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at', 'address', 'slug', 'contacts_admin', 'redirect', 'email', 'email_name'], 'safe'],
            [['lat', 'lng'], 'number'],
            [['city_id', 'country_id', 'district_id', 'm2', 'city'], 'safe'],
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
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'city_id' => $this->city_id,
            'country_id' => $this->country_id,
            'district_id' => $this->district_id,
            'lat' => $this->lat,
            'lng' => $this->lng,
            //'sort_order' => $this->sort_order,
            'class_id' => $this->class_id,
            'percent_commission' => $this->percent_commission,
            'active' => $this->active,
            'hide' => $this->hide,
            'hide_contacts' => $this->hide_contacts,
            'approved' => $this->approved,
            'single_office' => $this->single_office
        ]);

        $query->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'contacts_admin', $this->contacts_admin])
            ->andFilterWhere(['like', 'redirect', $this->redirect])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'email_name', $this->email_name]);

        return $dataProvider;
    }

    protected function initParams($params)
    {
        $params['city'] = !empty($params['city']) ? $params['city'] : null;
        $params['country'] = !empty($params['country']) ? $params['country'] : null;
        $params['percent_commission'] = !empty($params['percent_commission']) ? $params['percent_commission'] : null;
        $params['classes'] = !empty($params['classes']) ? $params['classes'] : null;
        $params['districts'] = !empty($params['districts']) ? $params['districts'] : null;
        $params['subway'] = !empty($params['subway']) ? $params['subway'] : null;
        $params['walk_dist'] = !empty($params['walk_dist']) ? $params['walk_dist'] : null;
        $params['m2min'] = !empty($params['m2min']) ? $params['m2min'] : null;
        $params['m2max'] = !empty($params['m2max']) ? $params['m2max'] : null;
        $params['pricemin'] = !empty($params['pricemin']) ? $params['pricemin'] : null;
        $params['pricemax'] = !empty($params['pricemax']) ? $params['pricemax'] : null;
        $params['currency'] = !empty($params['currency']) ? $params['currency'] : 1;
        $params['result'] = !empty($params['result']) ? $params['result'] : 'offices';
        $params['target'] = !empty($params['target']) ? $params['target'] : 1;
        $params['lang']  = !empty($params['lang']) ? $params['lang'] : 'ua';
        return $params;
    }

    protected function filterConditions($query, $params)
    {
        $query->andFilterWhere([
            'active' => 1,
            'approved' => 1,
            'hide' => 0,
            'phide' => 0,
            'city_id' => $params['city'],
            'country_id' => $params['country'],
            'percent_commission' => $params['percent_commission']
        ]);
        if($params['result']=='bc') {
            $query->andWhere(['no_bc' => null]);
        }
        $query->andFilterWhere(['in', 'class_id', $params['classes']]);
        $query->andFilterWhere(['in', 'district_id', $params['districts']]);
        $query->andFilterWhere(['in', 'subway_id', $params['subway']]);
        $query->andFilterWhere(['<', 'walk_dist', $params['walk_dist']]);

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
                $query->andFilterWhere(['>=', 'uah_price', $params['pricemin']]);
                $query->andFilterWhere(['<=', 'uah_price', $params['pricemax']]);
                break;
            case 2:
                $query->andFilterWhere(['>=', 'usd_price', $params['pricemin']]);
                $query->andFilterWhere(['<=', 'usd_price', $params['pricemax']]);
                break;
            case 3:
                $query->andFilterWhere(['>=', 'eur_price', $params['pricemin']]);
                $query->andFilterWhere(['<=', 'eur_price', $params['pricemax']]);
                break;
            case 4:
                $query->andFilterWhere(['>=', 'rub_price', $params['pricemin']]);
                $query->andFilterWhere(['<=', 'rub_price', $params['pricemax']]);
                break;
        }
        return $query;
    }

    protected function orderByConditions($query, $params)
    {
        if (!empty($params['sort'])) {
            switch ($params['sort']) {
                case 'price_desc':
                    $query->orderBy('con_price, maxPrice DESC');
                    break;
                case 'price_asc':
                    $query->orderBy('con_price, minPrice ASC');
                    break;
                case 'm2_desc':
                    $query->orderBy('maxM2 DESC');
                    break;
                case 'm2_asc':
                    $query->orderBy('minM2 ASC');
                    break;
                default:
                    $query->orderBy('updated_at DESC');
                    break;
            }
        }
        return $query;
    }

    protected function orderByConditionsPlaces($query, $params)
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
        }
        return $query;
    }

    protected function getMapMarkers($array, $params){
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
                $coord = [$item->lng_str, $item->lat_str];
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

        //Полный запрос всех отфильтрованных places
        $filteredPlacesQuery = BcPlacesView::find(); //->asArray();
        $column = 'pid';
        $with ='place';
        if($params['result']=='bc'){
            $filteredPlacesQuery->with('bcitem.images', 'bcitem.class'); //class & images for markers
            $column = 'id';
            $with ='bcitem';
        }
        $filteredPlacesQuery = $this->filterConditions($filteredPlacesQuery, $params)->all();
        //Полный запрос всех отфильтрованных places

        $itemsForMarkers = getUniqueArray($column, $filteredPlacesQuery);
        $markers = $this->getMapMarkers($itemsForMarkers, $params);

        $allUniquePlaces = $params['result']=='bc' ? getUniqueArray('pid', $filteredPlacesQuery) : $itemsForMarkers;
        $count_ofices = count($allUniquePlaces); //count ofices

        $allPlacesQuery = BcPlacesView::find()
        ->select(['m2min', 'm2', 'uah_price'])
        ->groupBy(['pid'])
        ->where([
            'active' => 1,
            'approved' => 1,
            'hide' => 0,
            'phide' => 0,
            'city_id' => $params['city'],
            'country_id' => $params['country'],
        ])->all();
        //debug($allPlacesQuery); die();
        //$allPlacesQuery = $PlacesQuery->all();
        //$allPlacesQuery = getUniqueArray('pid', $allPlacesQuery);
        //echo $count_ofices.' - '.count($allPlacesQuery); die();
        $m2 = ArrayHelper::getColumn($allPlacesQuery, 'm2'); //m2 array
        $m2min = ArrayHelper::getColumn($allPlacesQuery, 'm2min'); //m2min array
        $m2ForChart = array_filter(ArrayHelper::merge($m2, $m2min)); //all m2 array for chart

        $pricesForChart=[];
        foreach($allPlacesQuery as $one) {
            if($one->uah_price>0){
                $pricesForChart['type1'][] = $one->uah_price;
                $pricesForChart['type3'][] = round($one->uah_price*$one->m2);
            }
        }

        //БЦ или Офисы для страницы отфильтрованные и отсортированные
        $attr = [$column,
            'MIN(con_price) as con_price',
            'MIN(uah_price) as minPrice',
            'MAX(uah_price) as maxPrice',
            /*'(CASE
              WHEN m2min>0 THEN MIN(m2min)
              ELSE MIN(m2)
              END) AS minM2',*/
            'MIN(m2) as minM2',
            'MAX(m2) as maxM2',
            'updated_at'];

        $query_items = BcPlacesView::find()
            ->select($attr)
            ->with($with)
                //->with('bcitem', 'bcitem.slug', 'bcitem.city', 'bcitem.district', 'bcitem.subways', 'bcitem.class')
            ->groupBy([$column]);

        $query_items = $this->filterConditions($query_items, $params);
        $query_items = $this->orderByConditions($query_items, $params);

        $pages = new Pagination(['totalCount' => $query_items->count(), 'pageSize' => 8]);
        $pages->pageSizeParam = false;
        $pages->forcePageParam = false;
        $items = $query_items->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
         //БЦ или офисы для страницы отфильтрованные и отсортированные
        //$allForPage = $items;

        if($params['result']=='bc') {
            //Запрос всех данных по найденным БЦ для страницы
            $ids = ArrayHelper::getColumn($items, 'id');
            $bcPlaces = BcPlacesView::find()
                ->where(['in', 'id', $ids])
                ->with('place', 'place.images');
            $bcPlaces = $this->filterConditions($bcPlaces, $params);
            $bcPlaces = $this->orderByConditionsPlaces($bcPlaces, $params);
            $bcPlaces = $bcPlaces->all();
            $bcPlaces = getUniqueArray('pid', $bcPlaces); //only unique pid
            //Массив БЦ и офисов, отфильтрованный, отсортированный, сгруппированный по БЦ - для стр. выдачи БЦ
            $allForPage = [];
            foreach ($items as $key => $item) {
                $allForPage[$key]['bc'] = $item;
                $places = [];
                foreach ($bcPlaces as $place) {
                    if ($place['id'] == $item['id']) {
                        $places = ArrayHelper::merge($places, [$place]);
                        $allForPage[$key]['places'] = $places;
                    }
                }
            }
        } else {
            $pids = ArrayHelper::getColumn($items, 'pid');
            $bcPlaces = BcPlacesView::find()
                ->where(['in', 'pid', $pids])
                ->with('place', 'place.images');
            $bcPlaces = $this->orderByConditionsPlaces($bcPlaces, $params);
            $bcPlaces = $bcPlaces->all();
            $bcPlaces = getUniqueArray('pid', $bcPlaces); //only unique pid
            $allForPage = $bcPlaces;
        }

        $result = [];
        $result['params'] = $params;
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

    public function seoSearch($params)
    {
        $target = !empty($params['target']) && $params['target'] === 2 ? 2 : 1;
        $result = !empty($params['result']) && $params['result'] === 'bc' ? 'bc' : 'offices';

        $query_bcitems = BcItems::find()->where(['active' => 1])->andWhere(['hide' => 0]);
        $query_offices = Offices::find()->where(['target' => $target]); //запрос для отбора отдельных офисов

        //фильтрация БЦ
        if (!empty($params['user'])) {
            $query_bcitems->andWhere(['in', 'id', $this->getItemsByUser($params['user'])]);
            $query_offices->andWhere(['in', 'id', $this->getItemsByUser($params['user'])]);
        }

        if (!empty($params['city'])) {
            $query_bcitems->andWhere(['city_id' => $params['city']]);
            $query_offices->andWhere(['city_id' => $params['city']]);
        }

        if (!empty($params['country'])) {
            $query_bcitems->andWhere(['country_id' => $params['country']]);
            $query_offices->andWhere(['country_id' => $params['country']]);
        }

        if (!empty($params['percent_commission'])) {
            $query_bcitems->andWhere(['percent_commission' => $params['percent_commission']]);
            $query_offices->andWhere(['percent_commission' => $params['percent_commission']]);
        }

        if (!empty($params['classes'])) {
            $query_bcitems->andWhere(['in', 'class_id', $params['classes']]);
            $query_offices->andWhere(['in', 'class_id', $params['classes']]);
        }

        if (!empty($params['districts'])) {
            $query_bcitems->andWhere(['in', 'district_id', $params['districts']]);
            $query_offices->andWhere(['in', 'district_id', $params['districts']]);
        }

        if (!empty($params['subway'])) {
            $dist = !empty($params['walk_dist']) ? $params['walk_dist'] : NULL;
            $query_bcitems->andWhere(['in', 'id', $this->getItemsBySubway($params['subway'], $dist)]);
        }

        if ($result === 'bc') $query_bcitems->with('class', 'images');

        $bcitems = $query_bcitems->all();//все БЦ по условиям фильтра (без учета наличия площадей в этих БЦ)
        $itemsIds = ArrayHelper::getColumn($bcitems, 'id'); //id БЦ по условиям фильтра (без учета наличия площадей в этих БЦ)
        $query_places = $target === 1 ? BcPlaces::find() : BcPlacesSell::find();
        $query_places->where(['archive' => 0])->andWhere(['hide' => 0]);
        if ($result === 'offices') {
            $offices = $query_offices->asArray()->all();//все отдельные офисы по условиям фильтра
            $officesIds = ArrayHelper::getColumn($offices, 'id'); //id офисов по условиям фильтра
            $itemsIds = ArrayHelper::merge($officesIds, $itemsIds);
        }
        $query_places->andWhere(['in', 'item_id', $itemsIds]); //фильтрация площадей по отфильтрованным БЦ и офисам

        $chartPlacesQuery = clone $query_places;
        $chartPlaces = $chartPlacesQuery->asArray()->all(); //все площади без фильтрации по кв.м. и цене (можно передавать в графики)
//debug(ArrayHelper::getColumn($chartPlaces,'id'));

        //фильтрация places по кв.м.
        if (!empty($params['m2min']) && !empty($params['m2max'])) {
            $query_places->andWhere([
                'and',
                ['or', ['<=', 'm2min', $params['m2max']], ['is', 'm2min', NULL]],
                ['and', ['>=', 'm2', $params['m2min']], ['<=', 'm2', $params['m2max']]]
            ]);

        } elseif (!empty($params['m2min'])) {
            $query_places->andWhere([
                'and',
                ['>=', 'm2', $params['m2min']]
            ]);
        } elseif (!empty($params['m2max'])) {
            $query_places->andWhere([
                'or',
                ['<=', 'm2min', $params['m2max']],
                ['and', ['is', 'm2min', NULL], ['<=', 'm2', $params['m2max']]]
            ]);
        }

        //фильтрация places по цене
        if (!empty($params['pricemin']) || !empty($params['pricemax'])) {
            $currency = !empty($params['currency']) ? $params['currency'] : 1;
            $type = !empty($params['type']) ? $params['type'] : 1;
            if ($params['target'] === 1) {
                $price_query = BcPlacesPrice::find();
            } else {
                $price_query = BcPlacesSellPrice::find();
            }
            $price_query->andWhere(['period_id' => $type]);
            $price_query->andWhere(['valute_id' => $currency]);
            $price_query->andFilterWhere(['>=', 'price', $params['pricemin']]);
            $price_query->andFilterWhere(['<=', 'price', $params['pricemax']]);
            $prices = $price_query->asArray()->all();
            $pricesIds = ArrayHelper::getColumn($prices, 'place_id');
            $query_places->andWhere([
                'or',
                ['con_price' => 1],
                ['in', 'id', $pricesIds]
            ]);
        }

        $query_bc_places = clone $query_places;
        $query_bc_places->andWhere(['no_bc' => NULL]);

        if ($result === 'offices') {
            $query_bc_places->with('bcitem.class', 'images', 'bcitem.images');
        }

        $bcPlaces = $query_bc_places->all(); //все places по всем фильтрам (стр. выдачи БЦ)
        $places = $bcPlaces;
        $itemsIds = array_unique(ArrayHelper::getColumn($bcPlaces, 'item_id')); //id БЦ с площадями по условиям фильтра

        //оставляем только те БЦ, у которых есть площади
        foreach ($bcitems as $key => $item) {
            if (!ArrayHelper::isIn($item['id'], $itemsIds)) unset($bcitems[$key]);
        }
        $markersItems = $bcitems; //массив БЦ для создания маркеров для карты

        if ($result === 'offices') {
            $query_offices_places = clone $query_places;
            $query_offices_places
                ->andWhere(['no_bc' => 1])
                ->with('office.class', 'images', 'bcitem.images');
            $offPlaces = $query_offices_places->all();
            $places = ArrayHelper::merge($offPlaces, $bcPlaces); //массив офисов для создания маркеров для карты
            $markersItems = $places;
        }
        //debug($markersItems);

        //формирование маркеров для карты
        $currentLanguage = $params['lang'];
        $markers = [];
        $markers['type'] = 'FeatureCollection';
        $markers['result'] = $result;
        $markers['lang'] = $currentLanguage;
        $markers['features'] = [];
        //debug(ArrayHelper::getColumn($items, 'id'));
        //debug($params['result']); die();
        foreach ($markersItems as $item) {
            $id = $item->id;
            //$coord = [$item->lng, $item->lat]; //координат пока нет в БД (надо решить что делать с точным адресом)
            //$addres = $item->address;
            if ($result === 'bc') {
                $addres = $item->address;
                $coord = [$item->lng, $item->lat];
                $img = isset($item->images[0]) ? $item->images[0]->imgSrc : '';
                $class = $item->class->short_name;
                $name = getDefaultTranslate('name', $currentLanguage, $item, true);
            } else {
                $name = getDefaultTranslate('name', $currentLanguage, $item, true);
                if (isset($item->images[0])) {
                    $img = $item->images[0]->imgSrc;
                } elseif (isset($item->bcitem->images[0])) {
                    $img = $item->bcitem->images[0]->imgSrc;
                } else {
                    $img = '';
                }
                if ($item->no_bc === 1) {
                    $addres = $item->bcitem->street;
                    $coord = [$item->bcitem->lng_str, $item->bcitem->lat_str];
                    $class = $item->bcitem->class->short_name;
                } else {
                    $addres = $item->bcitem->street;
                    $coord = [$item->bcitem->lng_str, $item->bcitem->lat_str];
                    $class = $item->bcitem->class->short_name;
                }
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
        //end формирование маркеров для карты

        if ($result === 'offices' && !empty($params['visibles'])) {
            //оставляем только те площади, id которых есть в $params['visibles'] (для правильного подсчета к-ва найденных офисов)
            foreach ($places as $key => $item) {
                if (!ArrayHelper::isIn($item['id'], $params['visibles'])) unset($places[$key]);
            }
        }


        //сортировка для страницы выдачи офисов
        if ($result === 'offices') {
            //запрос для страницы выдачи офисов
            $query_places->with('priceSqm')
                ->join('LEFT JOIN', 'bc_places_price pr', 'id = pr.place_id AND pr.valute_id=1 AND pr.period_id = 1');
            switch ($params['sort']) {
                case 'price_desc':
                    $query_places->orderBy('con_price ASC, pr.price  DESC');
                    break;
                case 'price_asc':
                    $query_places->orderBy('con_price ASC, pr.price  ASC');
                    break;
                case 'm2_desc':
                    //todo: вычислять по какому полю сортировать (m2||m2min)
                    $query_places->orderBy('m2 DESC');
                    break;
                case 'm2_asc':
                    $query_places->orderBy('m2 ASC');
                    break;
                default:
                    $query_places->orderBy('updated_at DESC');
                    break;
            }
        }

        if ($result === 'bc') {
            $placesIds = ArrayHelper::getColumn($bcPlaces, 'id'); //id площадей по условиям target, m2
            //query for sort by m2, price, updated & for pagination
            $itemsQuery = (new \yii\db\Query())
                ->select([
                    'item_id', 'i.updated_at', 'MIN(m2) as minm2', 'MIN(p.m2min) as minm2min', 'MAX(m2) as maxm2',
                    new \yii\db\Expression('IF(MIN(pr.price)>0, MIN(pr.price), "z") AS minprice'), 'MAX(pr.price) as maxprice'
                ]);
            $itemsQuery->from('bc_items i');
            if ($params['target'] === 1) {
                $itemsQuery->join('INNER JOIN', 'bc_places p', 'i.id = p.item_id');
                $itemsQuery->join('LEFT JOIN', 'bc_places_price pr', 'p.id = pr.place_id AND pr.valute_id=1 AND pr.period_id = 1');
            } else {
                $itemsQuery->join('INNER JOIN', 'bc_places_sell p', 'i.id = p.item_id');
                $itemsQuery->join('LEFT JOIN', 'bc_places_sell_price pr', 'p.id = pr.place_id AND pr.valute_id=1 AND pr.period_id = 1');
            }

            if (empty($params['visibles'])) {
                $itemsQuery->where(['in', 'i.id', $itemsIds]);
            } else {
                $itemsQuery->where(['in', 'i.id', $params['visibles']]);
            }

            $itemsQuery->andWhere(['in', 'p.id', $placesIds]);
            $itemsQuery->groupBy('item_id');

            //сортировка для страницы выдачи БЦ
            switch ($params['sort']) {
                case 'price_desc':
                    $itemsQuery->orderBy('maxprice DESC');
                    break;
                case 'price_asc':
                    $itemsQuery->orderBy('minprice ASC');
                    break;
                case 'm2_desc':
                    $itemsQuery->orderBy('maxm2 DESC');
                    break;
                case 'm2_asc':
                    $itemsQuery->orderBy('minm2 ASC');
                    break;
                default:
                    $itemsQuery->orderBy('i.updated_at DESC');
                    break;
            }

            $pages = new Pagination(['totalCount' => $itemsQuery->count(), 'pageSize' => 8]);
            $pages->pageSizeParam = false;
            $pages->forcePageParam = false;
            $bcItems = $itemsQuery->offset($pages->offset)
                ->limit($pages->limit)
                ->all(); //Массив БЦ ([item_id][updated_at][minm2][minm2min][maxm2][minprice][maxprice])

            $bcItemsIds = ArrayHelper::getColumn($bcItems, 'item_id');

            if ($params['target'] === 1) {
                $itemsModel = BcItems::find()
                    ->where(['in', 'id', $bcItemsIds])
                    ->with('slug', 'images', 'class', 'subways.subwayDetails.branch.image', 'city', 'district', 'places.images', 'places.stageImg', 'places.prices')
                    ->all();
            } else {
                $itemsModel = BcItems::find()
                    ->where(['in', 'id', $bcItemsIds])
                    ->with('slug', 'images', 'class', 'subways.subwayDetails.branch.image', 'city', 'district', 'placesSell.images', 'placesSell.stageImg', 'placesSell.prices')
                    ->all();
            }

            foreach ($itemsModel as $model) {
                foreach ($bcItems as $one) {
                    if ($one['item_id'] == $model->id) {
                        $model->minm2 = (!empty($one['minm2min']) && $one['minm2min'] < $one['minm2']) ? $one['minm2min'] : $one['minm2'];
                        $model->maxm2 = $one['maxm2'];
                        $model->minprice = $one['minprice'];
                        $model->maxprice = $one['maxprice'];
                    }
                }
            }

            switch ($params['sort']) {
                case 'price_desc':
                    ArrayHelper::multisort($itemsModel, ['maxprice'], [SORT_DESC]);
                    break;
                case 'price_asc':
                    ArrayHelper::multisort($itemsModel, ['minprice'], [SORT_ASC]);
                    break;
                case 'm2_desc':
                    ArrayHelper::multisort($itemsModel, ['maxm2'], [SORT_DESC]);
                    break;
                case 'm2_asc':
                    ArrayHelper::multisort($itemsModel, ['minm2'], [SORT_ASC]);
                    break;
                default:
                    ArrayHelper::multisort($itemsModel, ['updated_at'], [SORT_DESC]);
                    break;
            }
        } else {
            if (!empty($params['visibles'])) {
                $query_places->andWhere(['in', 'id', $params['visibles']]);
            }
            $query_places->with('bcitem', 'office', 'bcitem.class', 'office.class', 'bcitem.city', 'office.city', 'bcitem.district', 'office.district', 'bcitem.subways', 'office.subways', 'bcitem.images');
            $pages = new Pagination(['totalCount' => $query_places->count(), 'pageSize' => 8]);
            $pages->pageSizeParam = false;
            $pages->forcePageParam = false;
            $itemsModel = $query_places->offset($pages->offset)
                ->limit($pages->limit)
                ->all();
        }


        $result = [];
        $result['bcItems'] = $itemsModel;
        $result['places'] = $places;
        $result['places_for_charts'] = $chartPlaces;
        $result['markers'] = json_encode($markers);
        $result['pages'] = $pages;
        return $result;
    }


    protected function getItemsByUser($id)
    {
        $userItems = BcItemsOwners::find()->where(['user_id' => $id])->asArray()->all();
        $userItemsIds = ArrayHelper::getColumn($userItems, 'item_id');
        $brokerItems = BcItemsBrokers::find()->where(['user_id' => $id])->asArray()->all();
        $brokerItemsIds = ArrayHelper::getColumn($brokerItems, 'item_id');
        $ids = ArrayHelper::merge($userItemsIds, $brokerItemsIds);
        return $ids;
    }

    protected function getItemsBySubway($id, $dist = NULL)
    {
        $query = BcItemsSubways::find()->where(['subway_id' => $id])->andWhere(['model' => 'bc_items']);
        if ($dist !== NULL) $query->andWhere(['<=', 'walk_distance', $dist]);
        $items = $query->orderBy('item_id')->asArray()->all();
        $ids = ArrayHelper::getColumn($items, 'item_id');
        return $ids;
    }

    protected function getOfficesBySubway($id, $dist = NULL)
    {
        $query = BcItemsSubways::find()->where(['subway_id' => $id])->andWhere(['model' => 'offices']);
        if ($dist !== NULL) $query->andWhere(['<=', 'walk_distance', $dist]);
        $items = $query->orderBy('item_id')->asArray()->all();
        $ids = ArrayHelper::getColumn($items, 'item_id');
        return $ids;
    }


}


/* privider
 * $query = BcItems::find()->multilingual();
$provider = new ActiveDataProvider([
    'query' => $query,
]);
$provider->setSort([
    'attributes' => [
        'm2' => [
            'asc' => ['bc_places.m2' => SORT_ASC],
            'desc' => ['bc_places.m2' => SORT_DESC],
            'label' => 'm2'
        ]
    ],
    'defaultOrder' => [
        'm2' => SORT_ASC,
    ]
]);

//$query->where(['>','bc_places_price.price', 0]);
//$query->joinWith(['places.priceSqm']);
//$query->joinWith(['places']);
$query->with('places');


$provider->setPagination([
    'pageSize' => 20
]);
$result =  $provider->getModels();*/

