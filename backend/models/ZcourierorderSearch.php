<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Zcourierorder;

/**
 * ZcourierorderSearch represents the model behind the search form about `backend\models\Zcourierorder`.
 */
class ZcourierorderSearch extends Zcourierorder
{
    public $email;
    public $phone;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'deliver_id', 'courier_id', 'create_time', 'fetch_time', 'fetch_photo_group_id', 'status',  ], 'integer'],
            [['cancel_reason', 'user_rating', 'remark'], 'safe'],
            [['fee_total'], 'number'],
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
        $query = Zcourierorder::find()->joinWith('member');

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
            'order_id' => $this->order_id,
            'deliver_id' => $this->deliver_id,
            'courier_id' => $this->courier_id,
            'create_time' => $this->create_time,
            'fetch_time' => $this->fetch_time,
            'fetch_photo_group_id' => $this->fetch_photo_group_id,
            Zcourierorder::tableName().'.status' => $this->status,
            'fee_total' => $this->fee_total,
        ]);

        $query->andFilterWhere(['like', 'cancel_reason', $this->cancel_reason])
            ->andFilterWhere(['like', 'user_rating', $this->user_rating])
            ->andFilterWhere(['like', 'remark', $this->remark])
             ->andFilterWhere(['like', 'member.email', $this->email])
             ->andFilterWhere(['like', 'member.phone', $this->phone]);

        return $dataProvider;
    }
}
