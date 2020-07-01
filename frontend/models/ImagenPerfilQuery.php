<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[ImagenPerfil]].
 *
 * @see ImagenPerfil
 */
class ImagenPerfilQuery extends \yii\db\ActiveQuery
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
