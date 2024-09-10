<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Cabinetbox;

/**
 * CabinetboxSearch represents the model behind the search form about `backend\models\Cabinetbox`.
 */
class CabinetboxSearch extends Cabinetbox
{
    public $model_name;
    public $body_name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['box_id', 'box_model_id', 'cabinet_id', 'body_id', 'row', 'column', 'addr', 'status', 'blocked', 'update_time', 'create_time'], 'integer'],
            [['model_name','body_name'],'safe'],
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
        $query = Cabinetbox::find();

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
            'box_id' => $this->box_id,
            'box_model_id' => $this->box_model_id,
            'box_model_id' => $this->model_name,
            'cabinet_id' => $this->cabinet_id,
            'body_id' => $this->body_id,
            'body_id' => $this->body_name,
            'row' => $this->row,
            'column' => $this->column,
            'addr' => $this->addr,
            'status' => $this->status,
            'blocked' => $this->blocked,
            'update_time' => $this->update_time,
            'create_time' => $this->create_time,
        ]);

        return $dataProvider;
    }
}
