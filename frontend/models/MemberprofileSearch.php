<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Memberprofile;

/**
 * MemberprofileSearch represents the model behind the search form about `frontend\models\Memberprofile`.
 */
class MemberprofileSearch extends Memberprofile
{
    public $email;
    public $phone;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_id', 'zipcode', 'sex', 'profile_id', 'create_time'], 'integer'],
            [['nick_name', 'first_name', 'last_name', 'addressline1', 'addressline2', 'city', 'state', 'phone', 'birth', 'avatar'], 'safe'],
            [['email', 'phone'], 'safe'],
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
        $query = Memberprofile::find()->joinWith("member");

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
            'member_id' => $this->member_id,
            'zipcode' => $this->zipcode,
            'birth' => $this->birth,
            'sex' => $this->sex,
            'profile_id' => $this->profile_id,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'nick_name', $this->nick_name])
        ->andFilterWhere(['like', 'email', $this->email])
        ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'addressline1', $this->addressline1])
            ->andFilterWhere(['like', 'addressline2', $this->addressline2])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'avatar', $this->avatar]);
        

        return $dataProvider;
    }
}
