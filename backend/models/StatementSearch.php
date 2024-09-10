<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Statement;

/**
 * StatementSearch represents the model behind the search form about `backend\models\Statement`.
 */
class StatementSearch extends Statement
{
    public $email;
    public $phone;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['statement_id', 'member_id', 'order_id', 'order_payment_id', 'create_time'], 'integer'],
            [['statement_type', 'statement_desc', 'channel', 'extra'], 'safe'],
            [['amount', 'money', 'frozen_money', 'ubi'], 'number'],
            [['email', 'phone'], 'safe'],
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
        $query = Statement::find()->joinWith('member');

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
            'statement_id' => $this->statement_id,
            'member_id' => $this->member_id,
            'amount' => $this->amount,
            'money' => $this->money,
            'frozen_money' => $this->frozen_money,
            'ubi' => $this->ubi,
            'order_id' => $this->order_id,
            'order_payment_id' => $this->order_payment_id,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'statement_type', $this->statement_type])
            ->andFilterWhere(['like', 'statement_desc', $this->statement_desc])
            ->andFilterWhere(['like', 'channel', $this->channel])
            ->andFilterWhere(['like', 'extra', $this->extra]);

        $query->andFilterWhere(['like', 'email', $this->email]);
        $query->andFilterWhere(['like', 'phone', $this->phone]);
        
        return $dataProvider;
    }
}
