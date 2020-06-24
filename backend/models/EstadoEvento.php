<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "estado_evento".
 *
 * @property int $idEstadoEvento
 * @property string $descripcionEstado
 *
 * @property Evento[] $eventos
 */
class EstadoEvento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estado_evento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcionEstado'], 'required'],
            [['descripcionEstado'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idEstadoEvento' => 'Id Estado Evento',
            'descripcionEstado' => 'Descripcion Estado',
        ];
    }

    /**
     * Gets query for [[Eventos]].
     *
     * @return \yii\db\ActiveQuery|EventoQuery
     */
    public function getEventos()
    {
        return $this->hasMany(Evento::className(), ['idEstadoEvento' => 'idEstadoEvento']);
    }

    /**
     * {@inheritdoc}
     * @return EstadoEventoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EstadoEventoQuery(get_called_class());
    }
}
