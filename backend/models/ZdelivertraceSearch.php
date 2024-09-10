<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Zdelivertrace;

/**
 * ZdelivertraceSearch represents the model behind the search form about `backend\models\Zdelivertrace`.
 */
class ZdelivertraceSearch extends Zdelivertrace
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['trace_id', 'deliver_id', 'create_time',], 'integer'],
            [['trace', 'desc'], 'safe'],
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
        $query = Zdelivertrace::find();

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
            'trace_id' => $this->trace_id,
            'deliver_id' => $this->deliver_id,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'trace', $this->trace])
            ->andFilterWhere(['like', 'desc', $this->desc]);

        return $dataProvider;
    }
}
