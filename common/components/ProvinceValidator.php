<?php
namespace common\components;
use yii\validators\Validator;

class ProvinceValidator extends Validator{
public function init() {
        parent::init ();
        $this->message = 'La Provincia ingresada es invalida.';
    }

    public function validateAttribute( $model , $attribute ) {
  
    }

    public function clientValidateAttribute( $model , $attribute , $view )
    {
      $location = $model->$attribute;
      $message = json_encode($this->message, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
      return <<<JS
        deferred.push($.getJSON('https://apis.datos.gob.ar/georef/api/provincias', {'nombre':$("#signupform-provincia").val()}, function(json){
            if (json.cantidad == '0' && json.total == '0') {
              console.log($message);
              messages.push($message);
            }
        }));
        JS;
    }
}

 ?>
