<?php

namespace frontend\models;

use yii\base\Model;
use yii\web\UploadedFile;
use Yii;
use frontend\models\ImagenPerfil;

class UploadProfileImage extends Model {

    /**
     * @var UploadedFile
     */
    public $profileImage;

    public function rules() {
        return [
            [['profileImage'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
        ];
    }

    public function upload() {
        $imagenGuardada = false;
        if ($this->validate()) {
//            $this->profileImage->saveAs('../web/profile/images/' . Yii::$app->user->identity->idUsuario. '-'. Yii::$app->user->identity->nombre . '.' . $this->profileImage->extension);
            $this->profileImage->saveAs('../web/profile/images/' . Yii::$app->user->identity->idUsuario . '-' . Yii::$app->user->identity->nombre . '.jpg');
            $imagenGuardada = $this->guardarImagenPerfil();
        }
        return $imagenGuardada;
    }

    private function guardarImagenPerfil() {
        $model = ImagenPerfil::findOne(['idUsuario' => Yii::$app->user->identity->idUsuario]);

        //si no encuentra registro, crea un registro para la imagen de perfil del usuario
        if ($model == null) {
            $model = new ImagenPerfil();
            $model->rutaImagenPerfil = (Yii::getAlias("@rutaImagenPerfil/")) . Yii::$app->user->identity->idUsuario . '-' . Yii::$app->user->identity->nombre . '.jpg';
            $model->idUsuario = Yii::$app->user->identity->idUsuario;
        } else {
            //si encuentra el registro, lo actualiza
//            $model['rutaImagenPerfil'] = (Yii::getAlias("@rutaImagenPerfil/")) . Yii::$app->user->identity->idUsuario . '-' . Yii::$app->user->identity->nombre . '.jpg';
            $model->rutaImagenPerfil = (Yii::getAlias("@rutaImagenPerfil/")) . Yii::$app->user->identity->idUsuario . '-' . Yii::$app->user->identity->nombre . '.jpg';
        }
        return $model->save();
    }

}
