<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuario".
 *
 * @property int $idUsuario
 * @property string $nombre
 * @property string $apellido
 * @property int|null $dni
 * @property string|null $pais
 * @property string|null $provincia
 * @property string|null $localidad
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
            [['nombre', 'apellido', 'dni', 'pais', 'provincia', 'localidad', 'email'], 'required'],
//            [['dni', 'telefono', 'status', 'created_at', 'updated_at'], 'integer'],
//            [['fecha_nacimiento'], 'safe'],
            [['nombre', 'apellido', 'pais', 'provincia', 'localidad'], 'string', 'max' => 50],
//            [['email', 'password_hash', 'password_reset_token', 'verification_token'], 'string', 'max' => 255],
//            [['auth_key'], 'string', 'max' => 32],
            [['email'], 'unique'],
//            [['password_reset_token'], 'unique'],
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
            'pais' => 'País',
            'provincia' => 'Provincia',
            'localidad' => 'Localidad',
//            'telefono' => 'Telefono',
            'email' => 'Email',
//            'auth_key' => 'Auth Key',
//            'password_hash' => 'Password Hash',
//            'password_reset_token' => 'Password Reset Token',
//            'status' => 'Status',
//            'created_at' => 'Created At',
//            'updated_at' => 'Updated At',
//            'verification_token' => 'Verification Token',
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
