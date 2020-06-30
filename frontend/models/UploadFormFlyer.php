<?php

namespace frontend\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadFormFlyer extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFlyer;

    public function rules()
    {
        return [
            [['imageFlyer'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'maxSize'=> 1024*1024*10, 'tooBig' => 'Debe ingresar una imagen menor a 10MB'],
        ];
    }
    
    public function upload()
    {
        if ($this->validate()) {
            $this->imageFlyer->saveAs('../web/eventos/images/flyers/' . $this->imageFlyer->baseName . '.' . $this->imageFlyer->extension);
            return true;
        } else {
            return false;
        }
    }
}