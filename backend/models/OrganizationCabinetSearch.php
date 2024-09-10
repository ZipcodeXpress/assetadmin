<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\OrganizationCabinet;

/**
 * OrganizationCabinetSearch represents the model behind the search form about `backend\models\OrganizationCabinet`.
 */
class OrganizationCabinetSearch extends OrganizationCabinet
{
    public $organization_name;
    public $address;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['organization_id', 'cabinet_id', 'create_time'], 'integer'],
            [['organization_name', 'address',], 'safe'],
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
        $query = OrganizationCabinet::find()->joinWith('organization')->joinWith('cabinet');

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
            OrganizationCabinet::tableName().'.organization_id' => $this->organization_id,
            OrganizationCabinet::tableName().'.cabinet_id' => $this->cabinet_id,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'organization_name', $this->organization_name])
        ->andFilterWhere(['like', 'cabinet.address', $this->address]);
        
        return $dataProvider;
    }
}
