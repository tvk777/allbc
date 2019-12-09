<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\BcItems;
use common\models\BcPlaces;
use common\models\BcPlacesSell;
use yii\helpers\ArrayHelper;

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

    public function seoSearch($params)
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
    }

}
