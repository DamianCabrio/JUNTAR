<?php

namespace frontend\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "modalidad_evento".
 *
 * @property int $idModalidadEvento
 * @property string $descripcionModalidad
 *
 * @property Evento[] $eventos
 */
class ModalidadEvento extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'modalidad_evento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcionModalidad'], 'required'],
            [['descripcionModalidad'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idModalidadEvento' => 'Id Modalidad Evento',
            'descripcionModalidad' => 'Descripcion Modalidad',
        ];
    }

    /**
     * Gets query for [[Eventos]].
     *
     * @return ActiveQuery
     */
    public function getEventos()
    {
        return $this->hasMany(Evento::className(), ['idModalidadEvento' => 'idModalidadEvento']);
    }
}
