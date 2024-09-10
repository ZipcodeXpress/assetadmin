<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[Cabinetbodybox]].
 *
 * @see Cabinetbodybox
 */
class CabinetbodyboxQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Cabinetbodybox[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Cabinetbodybox|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
