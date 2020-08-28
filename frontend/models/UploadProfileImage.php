<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadProfileImage extends Model
{

    /**
     * @var UploadedFile
     */
    public $profileImage;

    public function rules()
    {
        return [
            [['profileImage'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
        ];
    }

    public function upload()
    {
        $imagenGuardada = false;
        if ($this->validate()) {
            $nombreRegistro = Yii::$app->user->identity->idUsuario . time() . '-' .Yii::$app->security->generateRandomString();
//            $this->profileImage->saveAs('../web/profile/images/' . Yii::$app->user->identity->idUsuario. '-'. Yii::$app->user->identity->nombre . '.' . $this->profileImage->extension);
            $this->profileImage->saveAs('../web/profile/images/' . $nombreRegistro . '.jpg');
            $imagenGuardada = $this->guardarImagenPerfil($nombreRegistro);
        }
        return $imagenGuardada;
    }

    private function guardarImagenPerfil($nombreRegistro)
    {
        $model = ImagenPerfil::findOne(['idUsuario' => Yii::$app->user->identity->idUsuario]);

        //si no encuentra registro, crea un registro para la imagen de perfil del usuario
        if ($model == null) {
            $model = new ImagenPerfil();
//            $model->rutaImagenPerfil = (Yii::getAlias("@rutaImagenPerfil/")) . Yii::$app->user->identity->idUsuario . '-' . Yii::$app->user->identity->nombre . '.jpg';
            $model->rutaImagenPerfil = (Yii::getAlias("@rutaImagenPerfil/")) . $nombreRegistro . '.jpg';
            $model->idUsuario = Yii::$app->user->identity->idUsuario;
        } else {
            //si encuentra el registro, lo actualiza
            
            //borramos el archivo de la carpeta
            unlink(substr($model->rutaImagenPerfil, 1));
            //guardamos la ruta en el modelo
            $model->rutaImagenPerfil = (Yii::getAlias("@rutaImagenPerfil/")) . $nombreRegistro . '.jpg';
        }
        //guardamos el registro
        return $model->save();
    }

}
