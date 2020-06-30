<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "imagen_perfil".
 *
 * @property int $idUsuario
 * @property string $rutaImagenPerfil
 *
 * @property Usuario $idUsuario0
 */
class ImagenPerfil extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'imagen_perfil';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idUsuario', 'rutaImagenPerfil'], 'required'],
            [['idUsuario'], 'integer'],
            [['rutaImagenPerfil'], 'string', 'max' => 300],
            [['rutaImagenPerfil'], 'unique'],
            [['idUsuario', 'rutaImagenPerfil'], 'unique', 'targetAttribute' => ['idUsuario', 'rutaImagenPerfil']],
            [['idUsuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['idUsuario' => 'idUsuario']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idUsuario' => 'Id Usuario',
            'rutaImagenPerfil' => 'Ruta Imagen Perfil',
        ];
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
     * {@inheritdoc}
     * @return ImagenPerfilQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ImagenPerfilQuery(get_called_class());
    }
}
