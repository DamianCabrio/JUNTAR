<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "presentacion_expositor".
 *
 * @property int $idPresentacion
 * @property int $idExpositor
 *
 * @property Expositor $idExpositor0
 * @property Presentacion $idPresentacion0
 */
class PresentacionExpositor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'presentacion_expositor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idPresentacion', 'idExpositor'], 'required'],
            [['idPresentacion', 'idExpositor'], 'integer'],
            [['idPresentacion'], 'exist', 'skipOnError' => true, 'targetClass' => Presentacion::className(), 'targetAttribute' => ['idPresentacion' => 'idPresentacion']],
            [['idExpositor'], 'exist', 'skipOnError' => true, 'targetClass' => Expositor::className(), 'targetAttribute' => ['idExpositor' => 'idExpositor']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idPresentacion' => 'Id Presentacion',
            'idExpositor' => 'Id Expositor',
        ];
    }

    /**
     * Gets query for [[IdExpositor0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdExpositor0()
    {
        return $this->hasOne(Expositor::className(), ['idExpositor' => 'idExpositor']);
    }

    /**
     * Gets query for [[IdPresentacion0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdPresentacion0()
    {
        return $this->hasOne(Presentacion::className(), ['idPresentacion' => 'idPresentacion']);
    }
}
