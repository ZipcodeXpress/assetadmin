<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Member;

/**
 * MemberSearch represents the model behind the search form about `frontend\models\Member`.
 */
class MemberSearch extends Member
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_id', 'salt', 'register_time', 'lastlogin_time', 'status', 'c_status', 'is_email_verified', 'is_profile_completed', 'has_credit_card', 'cabinet_id'], 'integer'],
            [['email', 'phone', 'password', 'last_ip', 'service_mode','unit_name','first_name','last_name'], 'safe'],
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
    public function search($params, $organizationIds = NULL)
    {
        $query = Member::find()->leftJoin("o_member_organization","member.member_id = o_member_organization.member_id"); $query->joinWith("profile");
        $query->leftJoin("o_organization","o_member_organization.organization_id = o_organization.organization_id");
        $query->leftJoin(Unit::tableName(),Unit::tableName().'.unit_id = o_member_organization.unit_id');
       
        
        if($organizationIds) {
            $query->andFilterWhere(['in', 'o_member_organization.organization_id', explode(',', $organizationIds)]);
        }
        $query->select('member.*,o_unit.unit_name,member_profile.first_name');
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
            'salt' => $this->salt,
            'register_time' => $this->register_time,
            'lastlogin_time' => $this->lastlogin_time,
            'member.status' => $this->status,
            'c_status' => $this->c_status,
            'is_email_verified' => $this->is_email_verified,
            'is_profile_completed' => $this->is_profile_completed,
            'has_credit_card' => $this->has_credit_card,
            'cabinet_id' => $this->cabinet_id,
        ]);

        $query->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'member.phone', $this->phone])
            ->andFilterWhere(['like', 'unit_name', $this->unit_name])
            ->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'last_ip', $this->last_ip])
            ->andFilterWhere(['like', 'service_mode', $this->service_mode]);

        return $dataProvider;
    }
}
