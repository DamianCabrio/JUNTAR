<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[ImagenEvento]].
 *
 * @see ImagenEvento
 */
class ImagenEventoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ImagenEvento[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ImagenEvento|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
