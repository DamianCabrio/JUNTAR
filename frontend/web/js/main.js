/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {

    //Verifica si el evento requeire preinscripcion para mostrar el campo fechalimite 
    $("#evento-preinscripcion").change(function () {
        respuesta = $("#evento-preinscripcion").val();
        if (respuesta == 0) {
            $("#fechaLimite").hide();
            $("#evento-fechalimiteinscripcion").attr("required", false);
        }
        if (respuesta == 1) {
            $("#fechaLimite").show();
            $("#evento-fechalimiteinscripcion").attr("required", true);
        }
    });

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
    }
    ;

    //input provincia
    $('#signupform-pais').change(function () {
        autocompleteProvincias(eliminarDiacriticos($(this).val()));
    });

    //input localidad

    $('#signupform-provincia').change(function () {
        autocompleteLocalidades(eliminarDiacriticos($(this).val()));
    });

    //funcionalidad editar perfil
    $('.editProfile').click(function (link) {
        //impedimos que el cambio de pestaña se active
        link.preventDefault();
        //llamamos a la funcion que se encargue de mostrar el formulario
        editProfileModal();
    });
});

/**
 * Metodo editProfileModal --> El modelo relacionado a la edicion del perfil en un documento html
 * y captura su div para mostrarlo en un modal, para evitar pasear de una pagina a otra
 * 
 * @returns none
 */
function editProfileModal() {
    //hace la petición a la url
    //si para cargar el formulario necesita enviarle data, se envia.
    $.ajax({
        url: "index.php?r=cuenta/editprofile",
//        data: {data: data}
    }).done(function (data) {
        //hacemos visible el modal
        $('#modalProfile').modal('show');
        //convertimos a html el documento recibido
        var dataHTML = $.parseHTML(data);  //<----try with $.parseHTML().
        //buscamos el div que queremos mostrar en el html recibido y lo escribimos sobre el cuerpo del modal
        $(dataHTML).find('div.profileForm').each(function () {
            $('.modal-body').append($(this).html());
        });
    });
}

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
function autocompleteLocalidades(nombreProvincia) {
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
