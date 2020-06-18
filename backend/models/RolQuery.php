<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[Permiso]].
 *
 * @see Permiso
 */
class RolQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Permiso[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Permiso|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
