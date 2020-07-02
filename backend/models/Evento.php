<?php

namespace backend\models;

use Yii;
use common\models\SolicitudAval;

/**
 * This is the model class for table "evento".
 *
 * @property int $idEvento
 * @property int $idUsuario
 * @property int $idCategoriaEvento
 * @property int $idEstadoEvento
 * @property int $idModalidadEvento
 * @property string $nombreEvento
 * @property string $nombreCortoEvento
 * @property string $descripcionEvento
 * @property string $lugar
 * @property string $fechaInicioEvento
 * @property string $fechaFinEvento
 * @property string|null $imgFlyer
 * @property string|null $imgLogo
 * @property int $capacidad
 * @property int $preInscripcion
 * @property string|null $fechaLimiteInscripcion
 * @property string|null $codigoAcreditacion
 * @property string|null $fechaCreacionEvento
 *
 * @property CategoriaEvento $idCategoriaEvento0
 * @property EstadoEvento $idEstadoEvento0
 * @property ModalidadEvento $idModalidadEvento0
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
            [['idUsuario', 'idCategoriaEvento', 'idEstadoEvento', 'idModalidadEvento', 'nombreEvento', 'nombreCortoEvento', 'descripcionEvento', 'lugar', 'fechaInicioEvento', 'fechaFinEvento', 'capacidad', 'preInscripcion'], 'required'],
            [['idUsuario', 'idCategoriaEvento', 'idEstadoEvento', 'idModalidadEvento', 'capacidad', 'preInscripcion'], 'integer'],
            [['fechaInicioEvento', 'fechaFinEvento', 'fechaLimiteInscripcion', 'fechaCreacionEvento'], 'safe'],
            [['nombreEvento', 'lugar', 'imgFlyer', 'imgLogo'], 'string', 'max' => 200],
            [['nombreCortoEvento', 'codigoAcreditacion'], 'string', 'max' => 100],
            [['descripcionEvento'], 'string', 'max' => 800],
            [['idUsuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['idUsuario' => 'idUsuario']],
            [['idCategoriaEvento'], 'exist', 'skipOnError' => true, 'targetClass' => CategoriaEvento::className(), 'targetAttribute' => ['idCategoriaEvento' => 'idCategoriaEvento']],
            [['idModalidadEvento'], 'exist', 'skipOnError' => true, 'targetClass' => ModalidadEvento::className(), 'targetAttribute' => ['idModalidadEvento' => 'idModalidadEvento']],
            [['idEstadoEvento'], 'exist', 'skipOnError' => true, 'targetClass' => EstadoEvento::className(), 'targetAttribute' => ['idEstadoEvento' => 'idEstadoEvento']],
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
            'idCategoriaEvento' => 'Id Categoria Evento',
            'idEstadoEvento' => 'Id Estado Evento',
            'idModalidadEvento' => 'Id Modalidad Evento',
            'nombreEvento' => 'Nombre Evento',
            'nombreCortoEvento' => 'Nombre Corto Evento',
            'descripcionEvento' => 'Descripcion Evento',
            'lugar' => 'Lugar',
            'fechaInicioEvento' => 'Fecha Inicio Evento',
            'fechaFinEvento' => 'Fecha Fin Evento',
            'imgFlyer' => 'Img Flyer',
            'imgLogo' => 'Img Logo',
            'capacidad' => 'Capacidad',
            'preInscripcion' => 'Pre Inscripcion',
            'fechaLimiteInscripcion' => 'Fecha Limite Inscripcion',
            'codigoAcreditacion' => 'Codigo Acreditacion',
            'fechaCreacionEvento' => 'Fecha Creacion Evento',
            'eventoToken' => 'Solicitud Aval FAI',
            'avalado' => 'Avalado FAI',
        ];
    }

    public function deshabilitar(){
        $this->idEstadoEvento = 2;
        $this->save();
    }

    public function habilitar(){
        $this->idEstadoEvento = 4;
        $this->save();
    }

    /**
     * Gets query for [[IdCategoriaEvento0]].
     *
     * @return \yii\db\ActiveQuery|CategoriaEventoQuery
     */
    public function getIdCategoriaEvento0()
    {
        return $this->hasOne(CategoriaEvento::className(), ['idCategoriaEvento' => 'idCategoriaEvento']);
    }

    /**
     * Gets query for [[IdEstadoEvento0]].
     *
     * @return \yii\db\ActiveQuery|EstadoEventoQuery
     */
    public function getIdEstadoEvento0()
    {
        return $this->hasOne(EstadoEvento::className(), ['idEstadoEvento' => 'idEstadoEvento']);
    }

    /**
     * Gets query for [[IdModalidadEvento0]].
     *
     * @return \yii\db\ActiveQuery|ModalidadEventoQuery
     */
    public function getIdModalidadEvento0()
    {
        return $this->hasOne(ModalidadEvento::className(), ['idModalidadEvento' => 'idModalidadEvento']);
    }

    /**
     * Gets query for [[IdUsuario0]].
     *
     * @return \yii\db\ActiveQuery|UsuarioQuery
     */
    public function getIdUsuario0()
    {
        return $this->hasOne(Usuario::className(), ['idUsuario' => 'idUsuario']);
    }

    /**
     * Gets query for [[Inscripcions]].
     *
     * @return \yii\db\ActiveQuery|InscripcionQuery
     */
    public function getInscripcions()
    {
        return $this->hasMany(Inscripcion::className(), ['idEvento' => 'idEvento']);
    }

    /**
     * Gets query for [[Presentacions]].
     *
     * @return \yii\db\ActiveQuery|PresentacionQuery
     */
    public function getPresentacions()
    {
        return $this->hasMany(Presentacion::className(), ['idEvento' => 'idEvento']);
    }
    
    public function getIdAval0(){
        return $this->hasOne(SolicitudAval::className(), ['idEvento' => 'idEvento']);
    }

    /**
     * {@inheritdoc}
     * @return EventoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EventoQuery(get_called_class());
    }
}
