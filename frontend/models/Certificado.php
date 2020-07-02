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

    public function setEvent($newEvent)
    {
      $this->event = $newEvent;
    }
    public function setPresentations($newPresentations)
    {
      $this->presentations = $newPresentations;
    }
    public function setInscription($newInscription)
    {
      $this->inscription = $newInscription;
    }

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
