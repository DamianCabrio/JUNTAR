<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[SolicitudAval]].
 *
 * @see SolicitudAval
 */
class SolicitudAvalQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SolicitudAval[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SolicitudAval|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
