/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {

    //variables globales para no buscar información todo el tiempo
    dataProvincias = null;
    dataLocalidades = null;
    nombrePais = null;
    nombreProvincia = null;

    //funcionalidad mostrarContraseña
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
    //fin mostrarContraseña

    //funcionalidad popover contraseña
    $(function () {
        $("[data-toggle='popover']").popover({
            trigger: 'hover'
        });
    });
    //fin popover contraseña

    //Utilizado para eliminar los caracteres especiales en nombres de provincias (acentos)
    function eliminarDiacriticos(texto) {
        return texto.normalize('NFD').replace(/[\u0300-\u036f]/g, "");
    }

    //input provincia
//    $(document).on('input', '#signupform-provincia', function () {
//        if (nombrePais !== $("#signupform-pais").val()) {
//            dataProvincias = null;
//            nombrePais = $("#signupform-pais").val();
//        }
    $('#signupform-pais').change(function () {
        autocompleteProvincia(eliminarDiacriticos($(this).val()));
    });
    //fin input provincia

    //input localidad
//    $(document).on('input', '#signupform-localidad', function () {
//        if (nombreProvincia !== $("#signupform-provincia").val()) {
//            dataLocalidades = null;
//            nombreProvincia = $("#signupform-provincia").val();
//        }
    $('#signupform-provincia').change(function () {
        autocompleteLocalidad(eliminarDiacriticos($(this).val()));
    });
    //fin input localidad

    //reset data
//    $(document).on('submit', '.signup-button', function () {
//        dataProvincias = null;
//        dataLocalidades = null;
//        nombreProvincia = null;
//        nombrePais = null;
//    });
    //fin reset data
});

/**
 * Metodo autocompleteProvincia --> Busca los datos de las provincias pertenecientes al pais seleccionado
 * para ofrecer una lista de opciones de autocompletado.
 * 
 * @param {String} nombrePais
 * @returns none
 */
//function autocompleteProvincia(nombrePais) {
//    //si la data no fue buscada con anterioridad, procede a hacer la busqueda
//    //utiliza el nombre de pais
//    if (dataProvincias === null) {
//        $.ajax({
//            url: "index.php?r=site%2Fsearch-provincias",
//            data: {pais: nombrePais},
//            type: "POST",
//            dataType: "json"
//        })
//                .done(function (data) {
//                    console.log(data);
//                    if (data !== null) {
//                        dataProvincias = data;
//                    }
//                });
//    }
//
//    //si la data fue seteada, procede a ayudar con el autocompletado
//    if (dataProvincias !== null) {
//        if ($("#signupform-provincia").autocomplete !== undefined) {
//            $("#signupform-provincia").autocomplete({
//                autoFill: true,
//                minLength: "2",
//                source: dataProvincias,
//                select: function (event, ui) {
//                    $("#signupform-provincia").val(ui.item.id);
//                    nombreProvincia = $("#signupform-provincia").val();
//                }
//            });
//        }
//    }
//}
function autocompleteProvincia(nombrePais) {
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
//function autocompleteLocalidad(nombreProvincia) {
//    //si la data no fue buscada con anterioridad, procede a hacer la busqueda
//    //utiliza el nombre de la provincia
//    if (dataLocalidades === null) {
//        $.ajax({
//            url: "index.php?r=site%2Fsearch-localidades",
//            data: {provincia: nombreProvincia},
//            type: "POST",
//            dataType: "json"
//        })
//                .done(function (data) {
//                    console.log(data);
//                    if (data !== null) {
//                        dataLocalidades = data;
//                    }
//                });
//    }
//
//    //si la data fue seteada, procede a ayudar con el autocompletado
//    if (dataLocalidades !== null) {
//        if ($("#signupform-localidad").autocomplete !== undefined) {
//            $("#signupform-localidad").autocomplete({
//                autoFill: true,
//                minLength: "2",
//                source: dataLocalidades,
//                select: function (event, ui) {
//                    $("#signupform-localidad").val(ui.item.id);
//                }
//            });
//        }
//    }
//}
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












/**
 * OLD Methods
 */
function autocompleteProvincias2(paisName) {
    $.ajax({
        url: "index.php?r=site%2Fsearch-provincias&name=" + paisName,
//            type: "POST",
        dataType: "json"
    })
            .done(function (data) {
//                    console.log(data);
                if ($("#signupform-provincia").autocomplete !== undefined) {
                    $("#signupform-provincia").autocomplete({
                        "autoFill": true,
                        "minLength": "2",
                        "source": data,
                        "select": function (event, ui) {
                            $("#signupform-provincia").val(ui.item.id);
                        }
                    });
                }
            });
}