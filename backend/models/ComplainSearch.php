<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Complain;

/**
 * ComplainSearch represents the model behind the search form about `backend\models\Complain`.
 */
class ComplainSearch extends Complain
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['complain_id', 'member_id', 'complain_photo_group_id', 'process_status', 'process_time', 'process_by', 'order_id', 'create_time'], 'integer'],
            [['complain_content', 'process_remark', 'order_type'], 'safe'],
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
        $query = Complain::find();

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
            'complain_id' => $this->complain_id,
            'member_id' => $this->member_id,
            'complain_photo_group_id' => $this->complain_photo_group_id,
            'process_status' => $this->process_status,
            'process_time' => $this->process_time,
            'process_by' => $this->process_by,
            'order_id' => $this->order_id,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'complain_content', $this->complain_content])
            ->andFilterWhere(['like', 'process_remark', $this->process_remark])
            ->andFilterWhere(['like', 'order_type', $this->order_type]);

        return $dataProvider;
    }
}
