<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Memberorganization;

/**
 * MemberorganizationSearch represents the model behind the search form about `frontend\models\Memberorganization`.
 :*/
class MemberorganizationSearch extends Memberorganization
{
    public $email;
    public $phone;
    public $organization_name;
    public $unit_name;
    public $first_name;
    public $last_name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_id', 'organization_id', 'building_id', 'room_id', 'apply_photo_group_id', 'apply_time', 'approve_time', 'approve_status', 'charge_day', 'status', 'cancel_time', 'create_time'], 'integer'],
            [['price', 'cost', 'cost_offline'], 'number'],
            [['email', 'phone','organization_name','unit_name','first_name', 'last_name',], 'safe'],
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
    public function search($params, $organizationIds=null)
    {
        //$query = Memberorganization::find(); 
        $query = Memberorganization::find()->orderBy('apply_time DESC')->groupBy('member_id,unit_id');
        $query->joinWith('member');
        $query->leftJoin(Organization::tableName(),Organization::tableName().'.organization_id = o_member_organization.organization_id');
        $query->leftJoin(Unit::tableName(),Unit::tableName().'.unit_id = o_member_organization.unit_id');
	//$query->leftJoin('member_profile.member_id = o_member_organization.member_id');

        if($organizationIds) {
            $query->andFilterWhere(['in', 'o_member_organization.organization_id', explode(',', $organizationIds)]);
        }
        
        $query->andFilterWhere(['in', 'o_member_organization.status', [0,1,2,3]]);
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
            'o_member_organization.member_id' => $this->member_id,
            'organization_id' => $this->organization_id,
            'apply_photo_group_id' => $this->apply_photo_group_id,
            'apply_time' => $this->apply_time,
            'approve_time' => $this->approve_time,
            'approve_status' => $this->approve_status,
            'charge_day' => $this->charge_day,
            'price' => $this->price,
            'cost' => $this->cost,
            'cost_offline' => $this->cost_offline,
            Memberorganization::tableName().'.status' => $this->status,
            'cancel_time' => $this->cancel_time,
            'create_time' => $this->create_time,
        ]);
        $query->andFilterWhere(['like', 'email', $this->email]);
        $query->andFilterWhere(['like', 'phone', $this->phone]);
        $query->andFilterWhere(['like', 'unit_name', $this->unit_name]);
        
        $query->andFilterWhere(['=', 'o_member_organization.organization_id', $this->organization_name]);
       // $query->andFilterWhere(['=', 'o_member_organization.unit_id', $this->unit_name]);
        
        return $dataProvider;
    }
    public function apmr_search($params, $organizationIds=null)
    {
        //$query = Memberorganization::find();
        $query = Memberorganization::find()->orderBy('apply_time DESC')->groupBy('member_id,unit_id');
        $query->joinWith('member');
        $query->leftJoin(Organization::tableName(),Organization::tableName().'.organization_id = o_member_organization.organization_id');
        $query->leftJoin(Unit::tableName(),Unit::tableName().'.unit_id = o_member_organization.unit_id');
	$query->leftJoin(Memberprofile::tableName(),Memberprofile::tableName().'.member_id = o_member_organization.member_id');
    
        if($organizationIds) {
            $query->andFilterWhere(['in', 'o_member_organization.organization_id', explode(',', $organizationIds)]);
        }
        $query->andFilterWhere(['in', 'o_member_organization.status', [0,1,2,3]]);
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
            'o_member_organization.member_id' => $this->member_id,
            'organization_id' => $this->organization_id,
            'apply_photo_group_id' => $this->apply_photo_group_id,
            'apply_time' => $this->apply_time,
            'approve_time' => $this->approve_time,
            'approve_status' => $this->approve_status,
            'charge_day' => $this->charge_day,
            'price' => $this->price,
            'cost' => $this->cost,
            'cost_offline' => $this->cost_offline,
            Memberorganization::tableName().'.status' => $this->status,
            'cancel_time' => $this->cancel_time,
            'create_time' => $this->create_time,
        ]);
        $query->andFilterWhere(['like', 'email', $this->email]);
        $query->andFilterWhere(['like', 'phone', $this->phone]);
        $query->andFilterWhere(['like', 'unit_name', $this->unit_name]);
	$query->andFilterWhere(['like', 'first_name', $this->first_name]);
	$query->andFilterWhere(['like', 'last_name', $this->last_name]);
    
        $query->andFilterWhere(['=', 'o_member_organization.organization_id', $this->organization_name]);
        //$query->andFilterWhere(['=', 'o_member_organization.unit_id', $this->unit_name]);
    
        return $dataProvider;
    }
}
