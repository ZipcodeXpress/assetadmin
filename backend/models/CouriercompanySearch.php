<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Couriercompany;

/**
 * CouriercompanySearch represents the model behind the search form about `backend\models\Couriercompany`.
 */
class CouriercompanySearch extends Couriercompany
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'contract_begin', 'contract_end', 'create_time'], 'integer'],
            [['company_name', 'logo', 'address', 'contact_name', 'contact_phone'], 'safe'],
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
        $query = Couriercompany::find();

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
            'company_id' => $this->company_id,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'company_name', $this->company_name])
            ->andFilterWhere(['like', 'logo', $this->logo])
            ->andFilterWhere(['like', 'FROM_UNIXTIME(contract_begin)', $this->contract_begin])
            ->andFilterWhere(['like', 'FROM_UNIXTIME(contract_end)', $this->contract_end])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'contact_name', $this->contact_name])
            ->andFilterWhere(['like', 'contact_phone', $this->contact_phone]);

        return $dataProvider;
    }
}
