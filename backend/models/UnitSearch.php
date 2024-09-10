<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Unit;

/**
 * UnitSearch represents the model behind the search form about `backend\models\Unit`.
 */
class UnitSearch extends Unit
{
    public $organization_name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['unit_id', 'organization_id',], 'integer'],
            [['unit_name','organization_name'], 'safe'],
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
    public function search($params, $organizationIds=null)
    {
        $query = Unit::find()->joinWith('organization');
        
        if($organizationIds) {
            $query->andFilterWhere(['in', 'o_organization.organization_id', explode(',', $organizationIds)]);
        }

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
            'unit_id' => $this->unit_id,
            'organization_id' => $this->organization_id,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'unit_name', $this->unit_name])
        ->andFilterWhere(['like', 'organization_name', $this->organization_name]);

        return $dataProvider;
    }
}
