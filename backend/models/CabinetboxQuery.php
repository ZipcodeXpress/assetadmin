<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[Cabinetbox]].
 *
 * @see Cabinetbox
 */
class CabinetboxQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Cabinetbox[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Cabinetbox|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
