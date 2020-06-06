<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "evento".
 *
 * @property int $idEvento
 * @property int $idUsuario
 * @property string $nombreEvento
 * @property string $descripcionEvento
 * @property string $lugar
 * @property string $modalidad
 * @property string|null $linkPresentaciones
 * @property string|null $linkFlyer
 * @property string|null $linkLogo
 * @property int $capacidad
 * @property int $preInscripcion
 * @property string $fechaLimiteInscripcion
 * @property string $fechaDeCreacion
 * @property string|null $codigoAcreditacion
 *
 * @property Fecha[] $fechas
 * @property Usuario $idUsuario0
 * @property Inscripcion[] $inscripcions
 * @property Presentacion $presentacion
 */
class Evento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'evento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idUsuario', 'nombreEvento', 'descripcionEvento', 'lugar', 'modalidad', 'capacidad', 'preInscripcion', 'fechaLimiteInscripcion'], 'required'],
            [['idUsuario', 'capacidad', 'preInscripcion'], 'integer'],
            [['fechaLimiteInscripcion', 'fechaDeCreacion'], 'safe'],
            [['nombreEvento', 'codigoAcreditacion'], 'string', 'max' => 100],
            [['descripcionEvento', 'lugar', 'modalidad', 'linkPresentaciones', 'linkFlyer', 'linkLogo'], 'string', 'max' => 200],
            [['idUsuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['idUsuario' => 'idUsuario']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idEvento' => 'Id Evento',
            'idUsuario' => 'Id Usuario',
            'nombreEvento' => 'Nombre Evento',
            'descripcionEvento' => 'Descripcion Evento',
            'lugar' => 'Lugar',
            'modalidad' => 'Modalidad',
            'linkPresentaciones' => 'Link Presentaciones',
            'linkFlyer' => 'Link Flyer',
            'linkLogo' => 'Link Logo',
            'capacidad' => 'Capacidad',
            'preInscripcion' => 'Pre Inscripcion',
            'fechaLimiteInscripcion' => 'Fecha Limite Inscripcion',
            'fechaDeCreacion' => 'Fecha De Creacion',
            'codigoAcreditacion' => 'Codigo Acreditacion',
        ];
    }

    /**
     * Gets query for [[Fechas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFechas()
    {
        return $this->hasMany(Fecha::className(), ['idEvento' => 'idEvento']);
    }

    /**
     * Gets query for [[IdUsuario0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdUsuario0()
    {
        return $this->hasOne(Usuario::className(), ['idUsuario' => 'idUsuario']);
    }

    /**
     * Gets query for [[Inscripcions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInscripcions()
    {
        return $this->hasMany(Inscripcion::className(), ['idEvento' => 'idEvento']);
    }

    /**
     * Gets query for [[Presentacion]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPresentacion()
    {
        return $this->hasOne(Presentacion::className(), ['idEvento' => 'idEvento']);
    }
}
