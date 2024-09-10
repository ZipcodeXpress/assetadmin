<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Cabinet;

/**
 * CabinetSearch represents the model behind the search form about `backend\models\Cabinet`.
 */
class CabinetSearch extends Cabinet
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cabinet_id', 'create_time'], 'integer'],
            [['state', 'city', 'address', 'zipcode', 'api_key', 'api_secret', 'service_type'], 'safe'],
            [['latitude', 'longitude'], 'number'],
            [['address_url'],'safe']
        ];
    }

    /**
     * @inheritdoc
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
    public function search($params,$organizationIds = NULL)
    {
        $query = Cabinet::find();
        $query->leftJoin("o_organization_cabinet","o_organization_cabinet.cabinet_id = cabinet.cabinet_id");
        

        // add conditions that should always apply here

        if($organizationIds) {
            $query->andFilterWhere(['in', 'o_organization_cabinet.organization_id', explode(',', $organizationIds)]);
        }
        
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
            'cabinet.cabinet_id' => $this->cabinet_id,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'zipcode', $this->zipcode])
            ->andFilterWhere(['like', 'api_key', $this->api_key])
            ->andFilterWhere(['like', 'api_secret', $this->api_secret])
            ->andFilterWhere(['like', 'service_type', $this->service_type]);

        return $dataProvider;
    }
}
