<?php
namespace common\components;
use Yii;
use backend\models\Evento;
use yii\validators\Validator;

class PresentationHoursValidator extends Validator{
public function init() {
        parent::init ();
        $this->message = 'Hora invalida, es menor a la hora de inicio.';
    }

    public function validateAttribute( $model , $attribute )
    {

    }

    public function clientValidateAttribute( $model , $attribute , $view )
    {
      $message = json_encode($this->message, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
      return <<<JS
        var selectedHoursInitial = $("#presentacion-horainiciopresentacion").val();
        var selectedHoursEnd = $("#presentacion-horafinpresentacion").val();
        if (selectedHoursEnd < selectedHoursInitial) {
          messages.push($message);
        }
        JS;
    }
}

 ?>
