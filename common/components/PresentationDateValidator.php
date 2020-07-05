<?php
namespace common\components;
use Yii;
use backend\models\Evento;
use yii\validators\Validator;

class PresentationDateValidator extends Validator{
public function init() {
        parent::init ();
        $this->message = 'La fecha ingresada es invalida.';
    }

    public function validateAttribute( $model , $attribute )
    {
      $event = Evento::findOne(['idEvento' => $model->idEvento]);

      $dateSelect = new \DateTime($model->$attribute);
      $dateInitial = new \DateTime($event->fechaInicioEvento);
      $dateEnd = new \DateTime($event->fechaFinEvento);

      if ($dateSelect < $dateInitial ) {
        $this->addError($model, $attribute, 'Fecha Invalida, el evento comienza el día '.$dateInitial->format('d-m-Y'));
      }
      if ($dateSelect > $dateEnd ) {
        $this->addError($model, $attribute, 'Fecha Invalida, el evento finaliza el día '.$dateEnd->format('d-m-Y'));
      }

    }

    public function clientValidateAttribute( $model , $attribute , $view )
    {


    }
}

 ?>
