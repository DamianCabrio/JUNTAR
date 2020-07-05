<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[Presentacion]].
 *
 * @see Presentacion
 */
class PresentacionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Presentacion[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Presentacion|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
