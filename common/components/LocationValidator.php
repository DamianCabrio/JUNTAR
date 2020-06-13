<?php
namespace common\components;
use yii\validators\Validator;

class LocationValidator extends Validator{
public function init() {
        parent::init ();
        $this->message = 'La localidad ingresada es invalida.';
    }

    public function validateAttribute( $model , $attribute ) {

    }

    public function clientValidateAttribute( $model , $attribute , $view )
    {
      $message = json_encode($this->message, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
      return <<<JS
        deferred.push($.getJSON('https://apis.datos.gob.ar/georef/api/localidades', {'nombre':$("#signupform-localidad").val()}, function(json){
            console.log(json.cantidad);
            if (json.cantidad == '0') {
              console.log($message);
              messages.push($message);
            }
        }));
        JS;
    }
}

 ?>
