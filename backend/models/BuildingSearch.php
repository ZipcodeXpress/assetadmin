<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Building;

/**
 * BuildingSearch represents the model behind the search form about `backend\models\Building`.
 */
class BuildingSearch extends Building
{
    public $organization_name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['building_id', 'organization_id', 'create_time'], 'integer'],
            [['building_name'], 'safe'],
            [['organization_name'], 'safe'],
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
    public function search($params)
    {
        $query = Building::find()->joinWith("organization");

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
            'building_id' => $this->building_id,
            'organization_id' => $this->organization_id,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'building_name', $this->building_name]);
        $query->andFilterWhere(['like', 'organization_name', $this->organization_name]) ;

        return $dataProvider;
    }
}
