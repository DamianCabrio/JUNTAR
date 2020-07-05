<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "presentacion_expositor".
 *
 * @property int $idExpositor
 * @property int $idPresentacion
 *
 * @property Usuario $idExpositor0
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
            [['idExpositor', 'idPresentacion'], 'required'],
            [['idExpositor', 'idPresentacion'], 'integer'],
            [['idExpositor', 'idPresentacion'], 'unique', 'targetAttribute' => ['idExpositor', 'idPresentacion']],
            [['idExpositor'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['idExpositor' => 'idUsuario']],
            [['idPresentacion'], 'exist', 'skipOnError' => true, 'targetClass' => Presentacion::className(), 'targetAttribute' => ['idPresentacion' => 'idPresentacion']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idExpositor' => 'Id Expositor',
            'idPresentacion' => 'Id Presentacion',
        ];
    }

    /**
     * Gets query for [[IdExpositor0]].
     *
     * @return \yii\db\ActiveQuery|UsuarioQuery
     */
    public function getIdExpositor0()
    {
        return $this->hasOne(Usuario::className(), ['idUsuario' => 'idExpositor']);
    }

    /**
     * Gets query for [[IdPresentacion0]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getIdPresentacion0()
    {
        return $this->hasOne(Presentacion::className(), ['idPresentacion' => 'idPresentacion']);
    }

    /**
     * {@inheritdoc}
     * @return PresentacionExpositorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PresentacionExpositorQuery(get_called_class());
    }
}
