<?php

namespace backend\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Regla]].
 *
 * @see Regla
 */
class ReglaQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Regla[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Regla|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
