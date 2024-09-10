<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Memberprofile;
//use backend\models\Member;

/**
 * MemberprofileSearch represents the model behind the search form about `backend\models\Memberprofile`.
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
    //public function search($params)
	public function search($params, $organizationIds = NULL)
    {
        //$query = Memberprofile::find()->joinWith("member");

        // // add conditions that should always apply here
        $query = Memberprofile::find()->leftJoin("o_member_organization","member_profile.member_id = o_member_organization.member_id"); 
		$query->joinWith("member");
        $query->leftJoin("o_organization","o_member_organization.organization_id = o_organization.organization_id");
        $query->leftJoin(Unit::tableName(),Unit::tableName().'.unit_id = o_member_organization.unit_id');
		//   
        //$organizationIds='10008';
        if($organizationIds) {
            $query->andFilterWhere(['in', 'o_member_organization.organization_id', explode(',', $organizationIds)]);
        }
		//$query->andFilterWhere(['in', 'o_member_organization.organization_id', explode(',', '10008')]);
        //$query->select('member_profile.*');
        
		
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
