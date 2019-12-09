<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\GeoCities;

/**
 * GeoCitiesSearch represents the model behind the search form of `common\models\GeoCities`.
 */
class GeoCitiesSearch extends GeoCities
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'active', 'country_id', 'sort_order', 'bc_count', 'contacts_open', 'offices_open', 'zoom'], 'integer'],
            [['name', 'created_at', 'updated_at', 'place_id', 'slug', 'phone', 'openstreetmapid', 'inflect', 'slug_sell'], 'safe'],
            [['lat', 'lng'], 'number'],
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
        $query = GeoCities::find()->with('country');

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
        /*$query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'active' => $this->active,
            'country_id' => $this->country_id,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'sort_order' => $this->sort_order,
            'bc_count' => $this->bc_count,
            'contacts_open' => $this->contacts_open,
            'offices_open' => $this->offices_open,
            'zoom' => $this->zoom,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'place_id', $this->place_id])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'openstreetmapid', $this->openstreetmapid])
            ->andFilterWhere(['like', 'inflect', $this->inflect])
            ->andFilterWhere(['like', 'slug_sell', $this->slug_sell]);*/

        return $dataProvider;
    }
}
