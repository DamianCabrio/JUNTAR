<?php

namespace frontend\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[ImagenPerfil]].
 *
 * @see ImagenPerfil
 */
class ImagenPerfilQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ImagenPerfil[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ImagenPerfil|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
