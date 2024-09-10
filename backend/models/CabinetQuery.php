<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[Cabinet]].
 *
 * @see Cabinet
 */
class CabinetQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Cabinet[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Cabinet|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
