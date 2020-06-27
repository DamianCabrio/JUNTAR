<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "usuario".
 *
 * @property int $idUsuario
 * @property string $nombre
 * @property string $apellido
 * @property int|null $dni
 * @property string $pais
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
 * @property Presentacion[] $idPresentacions
 * @property Inscripcion[] $inscripcions
 * @property Permiso[] $itemNames
 * @property PresentacionExpositor[] $presentacionExpositors
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
            [['nombre', 'apellido', 'pais', 'email', 'auth_key', 'password_hash', 'created_at', 'updated_at'], 'required'],
            [['dni', 'status', 'created_at', 'updated_at'], 'integer'],
            [['nombre', 'apellido'], 'string', 'max' => 50],
            [['pais'], 'string', 'max' => 40],
            [['provincia'], 'string', 'max' => 60],
            [['localidad'], 'string', 'max' => 70],
            [['email', 'password_hash', 'password_reset_token', 'verification_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
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
            'pais' => 'Pais',
            'provincia' => 'Provincia',
            'localidad' => 'Localidad',
            'email' => 'Email',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'verification_token' => 'Verification Token',
        ];
    }
    
    public function delete(){
        $this->status = 0;
        $this->save();
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
     * Gets query for [[IdPresentacions]].
     *
     * @return \yii\db\ActiveQuery|PresentacionQuery
     */
    public function getIdPresentacions()
    {
        return $this->hasMany(Presentacion::className(), ['idPresentacion' => 'idPresentacion'])->viaTable('presentacion_expositor', ['idExpositor' => 'idUsuario']);
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
     * Gets query for [[ItemNames]].
     *
     * @return \yii\db\ActiveQuery|PermisoQuery
     */
    public function getItemNames()
    {
        return $this->hasMany(Permiso::className(), ['name' => 'item_name'])->viaTable('usuario_rol', ['user_id' => 'idUsuario']);
    }

    /**
     * Gets query for [[PresentacionExpositors]].
     *
     * @return \yii\db\ActiveQuery|PresentacionExpositorQuery
     */
    public function getPresentacionExpositors()
    {
        return $this->hasMany(PresentacionExpositor::className(), ['idExpositor' => 'idUsuario']);
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
