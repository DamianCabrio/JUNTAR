<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[ModalidadEvento]].
 *
 * @see ModalidadEvento
 */
class ModalidadEventoQuery extends \yii\db\ActiveQuery
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
