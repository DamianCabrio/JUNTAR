<?php
namespace common\components;
use yii\validators\Validator;

class LocationValidator extends Validator{
public function init() {
        parent::init ();
        $this->message = 'La localidad ingresada es invalida.';
    }

    public function validateAttribute( $model , $attribute ) {
      // Abre la solicitud
      $curl = curl_init();
      // Establecemos la url de consulta de APIs Georef
      curl_setopt_array($curl, [
          CURLOPT_RETURNTRANSFER => 1,
          CURLOPT_URL => 'https://apis.datos.gob.ar/georef/api/localidades?nombre='.$model->$attribute,
      ]);
      // Enviamos la solicitud y guardamos el resultado en $resp
      $resp = curl_exec($curl);
      // Cierra la solicitud
      curl_close($curl);
      $resp = json_decode($resp, true);
        if ( $resp['cantidad'] == 0) {
            $this->addError($model, $attribute, 'La localidad ingresada es invalida.');
        }
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
