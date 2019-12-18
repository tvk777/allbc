<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Offices;

/**
 * OfficesSearch represents the model behind the search form of `common\models\Offices`.
 */
class OfficesSearch extends Offices
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'place_id', 'target', 'city_id', 'country_id', 'district_id', 'class_id', 'percent_commission'], 'integer'],
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
        $query = Offices::find();

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
            'place_id' => $this->place_id,
            'target' => $this->target,
            'city_id' => $this->city_id,
            'country_id' => $this->country_id,
            'district_id' => $this->district_id,
            'class_id' => $this->class_id,
            'percent_commission' => $this->percent_commission,
        ]);

        return $dataProvider;
    }
}
