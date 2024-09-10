<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Zcourier;

/**
 * ZcourierSearch represents the model behind the search form about `backend\models\Zcourier`.
 */
class ZcourierSearch extends Zcourier
{
    public $email;
    public $phone;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['courier_id', 'credit_rating', 'grade', 'total_orders', 'bad_orders', 'is_signed'], 'integer'],
            [['user_rating'], 'number'],
            [['email','phone'], 'safe'],
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
        $query = Zcourier::find()->joinWith('member');

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
            'credit_rating' => $this->credit_rating,
            'grade' => $this->grade,
            'user_rating' => $this->user_rating,
            'total_orders' => $this->total_orders,
            'bad_orders' => $this->bad_orders,
            'is_signed' => $this->is_signed,
        ]);
        $query->andFilterWhere(['like', 'email', $this->email]);
        $query->andFilterWhere(['like', 'phone', $this->phone]);
        return $dataProvider;
    }
}
