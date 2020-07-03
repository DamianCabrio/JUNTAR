<?php
namespace common\components;

use yii\validators\Validator;

class ProvinceValidator extends Validator
{
    public function init()
    {
        parent::init();
        $this->message = 'La Provincia ingresada es invalida.';
    }

    public function validateAttribute($model, $attribute)
    {

    }

    public function clientValidateAttribute($model, $attribute, $view)
    {
        $message = json_encode($this->message, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        return <<<JS
        var selectedProvince = $("#signupform-provincia").val();
        var selectedCountry = $("#signupform-pais").val();
        deferred.push($.getJSON('../json/provincias.json', function(json){
            var result = false;
            $.each(json, function(id, country){
                if (country.name == selectedCountry ) {
                    $.each(country.provincias, function(id, province){
                        if (province.nombre == selectedProvince) {
                          result = true;
                        }
                    });
                }
            });
            if (!result) {
              messages.push($message)
            }
        }));
        JS;
    }
}

?>
