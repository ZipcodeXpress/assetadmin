<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Room;

/**
 * RoomSearch represents the model behind the search form about `backend\models\Room`.
 */
class RoomSearch extends Room
{
    public $building_name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['room_id', 'building_id', 'create_time'], 'integer'],
            [['room_name', 'floor', 'unit'], 'safe'],
            [['building_name'], 'safe'],
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
        $query = Room::find()->joinWith("building");

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
            'room_id' => $this->room_id,
            'building_id' => $this->building_id,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'room_name', $this->room_name])
            ->andFilterWhere(['like', 'floor', $this->floor])
            ->andFilterWhere(['like', 'unit', $this->unit]);
        
        $query->andFilterWhere(['like', 'building_name', $this->building_name]) ;

        return $dataProvider;
    }
}
