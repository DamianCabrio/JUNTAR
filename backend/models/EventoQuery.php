<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[Evento]].
 *
 * @see Evento
 */
class EventoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Evento[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Evento|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
