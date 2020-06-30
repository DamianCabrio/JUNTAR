<?php

namespace frontend\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadFormLogo extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageLogo;

    public function rules()
    {
        return [
            [['imageLogo'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
        ];
    }
    
    public function upload()
    {
        if ($this->validate()) {
            //'../web/eventos/images/logos/'
            //$rutaGuardarLogo = (Yii::getAlias('@rutaLogo'));
             // $ruta = Yii::getPathOfAlias('webroot').'/images/fotocarnet/';
            //$rutaLogo = Yii::getPathOfAlias('webroot').'/eventos/images/logos/';
            $this->imageLogo->saveAs('../web/eventos/images/logos/' . $this->imageLogo->baseName . '.' . $this->imageLogo->extension);
            return true;
        } else {
            return false;
        }
    }
}