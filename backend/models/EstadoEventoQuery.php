<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[EstadoEvento]].
 *
 * @see EstadoEvento
 */
class EstadoEventoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return EstadoEvento[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return EstadoEvento|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
