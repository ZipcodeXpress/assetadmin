<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[CabinetBoxModel]].
 *
 * @see CabinetBoxModel
 */
class CabinetboxmodelQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return CabinetBoxModel[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CabinetBoxModel|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
