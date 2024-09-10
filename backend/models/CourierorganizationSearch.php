<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Couriercompany;

/**
 * CouriercompanySearch represents the model behind the search form about `backend\models\Couriercompany`.
 */
class CourierorganizationSearch extends Courierorganization
{
    public  $courier_name;
    public  $company_name;
    public  $email;
    public  $phone;
    public  $card_code;
    public  $status;
    public  $organization_name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['courier_id', 'organization_id'], 'integer'],
            [['courier_name', 'card_code', 'email', 'phone'], 'safe'],
            [['company_name','status','organization_name'], 'safe'],
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
        $sql="select o_courier_organization.* from o_courier_organization inner join o_courier_company_organization on o_courier_organization.courier_id = o_courier_company_organization.courier_id
              left join o_organization on o_courier_organization.organization_id = o_organization.organization_id
              left join o_courier_company on o_courier_company_organization.company_id = o_courier_company.company_id ";//,o_courier_company_organization.access_code as card_code
        if($organizationIds)
        {
            $sql = $sql." where o_courier_company_organization.organization_id in (".$organizationIds.")";
        }
        $query = Courierorganization::find()->innerJoinWith('courier')->joinWith('organization'); 
        
        $query->leftJoin('o_courier_company', 'o_courier_company.company_id = o_courier.company_id');
        
        $query->union($sql);

        if($organizationIds) {
            $query->andFilterWhere(['in', 'o_courier_organization.organization_id', explode(',', $organizationIds)]);
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
            //'company_id' => $this->company_id,
            'status' => $this->status,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'courier_name', $this->courier_name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'card_code', $this->card_code])
            ->andFilterWhere(['like', 'organization_name', $this->organization_name])
            ->andFilterWhere(['like', 'organization.company_name', $this->company_name]) ;
        
        return $dataProvider;
    }
}
