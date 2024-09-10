<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Zdeliver;

/**
 * ZdeliverSearch represents the model behind the search form about `backend\models\Zdeliver`.
 */
class ZdeliverSearch extends Zdeliver
{
    public $email;
    public $phone;
    public $to_email;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['deliver_id', 'cargo_type_id', 'box_model_id', 'from_member_id', 'from_cabinet_id', 'from_box_id', 'to_member_id', 'to_cabinet_id', 'to_box_id', 'deliver_photo_group_id', 'create_time', 'update_time',  'status', 'courier_id'], 'integer'],
            [['cargo_worth', 'cargo_weight', 'dist', 'fee_total'], 'number'],
            [['to_phone', 'to_name', 'remark', 'cargo_code', 'pick_code'], 'safe'],
            [['email', 'phone', 'to_email'], 'safe'],
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
        $query = Zdeliver::find();
        $query->joinWith(['fromMember', 'toMember']);
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
            'deliver_id' => $this->deliver_id,
            'cargo_type_id' => $this->cargo_type_id,
            'cargo_worth' => $this->cargo_worth,
            'cargo_weight' => $this->cargo_weight,
            'box_model_id' => $this->box_model_id,
            'from_member_id' => $this->from_member_id,
            'from_cabinet_id' => $this->from_cabinet_id,
            'from_box_id' => $this->from_box_id,
            'to_member_id' => $this->to_member_id,
            'to_cabinet_id' => $this->to_cabinet_id,
            'to_box_id' => $this->to_box_id,
            'deliver_photo_group_id' => $this->deliver_photo_group_id,
            'dist' => $this->dist,
            'fee_total' => $this->fee_total,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            Zdeliver::tableName().'.status' => $this->status,
            'courier_id' => $this->courier_id,
        ]);

        $query->andFilterWhere(['like', 'to_phone', $this->to_phone])
            ->andFilterWhere(['like', 'to_name', $this->to_name])
            ->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'cargo_code', $this->cargo_code])
            ->andFilterWhere(['like', 'pick_code', $this->pick_code])
        ->andFilterWhere(['like', 'fromMember.email', $this->email])
        ->andFilterWhere(['like', 'fromMember.phone', $this->phone])
        ->andFilterWhere(['like', 'toMember.email', $this->to_email]);

        return $dataProvider;
    }
}
