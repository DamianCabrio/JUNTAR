<?php

namespace frontend\models;

use yii\base\Model;
use yii\web\UploadedFile;
use Yii;

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
        if ($this->validate()) {
//            $this->profileImage->saveAs('../web/profile/images/' . Yii::$app->user->identity->idUsuario. '-'. Yii::$app->user->identity->nombre . '.' . $this->profileImage->extension);
            $this->profileImage->saveAs('../web/profile/images/' . Yii::$app->user->identity->idUsuario. '-'. Yii::$app->user->identity->nombre . '.jpg');
            return true;
        } else {
            return false;
        }
    }
}