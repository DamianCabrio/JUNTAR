<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "usuario".
 *
 * @property int $idUsuario
 * @property string $nombre
 * @property string $apellido
 * @property int|null $dni
 * @property string|null $fecha_nacimiento
 * @property string|null $localidad
 * @property int|null $telefono
 * @property string $email
 * @property string $auth_key
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string|null $verification_token
 *
 * @property Evento[] $eventos
 * @property Expositor[] $expositors
 * @property Inscripcion[] $inscripcions
 * @property UsuarioRol[] $usuarioRols
 */
class Usuario extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            //Obligatorio
            [['nombre', 'apellido', 'dni', 'localidad', 'email'], 'required'],

            //Reglas DNI
            ['dni', 'integer', 'min' => 10000000, 'max' => 100000000],
            
            //Reglas String
            [['nombre', 'apellido', 'localidad'], 'string', 'message' => 'El campo contiene caracteres no permitidos'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idUsuario' => 'Id Usuario',
            'nombre' => 'Nombre',
            'apellido' => 'Apellido',
            'dni' => 'Dni',
//            'fecha_nacimiento' => 'Fecha Nacimiento',
            'localidad' => 'Localidad',
//            'telefono' => 'Telefono',
//            'email' => 'Email',
        ];
    }

    /**
     * Gets query for [[Eventos]].
     *
     * @return \yii\db\ActiveQuery|EventoQuery
     */
    public function getEventos()
    {
        return $this->hasMany(Evento::className(), ['idUsuario' => 'idUsuario']);
    }

    /**
     * Gets query for [[Expositors]].
     *
     * @return \yii\db\ActiveQuery|ExpositorQuery
     */
    public function getExpositors()
    {
        return $this->hasMany(Expositor::className(), ['idUsuario' => 'idUsuario']);
    }

    /**
     * Gets query for [[Inscripcions]].
     *
     * @return \yii\db\ActiveQuery|InscripcionQuery
     */
    public function getInscripcions()
    {
        return $this->hasMany(Inscripcion::className(), ['idUsuario' => 'idUsuario']);
    }

    /**
     * Gets query for [[UsuarioRols]].
     *
     * @return \yii\db\ActiveQuery|UsuarioRolQuery
     */
    public function getUsuarioRols()
    {
        return $this->hasMany(UsuarioRol::className(), ['user_id' => 'idUsuario']);
    }

    /**
     * {@inheritdoc}
     * @return UsuarioQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UsuarioQuery(get_called_class());
    }
}
