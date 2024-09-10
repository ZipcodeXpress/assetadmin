<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\CourierCompanyOrganization;

/**
 * CourierCompanyOrganizationSearch represents the model behind the search form of `backend\models\CourierCompanyOrganization`.
 */
class CourierCompanyOrganizationSearch extends CourierCompanyOrganization
{
    public $company_name;
    public $organization_name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['courier_id', 'company_id', 'organization_id', 'create_time'], 'integer'],
            [['access_code','company_name','organization_name'], 'safe'],
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
    public function search($params,$organizationIds=null)
    {
        $query = CourierCompanyOrganization::find();
        $query->joinWith('company');
        $query->joinWith('organization');
        
        if($organizationIds) {
            $query->andFilterWhere(['in', 'o_courier_company_organization.organization_id', explode(',', $organizationIds)]);
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
            'courier_id' => $this->courier_id,
            'company_id' => $this->company_id,
            'organization_id' => $this->organization_id,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'access_code', $this->access_code])
        ->andFilterWhere(['like', 'company_name', $this->company_name])
        ->andFilterWhere(['like', 'organization_name', $this->organization_name]);

        return $dataProvider;
    }
}
