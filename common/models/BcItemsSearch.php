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
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'sort_order', 'class_id', 'percent_commission', 'active', 'hide', 'hide_contacts', 'approved'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at', 'street', 'slug', 'contacts_admin', 'redirect', 'email', 'email_name'], 'safe'],
            [['lat', 'lng'], 'number'],
            [['city_id', 'country_id', 'district_id'], 'safe'],
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
        $query = BcItems::find()->localized('ru');
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        //debug($params); die();
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
        ]);

        $query->andFilterWhere(['like', 'street', $this->street])
            ->andFilterWhere(['like', 'contacts_admin', $this->contacts_admin])
            ->andFilterWhere(['like', 'redirect', $this->redirect])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'email_name', $this->email_name]);

        return $dataProvider;
    }

    /*public function seoSearch($params)
    {
        //debug($params); die();
        $result = [];
        $query = BcItems::find();
        if ($params['target'] === 1) {
            $query->with('places', 'images', 'class', 'subways.subwayDetails.branch.image', 'city', 'district', 'places.images', 'places.stageImg', 'places.prices');
            $places = BcPlaces::find()->where(['archive' => 0])->andWhere(['hide' => 0]);
        } else {
            $query->with('placesSell', 'images', 'class', 'subways.subwayDetails.branch.image', 'city', 'district', 'placesSell.images', 'placesSell.stageImg', 'placesSell.prices');
            $places = BcPlacesSell::find()->where(['archive' => 0])->andWhere(['hide' => 0]);
        }

        if (!empty($params['subway'])) {
            $query->joinWith(['subways']);
        }
        if (!empty($params['user'])) {
            $query->joinWith(['user']);
        }

        $placesForCharts = $places->asArray()->all(); //all places without filter by m2 and price
        $placesForChartsIds = ArrayHelper::getColumn($placesForCharts, 'item_id');

        if (isset($params['m2'])) {
            if (count($params['m2']) == 2) {
                $places->andWhere(['and',
                    ['>=', 'm2', $params['m2'][0]],
                    ['<=', 'm2', $params['m2'][1]],
                ]);
                $places->orWhere(['and',
                    ['>=', 'm2min', $params['m2'][0]],
                    ['<=', 'm2min', $params['m2'][1]],
                ]);

            } else {
                $places->andFilterWhere(['or',
                    ['=', 'm2', $params['m2']],
                    ['=', 'm2min', $params['m2']],
                ]);
            }
        }

        $places = $places->asArray()->all();
        $placesIds = array_unique(ArrayHelper::getColumn($places, 'item_id'));
        //$placesIds = ArrayHelper::getColumn($places, 'id');
        //debug(count($placesIds)); die();

        $query->where(['active' => 1]);
        $query->andWhere(['approved' => 1]);


        if (!isset($params['visibles'])) {
           $query->andFilterWhere([
                'city_id' => $params['city'],
                'country_id' => $params['country'],
                'percent_commission' => $params['percent_commission'],
            ]);
            if (!empty($params['user'])) {
                $query->andFilterWhere(['=', 'bc_items_users.user_id', $params['user']]);
            }
            if (!empty($params['subway'])) {
                $query->andFilterWhere(['=', 'bc_items_subways.subway_id', $params['subway']]);
                $query->andFilterWhere(['<=', 'bc_items_subways.walk_distance', $params['walk_dist']]);
            }

            $query->andFilterWhere(['in', 'class_id', $params['classes']]);
            $query->andFilterWhere(['in', 'district_id', $params['districts']]);
            $query->andFilterWhere(['in', 'id', $placesIds]);
            $chartQuery = clone $query;
            $chartQuery->andFilterWhere(['in', 'id', $placesForChartsIds]);
        } else {
            $query->andFilterWhere(['in', 'id', $params['visibles']]);
            $chartQuery = clone $query;
            $query->andFilterWhere(['in', 'id', $placesIds]);
            //$chartQuery->andFilterWhere(['in', 'id', $placesForChartsIds]);
        }

        $query
            ->multilingual()
            ->orderBy('updated_at DESC')
            ->distinct();

        //формирование маркеров для карты
        $allItems = $query->all();
        $markers = [];
        $markers['type'] = 'FeatureCollection';
        $markers['features'] = [];
        foreach ($allItems as $item) {
            $feature = [
                'type' => 'Feature',
                'geometry' => [
                    'type' => 'Point',
                    'coordinates' => [$item->lng, $item->lat]
                ],
                'properties' => [
                    'id' => $item->id,
                    'title' => $item->street,
                ]
            ];
            $markers['features'][] = $feature;
        }

        //фильтрация площадей по выбранным items.
        $itemsIds = ArrayHelper::getColumn($allItems, 'id');
        foreach ($places as $key => $place) {
            if (!ArrayHelper::isIn($place['item_id'], $itemsIds)) unset($places[$key]);
        }

        //фильтрация площадей для графика в фильтре по выбранным items
        $allItemsForChart = $chartQuery->multilingual()->all();
        $itemsIdsForChart = ArrayHelper::getColumn($allItemsForChart, 'id');
        foreach ($placesForCharts as $key => $place) {
            if (!ArrayHelper::isIn($place['item_id'], $itemsIdsForChart)) unset($placesForCharts[$key]);
        }

        $result['query'] = $query;
        $result['places'] = $places;
        $result['places_for_charts'] = $placesForCharts;
        $result['markers'] = json_encode($markers);
        return $result;
    }*/

    public function seoSearch($params)
    {
        //debug($params);
        //$params['visibles'] = [31698, 31760, 32181, 30008];
        //debug($params);
        if (empty($params['sort'])) $params['sort'] = 'updated_at';

        if ($params['target'] === 1) {
            $query_places = BcPlaces::find()->where(['archive' => 0])->andWhere(['hide' => 0]);
            $query = BcItems::find()->multilingual()->with('places', 'images', 'class')->where(['active' => 1])->andWhere(['hide' => 0]);
        } else {
            $query_places = BcPlacesSell::find()->where(['archive' => 0])->andWhere(['hide' => 0]);
            $query = BcItems::find()->with('placesSell', 'images')->where(['active' => 1])->andWhere(['hide' => 0]);
        }

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

        if (!empty($params['pricemin']) || !empty($params['pricemax'])) {
            $currency = !empty($params['currency']) ? $params['currency'] : 1;
            $type = !empty($params['type']) ? $params['type'] : 1;
            if($params['target'] === 1){
                $price_query = BcPlacesPrice::find();
            } else{
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


        $places = $query_places->asArray()->all(); //выбранные площади по условиям target, m2, price
        $placesItemsIds = array_unique(ArrayHelper::getColumn($places, 'item_id')); //уникальные item_id по условиям target, m2, price
//debug($placesItemsIds);



        //фильтрация БЦ
        if (!empty($params['user'])) {
            $query->andFilterWhere(['in', 'id', $this->getItemsByUser($params['user'])]);
        }

        if (!empty($params['city'])) {
            $query->andFilterWhere(['city_id' => $params['city'],]);
        }

        if (!empty($params['country'])) {
            $query->andFilterWhere(['country_id' => $params['country'],]);
        }

        if (!empty($params['percent_commission'])) {
            $query->andFilterWhere(['percent_commission' => $params['percent_commission'],]);
        }

        if (!empty($params['classes'])) {
            $query->andFilterWhere(['in', 'class_id', $params['classes']]);
        }

        if (!empty($params['districts'])) {
            $query->andFilterWhere(['in', 'district_id', $params['districts']]);
        }

        if (!empty($params['subway'])) {
            $dist = !empty($params['walk_dist']) ? $params['walk_dist'] : NULL;
            $query->andFilterWhere(['in', 'id', $this->getItemsBySubway($params['subway'], $dist)]);
        }

        if (!empty($params['visibles'])) {
            $visiblesQuery = clone $query;
            $visiblesQuery->where(['in', 'id', $params['visibles']]);
            $visiblesItems = $visiblesQuery->asArray()->all();
        }

        //отбор площадей для графиков без учета фильтра по цене и кв.м.
        $chartsQuery = clone $query;
        $chartItems = $chartsQuery->asArray()->all();
        $chartItemsIds = ArrayHelper::getColumn($chartItems, 'id');
        if ($params['target'] === 1) {
            $placesForCharts = BcPlaces::find()->where(['archive' => 0])->andWhere(['hide' => 0])->andWhere(['in', 'item_id', $chartItemsIds])->asArray()->all();
        } else {
            $placesForCharts = BcPlacesSell::find()->where(['archive' => 0])->andWhere(['hide' => 0])->andWhere(['in', 'item_id', $chartItemsIds])->asArray()->all();
        }


        $query->andWhere(['in', 'id', $placesItemsIds]); //БЦ соответствующие выбранным площадям с учетом фильтра по кв.м.
        //конец фильтрации БЦ

        $items = $query->all();

        //формирование маркеров для карты
        $markers = [];
        $markers['type'] = 'FeatureCollection';
        $markers['features'] = [];
        $currentLanguage = $params['lang'];
        foreach ($items as $item) {
            $name = getDefaultTranslate('name', $currentLanguage, $item);
            $img = isset($item->images[0]) ? $item->images[0]->imgSrc : '';
            $class = $item->class->short_name;
            $feature = [
                'type' => 'Feature',
                'geometry' => [
                    'type' => 'Point',
                    'coordinates' => [$item->lng, $item->lat]
                ],
                'properties' => [
                    'id' => $item->id,
                    'title' => $name,
                    'address' => $item->street,
                    'img' => $img,
                    'class' => $class
                ]
            ];
            $markers['features'][] = $feature;
        }

        if (!empty($params['visibles'])) $items = $visiblesItems;

        $itemsIds = ArrayHelper::getColumn($items, 'id'); //id БЦ по условиям user и другим фильтрам (локация БЦ)
        //Отбор places по всем БЦ, которые подходят под параметры фильтрации (для рассчета кол-ва найденных офисов)
        foreach ($places as $key => $place) {
            if (!ArrayHelper::isIn($place['item_id'], $itemsIds)) unset($places[$key]);
        }

        $placesIds = ArrayHelper::getColumn($places, 'id'); //id площадей по условиям target, m2
        //debug($placesIds);

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

        //сортировка
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
                ->with('slug', 'images', 'class', 'subways.subwayDetails.branch.image', 'city', 'district', 'places', 'places.images', 'places.stageImg', 'places.prices')
                ->multilingual()
                ->all();
        } else {
            $itemsModel = BcItems::find()
                ->where(['in', 'id', $bcItemsIds])
                ->with('slug', 'images', 'class', 'subways.subwayDetails.branch.image', 'city', 'district', 'placesSell', 'placesSell.images', 'placesSell.stageImg', 'placesSell.prices')
                ->multilingual()
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

//debug(json_encode($markers));
        $result['bcItems'] = $itemsModel;
        $result['places'] = $places;
        $result['places_for_charts'] = $placesForCharts;
        $result['markers'] = json_encode($markers);
        $result['pages'] = $pages;
        return $result;
    }

    protected function getItemsByUser($id)
    {
        $userItems = BcItemsUsers::find()->where(['user_id' => $id])->asArray()->all();
        $userItemsIds = ArrayHelper::getColumn($userItems, 'item_id');
        $brokerItems = BcItemsBrokers::find()->where(['user_id' => $id])->asArray()->all();
        $brokerItemsIds = ArrayHelper::getColumn($brokerItems, 'item_id');
        $ids = ArrayHelper::merge($userItemsIds, $brokerItemsIds);
        return $ids;
    }

    protected function getItemsBySubway($id, $dist = NULL)
    {
        $query = BcItemsSubways::find()->where(['subway_id' => $id]);
        if ($dist !== NULL) $query->andWhere(['<=', 'walk_distance', $dist]);
        $items = $query->orderBy('item_id')->asArray()->all();
        $ids = ArrayHelper::getColumn($items, 'item_id');
        return $ids;
    }

}
