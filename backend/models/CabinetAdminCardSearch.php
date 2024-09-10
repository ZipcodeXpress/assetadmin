<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\CabinetAdminCard;

/**
 * CabinetAdminCardSearch represents the model behind the search form of `backend\models\CabinetAdminCard`.
 */
class CabinetAdminCardSearch extends CabinetAdminCard
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['card_id','zp_admin_id', 'cabinet_id', 'status'], 'integer'],
            [['zp_admin_name', 'zp_admin_role', 'rfid'], 'safe'],
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
        $query = CabinetAdminCard::find();
        $query->leftJoin("o_organization_cabinet","o_organization_cabinet.cabinet_id = cabinet_admin_card.cabinet_id");

        // add conditions that should always apply here
        if($organizationIds) {
            $query->andFilterWhere(['in', 'o_organization_cabinet.organization_id', explode(',', $organizationIds)]);
        }

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
            'zp_admin_id' => $this->zp_admin_id,
            'cabinet_admin_card.cabinet_id' => $this->cabinet_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'zp_admin_name', $this->zp_admin_name])
            ->andFilterWhere(['like', 'zp_admin_role', $this->zp_admin_role])
            ->andFilterWhere(['like', 'rfid', $this->rfid]);

        return $dataProvider;
    }
}
