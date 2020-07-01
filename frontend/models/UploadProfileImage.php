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
        //Por ahora, se guarda la imagen con el mismo nombre siempre para evitar saturar el sv
        //si a alguien se le ocurre cambiar muchas veces su foto de perfil. El archivo siempre
        //se sobreescribe.
//        $model['rutaImagenPerfil'] = (Yii::getAlias("@rutaImagenPerfil/")) . Yii::$app->user->identity->idUsuario . '-' . Yii::$app->user->identity->nombre . '.jpg';
        $model->rutaImagenPerfil = (Yii::getAlias("@rutaImagenPerfil/")) . Yii::$app->user->identity->idUsuario . '-' . Yii::$app->user->identity->nombre . '.jpg';
        return $model->save();
    }

}
