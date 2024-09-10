<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Zcourierapply;

/**
 * ZcourierapplySearch represents the model behind the search form about `backend\models\Zcourierapply`.
 */
class ZcourierapplySearch extends Zcourierapply
{
    public $email;
    public $phone;
    public $username;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['apply_id', 'courier_id', 'apply_time', 'process_time', 'process_result', 'process_by'], 'integer'],
            [['remark'], 'safe'],
            [['email','phone','username'], 'safe'],
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
        //$query = Zcourierapply::find();
        $query = Zcourierapply::find()->joinWith('member')->joinWith('processMember');

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
            'apply_id' => $this->apply_id,
            'courier_id' => $this->courier_id,
            'apply_time' => $this->apply_time,
            'process_time' => $this->process_time,
            'process_result' => $this->process_result,
            'process_by' => $this->process_by,
        ]);

        $query->andFilterWhere(['like', 'remark', $this->remark])
         ->andFilterWhere(['like', 'member.email', $this->email])
         ->andFilterWhere(['like', 'member.phone', $this->phone])
        ->andFilterWhere(['like', 'username', $this->username]);

        return $dataProvider;
    }
}
