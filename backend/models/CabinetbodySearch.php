<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Cabinetbody;

/**
 * CabinetbodySearch represents the model behind the search form about `backend\models\Cabinetbody`.
 */
class CabinetbodySearch extends Cabinetbody
{
    public $model_name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['body_id', 'cabinet_id', 'body_model_id', 'addr'], 'integer'],
            [['body_name', 'direction', 'sequence'], 'safe'],
            [['model_name'],'safe'],
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
        $query = Cabinetbody::find()->joinWith('bodymodel');

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
            'body_id' => $this->body_id,
            'cabinet_id' => $this->cabinet_id,
            'body_model_id' => $this->body_model_id,
            'body_model_id' => $this->model_name,
            'addr' => $this->addr,
        ]);

        $query->andFilterWhere(['like', 'body_name', $this->body_name])
            ->andFilterWhere(['like', 'direction', $this->direction])
            ->andFilterWhere(['like', 'sequence', $this->sequence]);

        return $dataProvider;
    }
}
