<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Courier;

/**
 * CourierSearch represents the model behind the search form about `backend\models\Courier`.
 */
class CourierSearch extends Courier
{
    public  $company_name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['courier_id', 'company_id', 'status', 'create_time'], 'integer'],
            [['courier_name', 'card_code', 'email', 'phone'], 'safe'],
            [['company_name'], 'safe'],
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
        $query = Courier::find()->joinWith("company");
        $query->leftJoin('o_courier_organization', 'o_courier_organization.courier_id = o_courier.courier_id');

        // add conditions that should always apply here

        if($organizationIds) {
            $query->andFilterWhere(['in', 'o_courier_organization.organization_id', explode(',', $organizationIds)]);
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
            'courier_id' => $this->courier_id,
            'company_id' => $this->company_id,
            'status' => $this->status,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'courier_name', $this->courier_name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'card_code', $this->card_code]);
        $query->andFilterWhere(['like', 'company_name', $this->company_name]) ;

        return $dataProvider;
    }
}
