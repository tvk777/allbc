<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\BcPlaces;

/**
 * BcPlacesSearch represents the model behind the search form of `common\models\BcPlaces`.
 */
class BcPlacesSearch extends BcPlaces
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'item_id', 'm2', 'm2min', 'valute_id', 'price_period', 'ai', 'commission', 'plan_comment', 'hide', 'archive', 'price', 'con_price', 'status_id', 'rent', 'hits', 'hide_contacts'], 'integer'],
            [['created_at', 'updated_at', 'stage_name', 'phone', 'email'], 'safe'],
            [['opex', 'tax', 'kop'], 'number'],
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
    public function search($params, $item_id, $arh)
    {
        $query = BcPlaces::find()->where(['item_id' => $item_id])->andWhere(['archive' => $arh]);

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
            'item_id' => $this->item_id,
            'm2' => $this->m2,
            'm2min' => $this->m2min,
            'valute_id' => $this->valute_id,
            'price_period' => $this->price_period,
            'ai' => $this->ai,
            'commission' => $this->commission,
            'opex' => $this->opex,
            'plan_comment' => $this->plan_comment,
            'hide' => $this->hide,
            'archive' => $this->archive,
            'price' => $this->price,
            'con_price' => $this->con_price,
            'tax' => $this->tax,
            'kop' => $this->kop,
            'status_id' => $this->status_id,
            'rent' => $this->rent,
            'hits' => $this->hits,
            'hide_contacts' => $this->hide_contacts,
        ]);

        $query->andFilterWhere(['like', 'stage_name', $this->stage_name])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}
