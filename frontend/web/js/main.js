/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {

    //Verifica si el evento requeire preinscripcion para mostrar el campo fechalimite
    if ($("#evento-fechalimiteinscripcion").val() != 0) {
        $("#fechaLimite").show();
        $("#evento-fechalimiteinscripcion").attr("required", true);
        $("#i1").attr('checked', true);
    } else {
        $("#fechaLimite").hide();
        $("#evento-fechalimiteinscripcion").attr("required", false);
        $("#evento-fechalimiteinscripcion").val(null);
        $("#i0").attr('checked', true);
    }
    $("#evento-preinscripcion input").change(function () {
        respuesta = $(this).val();
        if (respuesta == 1) {
            $("#fechaLimite").show();
            $("#evento-fechalimiteinscripcion").attr("required", true);
            $("#evento-fechalimiteinscripcion").addClass("is-invalid");
        }
        if (respuesta == 0) {
            $("#fechaLimite").hide();
            $("#evento-fechalimiteinscripcion").attr("required", false);
            $("#evento-fechalimiteinscripcion").val(null);
        }
    });

    //Verifica si en evento posee capacidad de espectadores
    if ($("#evento-capacidad").val() != 0) {
        $("#mostrarCapacidad").show();
        $("#evento-capacidad").attr("required", true);
        $("#espectadores-si").attr('checked', true);
    } else {
        $("#mostrarCapacidad").hide();
        $("#evento-capacidad").attr("required", false);
        $("#evento-capacidad").val(null);
        $("#espectadores-no").attr('checked', true);
    }
    $("#w0 input[name=posee-espectadores]").change(function () {
        capacidad = $(this).val();
        if (capacidad == 2) {
            $("#mostrarCapacidad").show();
            $("#evento-capacidad").attr("required", true);
        }
        if (capacidad == -1) {
            $("#mostrarCapacidad").hide();
            $("#evento-capacidad").attr("required", false);
            $("#evento-capacidad").val(null);
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
    };

    //input provincia
    $('#signupform-pais').change(function () {
        autocompleteProvincias(eliminarDiacriticos($(this).val()));
    });

    //input localidad

    $('#signupform-provincia').change(function () {
        autocompleteLocalidades(eliminarDiacriticos($(this).val()));
    });

    //funcionalidad editar perfil
    $('.editarPresentacion').click(function (link) {
        //impedimos que el cambio de pestaña se active
        link.preventDefault();
        //llamamos a la funcion que se encargue de mostrar el formulario
        editPresentacionModal($(this).attr('href'));
    });
});

/**
 * Metodo editProfileModal --> El modelo relacionado a la edicion del perfil en un documento html
 * y captura su div para mostrarlo en un modal, para evitar pasear de una pagina a otra
 * 
 * @returns none
 */
function editPresentacionModal(link) {
    //hace la petición a la url
    //si para cargar el formulario necesita enviarle data, se envia.
    $.ajax({
        url: link,
        //        data: {data: data}
    }).done(function (data) {
        //data recibe la vista que deberia renderizarse al visitar la url
        //hacemos visible el modal
        $('#modalEvento').modal('show');
        //convertimos a html la vista recibida
        var dataHTML = $.parseHTML(data);  //<----try with $.parseHTML().
        //buscamos el div que queremos mostrar en la vista recibida y lo escribimos sobre el cuerpo del modal
        $(dataHTML).find('div.presentacion-form').each(function () {
            console.log($(this).html());
            $('.modal-header').html("<h3> Editar presentacion </h3>");
            $('.modal-body').html($(this).html());
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
        data: { pais: nombrePais },
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
        data: { provincia: nombreProvincia },
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
