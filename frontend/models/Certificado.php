<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\models\PresentacionExpositor;

class Certificado extends Model
{
    public $event;
    public $presentations;
    public $inscription;

    public function verifyOrganizer($id)
    {

      if (count($this->event) > 0) {
        if ($this->event[0]->idUsuario == $id) {
          return true;
        }
      } else {
        return false;
      }
    }
    public function verifyAccreditation()
    {

      if ($this->inscription[0]->acreditacion == 1) {
        return true;
      } else {
        return false;
      }
    }
    public function verifyExhibitor($id)
    {

      if (count($this->presentations)>0) {
        foreach ($this->presentations as $presentation) {
          if ($presentation['idExpositor'] == $id) {
            return true;
          }
        }
      } else {
        return false;
      }

    }

}
