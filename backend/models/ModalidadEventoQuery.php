<?php

namespace backend\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[ModalidadEvento]].
 *
 * @see ModalidadEvento
 */
class ModalidadEventoQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ModalidadEvento[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ModalidadEvento|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
