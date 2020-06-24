<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use frontend\models\PresentacionExpositor;

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
      $presentationsExhibitor = [];
      $status = false;
      if ($this->presentations > 0) {
        foreach ($this->presentations as $presentation) {
          if (PresentacionExpositor::findOne([
            'idPresentacion' => $presentation->idPresentacion,
            'idExpositor' => $id,
            ])) {
            array_push($presentationsExhibitor, $presentation);
            $status = true;
          }
        }
      }
      if ($status) {
        return $presentationsExhibitor;
      } else {
        return false;
      }
    }

}
