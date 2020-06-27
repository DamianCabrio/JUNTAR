/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {


    //Permite quitar la imagen logo cargada en el input file del formulario de carga y edicion
    $("#quitarLogo").click(function () {
        $("#uploadformlogo-imagelogo").val(null);
    });

    //Permite quitar la imagen flyer cargada en el input file del formulario de carga y edicion
    $("#quitarFlyer").click(function () {
        $("#uploadformflyer-imageflyer").val(null);
    });

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
    //buscamos valores por defecto para pais argentina
    if ($('#signupform-pais').val() === 'Argentina') {
        autocompleteProvincias('Argentina');
    }
    ;
    //input provincia
    $('#signupform-pais').change(function () {
        autocompleteProvincias($(this).val());
    });
    //input localidad

    $('#signupform-provincia').change(function () {
        autocompleteLocalidades($(this).val());
    });
    //funcionalidad agregar pregunta
    $('.agregarPregunta').click(function (link) {
        //impedimos que el cambio de pestaña se active
        link.preventDefault();
        //llamamos a la funcion que se encargue de mostrar el formulario
        agregarPreguntaModal($(this).attr('href'), 'Agregar Pregunta');
    });

    //funcionalidad agregar pregunta
    $('.verRespuesta').click(function (link) {
        //impedimos que el cambio de pestaña se active
        link.preventDefault();
        //llamamos a la funcion que se encargue de mostrar el formulario
        verRespuestasModal($(this).attr('href'), 'Ver respuestas');
    });

    //funcionalidad agregar pregunta
    $('.editarPregunta').click(function (link) {
        //impedimos que el cambio de pestaña se active
        link.preventDefault();
        //llamamos a la funcion que se encargue de mostrar el formulario
        editarPreguntaModal($(this).attr('href'), 'Editar Pregunta');
    });
    //funcionalidad editar perfil
    $('.editProfile').click(function (link) {
        //impedimos que el cambio de pestaña se active
        link.preventDefault();
        //llamamos a la funcion que se encargue de mostrar el formulario
        editarPerfilModal($(this).attr('href'), 'Datos de la cuenta');
    });

    //funcionalidad editar perfil
    $('.responderPregunta').click(function (link) {
        //impedimos que el cambio de pestaña se active
        link.preventDefault();
        //llamamos a la funcion que se encargue de mostrar el formulario
        responderRespuestaModal($(this).attr('href'), 'Responder pregunta');
    });

    //funcionalidad editar perfil
    $('.uploadProfileImage').click(function (link) {
        //impedimos que el cambio de pestaña se active
        link.preventDefault();
        //llamamos a la funcion que se encargue de mostrar el formulario
        editarPerfilModal($(this).attr('href'), 'Nueva imagen de Perfil');
    });
    //funcionalidad editar perfil
    $('.editarEvento').click(function (link) {
        //impedimos que el cambio de pestaña se active
        link.preventDefault();
        var slug = $('.editarEvento').data('id');
        //llamamos a la funcion que se encargue de mostrar el formulario
        editEventoModal(slug);
    });
    //generar opciones de nombres cortos automaticamente
    $('#evento-nombreevento').change(function () {
        $('#automaticSlug').html("");
        generarOpcionesNombreCorto(eliminarDiacriticos($(this).val()));
    });
    //    $('#evento-descripcionevento').click(function () {
    //        alert($('#evento-nombrecortoevento').val());
    //    });

    //seleccion de nombres cortos
    $(document).on('click', '.nombresCortos input:radio', function () {
        if ($(this).attr('id') !== 'otro') {
            $('#evento-nombrecortoevento').prop('readonly', true);
            $('#evento-nombrecortoevento').val($(this).val());
        } else {
            $('#evento-nombrecortoevento').prop('readonly', false);
        }
    });
    //funcionalidad mostrar certificdos
    $('.viewCertification').click(function (link) {
        //impedimos que el cambio de pestaña se active
        link.preventDefault();
        //llamamos a la funcion que se encargue de mostrar el formulario
        viewCertificationModal($(this).attr('href'));
    });
    //funcionalidad editar perfil
    $('.editarPresentacion').click(function (link) {
        //impedimos que el cambio de pestaña se active
        link.preventDefault();
        //llamamos a la funcion que se encargue de mostrar el formulario
        editPresentacionModal($(this).attr('href'));
    });
    $('.borrarPresentacion').click(function (link) {
        //impedimos que el cambio de pestaña se active
        link.preventDefault();
        //llamamos a la funcion que se encargue de mostrar el formulario
        deletePresentacionModal($(this).attr('href'));
    });
    $('.agregarPresentacion').click(function (link) {
        //impedimos que el cambio de pestaña se active
        link.preventDefault();
        //llamamos a la funcion que se encargue de mostrar el formulario
        agregarPresentacionModal($(this).attr('href'));
    });


    $('.verPresentacion').click(function (link) {
        //impedimos que el cambio de pestaña se active
        link.preventDefault();
        //llamamos a la funcion que se encargue de mostrar el formulario
        verPresentacionModal($(this).attr('href'));
    });
    $('.verExpositores').click(function (link) {
        //impedimos que el cambio de pestaña se active
        link.preventDefault();
        //llamamos a la funcion que se encargue de mostrar el formulario
        verExpositoresModal($(this).attr('href'));
    });
    //prueba
    $('#cargarPresentacion').submit(function () {
        $('#presentacion-diapresentacion').attr('required', true);
        $('#presentacion-diapresentacion').addClass('is-invalid');
        $('#invalidFecha').html('Dia Presentacion no puede estar Vacio');
        $('#invalidFecha').show();
    });
    $('#editarPresentacion').submit(function () {
        $('#presentacion-diapresentacion').attr('required', true);
        $('#presentacion-diapresentacion').addClass('is-invalid');
        $('#invalidFecha').html('Dia Presentacion no puede estar Vacio');
        $('#invalidFecha').show();
    });

    $('#presentacion-diapresentacion').change(function () {
        var fechaIni = $('#fechaIniEvento').val();
        var fechaFin = $('#fechaFinEvento').val();
        var fechaPre = $(this).val();
        //console.log(fechaPre);
        //console.log(fechaIni);
        //console.log(fechaFin);

        if (fechaIni <= fechaPre && fechaFin >= fechaPre) {
            //console.log("bien");
            $(this).addClass('is-valid');
            $(this).removeClass('is-invalid');
            $('#invalidFecha').hide();
        } else {
            //console.log("Mal");
            $(this).removeClass('is-valid');
            $(this).addClass('is-invalid');
            $('#invalidFecha').html('El Dia de la Presentacion debe estar entre la fecha inicio y la fecha fin del evento.<br> Fecha Inicio Evento: ' + fechaIni + '<br>Fecha Fin Evento: ' + fechaFin);
            $('#invalidFecha').show();
        }

    });
    //funcionalidad mostrar certificdos
    $('.viewCertification').click(function (link) {
        //impedimos que el cambio de pestaña se active
        link.preventDefault();
        //llamamos a la funcion que se encargue de mostrar el formulario
        viewCertificationModal($(this).attr('href'));
    });
});

//Prueba

/**
 * Metodo editProfileModal --> El modelo relacionado a la edicion del perfil en un documento html
 * y captura su div para mostrarlo en un modal, para evitar pasear de una pagina a otra
 * 
 * @returns none
 */
function verExpositoresModal(link) {
    //hace la petición a la url
    //si para cargar el formulario necesita enviarle data, se envia.
    $.ajax({
        url: link,
        //        data: {data: data}
    }).done(function (data) {

        $('#modalEvento').modal('show')
            .find('.modal-body')
            .html(data);
        $('#modalEvento').find('.modal-header')
            .html("<h3> Lista de expositores </h3>");
    });
}

function verRespuestasModal(link) {
    //hace la petición a la url
    //si para cargar el formulario necesita enviarle data, se especifica
    $.ajax({
        url: link
        //        data: {data: data}
    }).done(function (data) {
        $('#modalRespuestas').modal('show')
            .find('.modal-body')
            .html(data);
        //        $('#modalRespuestas').find('.modal-header')
        //.html("<h3> Cargar presentación </h3>");
    });
}

function editPresentacionModal(link) {
    //hace la petición a la url
    //si para cargar el formulario necesita enviarle data, se especifica
    $.ajax({
        url: link
        //        data: {data: data}
    }).done(function (data) {
        $('#modalEvento').modal('show')
            .find('.modal-body')
            .html(data);
        //        $('#modalEvento').find('.modal-header')
        //.html("<h3> Cargar presentación </h3>");
    });
}

function deletePresentacionModal(link) {
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
        var dataHTML = $.parseHTML(data); //<----try with $.parseHTML().
        //buscamos el div que queremos mostrar en la vista recibida y lo escribimos sobre el cuerpo del modal
        $(dataHTML).find('div.presentacion-delete').each(function () {
            console.log($(this).html());
            $('.modal-header').html("<h3> Borrar presentacion </h3>");
            $('.modal-body').html($(this).html());
        });
    });
}

function agregarPresentacionModal(link) {
    //hace la petición a la url
    //si para cargar el formulario necesita enviarle data, se especifica
    $.ajax({
        url: link
        //        data: {data: data}
    }).done(function (data) {
        $('#modalEvento').modal('show')
            .find('.modal-body')
            .html(data);
        //        $('#modalEvento').find('.modal-header');
        //.html("<h3> Cargar presentación </h3>");
    });
}

function verPresentacionModal(link) {
    //hace la petición a la url
    //si para cargar el formulario necesita enviarle data, se envia.
    $.ajax({
        url: link,
        //        data: {data: data}
    }).done(function (data) {
        $('#modalEvento').modal('show')
            .find('.modal-body')
            .html(data);
        $('#modalEvento').find('.modal-header')
            .html("<h3> Información de la Presentación </h3>");
    });
}
$('.cargarExpositores').click(function (link) {
    //impedimos que el cambio de pestaña se active
    link.preventDefault();
    //llamamos a la funcion que se encargue de mostrar el formulario
    agregarExpositorModal($(this).attr('href'));
});
function agregarExpositorModal(link) {
    //hace la petición a la url
    //si para cargar el formulario necesita enviarle data, se especifica
    $.ajax({
        url: link
        //        data: {data: data}
    }).done(function (data) {
        $('#modalEvento').modal('show')
            .find('.modal-body')
            .html(data);
        $('#modalEvento').find('.modal-header')
        //.html("<h3> Cargar presentación </h3>");
    });
}

//funcion utilizada para eliminar caracteres criticos en un texto
function eliminarDiacriticos(texto) {
    return texto.normalize('NFD').replace(/[\u0300-\u036f]/g, "");
}

function generarOpcionesNombreCorto(nombreEvento) {
    $('#automaticSlug').append(generarSlug(nombreEvento));
    $('#automaticSlug').append(generarInicialesYear(nombreEvento));
    $('#automaticSlug').append(generarCortoYear(nombreEvento));
}

function generarSlug(nombreEvento) {
    var slug = nombreEvento.toLowerCase()
        .replace(/[^\w ]+/g, '') //reemplaza caracteres alfanumericos
        .replace(/ +/g, '-'); //

    var html = '<div class="col-12"> <span class="m-auto"> <input type="radio" id="opc1" name="shortName" value="' + slug + '"> '
        + '<label for="opc1"> ' + slug + '</label> </span> </div>';
    return html;
}

function generarInicialesYear(nombreEvento) {
    var year = new Date().getFullYear();
    var inicialesYear = nombreEvento.match(/\b(\w)/g)
        .join('');
    inicialesYear += year;
    var html = '<div class="col-12"> <span class="m-auto"> <input type="radio" id="opc2" name="shortName" value="' + inicialesYear + '"> '
        + '<label for="opc2"> ' + inicialesYear + '</label> </span> </div>';
    return html;
}

function generarCortoYear(nombreEvento) {
    var year = new Date().getFullYear();
    var cortoYear = year;
    cortoYear += "-" + nombreEvento.split(' ').slice(0, 2).join('-');
    var html = '<div class="col-12"> <span class="m-auto"> <input type="radio" id="opc3" name="shortName" value="' + cortoYear + '"> '
        + '<label for="opc3"> ' + cortoYear + '</label> </span> </div>';
    return html;
}

/**
 * Metodo editProfileModal --> El modelo relacionado a la edicion del perfil en un documento html
 * y captura su div para mostrarlo en un modal, para evitar pasear de una pagina a otra
 * 
 * @returns none
 */
function editEventoModal(url) {
    //hace la petición a la url
    //si para cargar el formulario necesita enviarle data, se envia.
    $.ajax({
        url: url,
        //        data: {data: data}
    }).done(function (data) {
        //data recibe la vista que deberia renderizarse al visitar la url
        //hacemos visible el modal
        $('#modalEvento').modal('show');
        //convertimos a html la vista recibida
        var dataHTML = $.parseHTML(data); //<----try with $.parseHTML().
        //buscamos el div que queremos mostrar en la vista recibida y lo escribimos sobre el cuerpo del modal
        $(dataHTML).find('div.evento-form').each(function () {
            //            $('.modal-header').append("Nueva imagen de perfil");
            $('.modal-header').html("<h3> Editar evento </h3>");
            $('.modal-body').html($(this).html());
        });
    });
}

function editarPerfilModal(unaUrl, titulo) {
    //hace la petición a la url
    //si para cargar el formulario necesita enviarle data, se especifica
    $.ajax({
        url: unaUrl
        //        data: {data: data}
    }).done(function (data) {
        $('#profileModal').modal('show')
            .find('.modal-body')
            .html(data);
        $('#profileModal').find('.modal-header')
            .html("<h3> " + titulo + " </h3>");
    });
}

function agregarPreguntaModal(unaUrl, titulo) {
    //hace la petición a la url
    //si para cargar el formulario necesita enviarle data, se especifica
    $.ajax({
        url: unaUrl
        //        data: {data: data}
    }).done(function (data) {
        $('#modalPregunta').modal('show')
            .find('.modal-body')
            .html(data);
        $('#modalPregunta').find('.modal-header')
            .html("<h3> " + titulo + " </h3>");
    });
}

function editarPreguntaModal(unaUrl, titulo) {
    //hace la petición a la url
    //si para cargar el formulario necesita enviarle data, se especifica
    $.ajax({
        url: unaUrl
        //        data: {data: data}
    }).done(function (data) {
        $('#modalPregunta').modal('show')
            .find('.modal-body')
            .html(data);
        $('#modalPregunta').find('.modal-header')
            .html("<h3> " + titulo + " </h3>");
    });
}

function responderRespuestaModal(unaUrl, titulo) {
    //hace la petición a la url
    //si para cargar el formulario necesita enviarle data, se especifica
    $.ajax({
        url: unaUrl
        //        data: {data: data}
    }).done(function (data) {
        $('#modalPregunta').modal('show')
            .find('.modal-body')
            .html(data);
        $('#modalPregunta').find('.modal-header')
            .html("<h3> " + titulo + " </h3>");
    });
}

/**
 * Metodo viewCertificationModal --> Permite visualizar el panel de los certificados
 * para acceder a la previsualización del mismo.
 * @returns none
 */
function viewCertificationModal(url) {
    //hace la petición a la url
    //si para cargar el formulario necesita enviarle data, se envia.
    $.ajax({
        url: url
        //        data: {data: data}
    }).done(function (data) {
        //data recibe la vista que deberia renderizarse al visitar la url
        //hacemos visible el modal
        console.log(data);
        $('#modalCertificado').modal('show');
        //convertimos a html la vista recibida
        var dataHTML = $.parseHTML(data); //<----try with $.parseHTML().
        //buscamos el div que queremos mostrar en la vista recibida y lo escribimos sobre el cuerpo del modal
        $(dataHTML).find('div.certificates-buttons').each(function () {
            $('.modal-header').html("<h3>Certificado de</h3>");
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
        url: "search-provincias",
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
        url: "search-localidades",
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

