<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[PresentacionExpositor]].
 *
 * @see PresentacionExpositor
 */
class PresentacionExpositorQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PresentacionExpositor[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PresentacionExpositor|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
