<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "o_courier_company_organization".
 *
 * @property int $courier_id 自增ID，作为courier_id，其实是虚拟的快递员
 * @property int $company_id 快递公司ID
 * @property int $organization_id 公寓ID
 * @property string $access_code
 * @property int $create_time
 */
class CourierCompanyOrganization extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'o_courier_company_organization';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'organization_id',], 'required'],
            [['company_id', 'organization_id', 'create_time'], 'integer'],
            [['access_code'], 'string', 'max' => 64],
            [['company_id', 'organization_id'], 'unique', 'targetAttribute' => ['company_id', 'organization_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'courier_id' => 'Courier ID',
            'company_id' => 'Company ID',
            'organization_id' => 'Organization ID',
            'access_code' => 'Access Code',
            'create_time' => 'Create Time',
        ];
    }
    public function getCompany()
    {
        return $this->hasOne(Couriercompany::className(), ['company_id' => 'company_id']);
    }
    public function getOrganization()
    {
        return $this->hasOne(Organization::className(), ['organization_id'=>'organization_id']);
    }
}
