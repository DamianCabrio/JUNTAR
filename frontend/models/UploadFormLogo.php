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
            $this->imageLogo->saveAs('../web/eventos/images/logos/' . $this->imageLogo->baseName . '.' . $this->imageLogo->extension);
            return true;
        } else {
            return false;
        }
    }
}