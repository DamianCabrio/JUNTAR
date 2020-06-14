/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {

    $('.showpw .custom-control-input').click(function () {
        var type = $('#signupform-password').attr("type");

        //verificamos si viene por signup y cambiamos el tipo de campo
        if (type !== null && type === 'password') {
            $('#signupform-password').attr("type", "text");
        } else {
            $('#signupform-password').attr("type", "password");
        }

        //verificamos si viene por login y cambiamos el tipo de campo
        type = $('#loginform-password').attr("type");
        if (type !== null && type === 'password') {
            $('#loginform-password').attr("type", "text");
        } else {
            $('#loginform-password').attr("type", "password");
        }

        //verificamos si viene por resetPassword y cambiamos el tipo de campo
        type = $('#resetpasswordform-password').attr("type");
        if (type !== null && type === 'password') {
            $('#resetpasswordform-password').attr("type", "text");
        } else {
            $('#resetpasswordform-password').attr("type", "password");
        }
    });
    
    // Habilitacion de los popover
    $(function () {
        $("[data-toggle='popover']").popover({
            trigger: 'hover'
        });
    });
    //Utilizado para eliminar los caracteres especiales en nombres de provincias (acentos)
    function eliminarDiacriticos(texto) {
        return texto.normalize('NFD').replace(/[\u0300-\u036f]/g, "");
    }

    //buscamos valores por defecto para pais argentina
    if ($('#signupform-pais').val() === 'Argentina') {
        autocompleteProvincias(eliminarDiacriticos('Argentina'));
    };

    //input provincia
    $('#signupform-pais').change(function () {
        autocompleteProvincias(eliminarDiacriticos($(this).val()));
    });

    //input localidad

    $('#signupform-provincia').change(function () {
        autocompleteLocalidades(eliminarDiacriticos($(this).val()));
    });
});

/**
 * Metodo autocompleteProvincia --> Busca los datos de las provincias pertenecientes al pais seleccionado
 * para ofrecer una lista de opciones de autocompletado.
 *
 * @param {String} nombrePais
 * @returns none
 */

function autocompleteProvincias(nombrePais) {
    $.ajax({
        url: "index.php?r=site%2Fsearch-provincias",
        data: {pais: nombrePais},
        type: "POST",
        dataType: "json"
    })
            .done(function (data) {
                console.log(data);
                if (data !== null) {
                    if ($("#signupform-provincia").autocomplete !== undefined) {
                        $("#signupform-provincia").autocomplete({
                            autoFill: true,
                            minLength: "2",
                            source: data,
                            select: function (event, ui) {
                                $("#signupform-provincia").val(ui.item.id);
                            }
                        });
                    }
                }
            });
}

/**
 * Metodo autocompleteLocalidad --> Busca los datos de las localidades pertenecientes a la provincia seleccionada
 * para ofrecer una lista de opciones de autocompletado.
 *
 * @param {String} nombreProvincia
 * @returns none
 */
function autocompleteLocalidad(nombreProvincia) {
    $.ajax({
        url: "index.php?r=site%2Fsearch-localidades",
        data: {provincia: nombreProvincia},
        type: "POST",
        dataType: "json"
    })
            .done(function (data) {
                console.log(data);
                if (data !== null) {
//                        dataLocalidades = data;
                    if ($("#signupform-localidad").autocomplete !== undefined) {
                        $("#signupform-localidad").autocomplete({
                            autoFill: true,
                            minLength: "2",
                            source: data,
                            select: function (event, ui) {
                                $("#signupform-localidad").val(ui.item.id);
                            }
                        });
                    }
                }
            });
}
    $("#evento-preinscripcion").change(function(){
        respuesta = $("#evento-preinscripcion").val();
        if(respuesta == 0){
            $("#fechaLimite").hide();
            $("#evento-fechalimiteinscripcion").attr("required", false);
        }
        if(respuesta == 1){
            $("#fechaLimite").show();
            $("#evento-fechalimiteinscripcion").attr("required", true);
        }
    });
});
