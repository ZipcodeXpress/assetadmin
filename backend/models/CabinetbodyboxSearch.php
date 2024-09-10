<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Cabinetbodybox;

/**
 * CabinetbodyboxSearch represents the model behind the search form about `app\models\Cabinetbodybox`.
 */
class CabinetbodyboxSearch extends Cabinetbodybox
{
    public $body_model_name; 
    public $box_model_name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['body_box_id', 'body_model_id', 'box_model_id', 'row', 'column', 'addr', 'create_time'], 'integer'],
            [['body_model_name','box_model_name'],'safe'],
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
        $query = Cabinetbodybox::find();

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
            'body_box_id' => $this->body_box_id,
            'body_model_id' => $this->body_model_id,
            'box_model_id' => $this->box_model_id,
            'row' => $this->row,
            'column' => $this->column,
            'addr' => $this->addr,
            'create_time' => $this->create_time,
        ]);

        return $dataProvider;
    }
    public function searchWithBodyModel($params)
    {
        $query = Cabinetbodybox::find()->With('bodymodel')->with('boxmodel');
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
            'body_box_id' => $this->body_box_id,
            'body_model_id' => $this->body_model_id,
            'box_model_id' => $this->box_model_id,
            'body_model_id' =>$this->body_model_name,
            'box_model_id' => $this->box_model_name,
            'row' => $this->row,
            'column' => $this->column,
            'addr' => $this->addr,
            'create_time' => $this->create_time,
        ]);

        return $dataProvider;
    }
}
