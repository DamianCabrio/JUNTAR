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
        var selectedProvince = $("#signupform-provincia").val();
        var selectedLocation = $("#signupform-localidad").val();
        deferred.push($.getJSON('../json/localidades.json', function(json){
            var result = false;
            $.each(json, function(id, province){
                if (province.nombre == selectedProvince ) {
                    $.each(province.ciudades, function(id, location){
                        if (location.nombre == selectedLocation) {
                          result = true;
                        }
                    });
                }
            });
            if (!result) {
              messages.push($message);
            }
        }));
        JS;
    }
}

 ?>
