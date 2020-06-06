<?php

namespace frontend\models;

use Yii;
use backend\models\Usuario;

/**
 * This is the model class for table "evento".
 *
 * @property int $idEvento
 * @property int $idUsuario
 * @property string $nombreEvento
 * @property string $descripcionEvento
 * @property string $lugar
 * @property string $fechaInicio
 * @property string $fechaFin
 * @property string $modalidad
 * @property string|null $linkPresentaciones
 * @property string|null $linkFlyer
 * @property string|null $linkLogo
 * @property int $capacidad
 * @property int $preInscripcion
 * @property string $fechaLimiteInscripcion
 * @property string|null $codigoAcreditacion
 *
 * @property Fecha[] $fechas
 * @property Usuario $idUsuario0
 * @property Inscripcion[] $inscripcions
 * @property Presentacion[] $presentacions
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
            [['idUsuario', 'nombreEvento', 'descripcionEvento', 'lugar', 'fechaInicio', 'fechaFin', 'modalidad', 'capacidad', 'preInscripcion', 'fechaLimiteInscripcion'], 'required'],
            [['idUsuario', 'capacidad', 'preInscripcion'], 'integer'],
            [['fechaInicio', 'fechaFin', 'fechaLimiteInscripcion'], 'safe'],
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
            'fechaInicio' => 'Fecha Inicio',
            'fechaFin' => 'Fecha Fin',
            'modalidad' => 'Modalidad',
            'linkPresentaciones' => 'Link Presentaciones',
            'linkFlyer' => 'Link Flyer',
            'linkLogo' => 'Link Logo',
            'capacidad' => 'Capacidad',
            'preInscripcion' => 'Pre Inscripcion',
            'fechaLimiteInscripcion' => 'Fecha Limite Inscripcion',
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
     * Gets query for [[Presentacions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPresentacions()
    {
        return $this->hasMany(Presentacion::className(), ['idEvento' => 'idEvento']);
    }
}
