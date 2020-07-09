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
        var respuesta = $(this).val();
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
        var capacidad = $(this).val();
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
        if ($(this).val() !== null && $(this).val() !== '') {
            autocompleteProvincias($(this).val());
        }
    });
    //input localidad

    $('#signupform-provincia').change(function () {
        if ($(this).val() !== null && $(this).val() !== '') {
            autocompleteLocalidades($(this).val());
        }
    });

    //funcionalidad agregar pregunta
    $('.agregarPregunta').click(function (link) {
        //impedimos que el cambio de pestaña se active
        link.preventDefault();
        //llamamos a la funcion que se encargue de mostrar el formulario
        agregarPreguntaModal($(this).attr('href'), 'Agregar Pregunta');
    });

    //funcionalidad ver respuesta
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

    //funcionalidad ver QR
    $('.visualizarQR').click(function (link) {
        //impedimos que el cambio de pestaña se active
        link.preventDefault();
        //llamamos a la funcion que se encargue de mostrar el formulario
        visualizarQrModal($(this).attr('href'), 'QR:');
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
    /*$('#cargarPresentacion').submit(function () {
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
     
     });*/
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
                .html("<h3> Lista de expositores </h3><button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>");
    });
}

function verRespuestasModal(unaUrl) {
//hace la petición a la url
//si para cargar el formulario necesita enviarle data, se especifica
    $.ajax({
        url: unaUrl
//        data: {data: data}
    }).done(function (data) {
        $('#modalRespuestas').modal('show')
                .find('.modal-body')
                .html(data);
        $('#modalRespuestas').find('.modal-header')
                .html("<h3>Ver respuestas</h3>");
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
        $('#modalEvento').find('.modal-header')
                .html("<h3> Editar presentación </h3><button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>");
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
//            console.log($(this).html());
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
        $('#modalEvento').find('.modal-header')
                .html("<h3> Cargar presentación </h3><button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>");
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
                .html("<h3> Información de la Presentación </h3><button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>");
    });
}
/*$('.cargarExpositores').click(function (link) {
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
 .html("<h3> Cargar expositor </h3>");
 });
 }*/

//funcion utilizada para eliminar caracteres criticos en un texto
function eliminarDiacriticos(texto) {
    return texto.normalize('NFD').replace(/[\u0300-\u036f]/g, "");
}

function generarOpcionesNombreCorto(nombreEvento) {
    $('#automaticSlug').append(generarSlug(nombreEvento));
    $('#automaticSlug').append(generarInicialesYear(nombreEvento));
    $('#automaticSlug').append(generarCortoYear(nombreEvento));
    $('#automaticSlug').append('<div class="col-12"><input type="radio" id="otro" name="shortName" value=""> <label for="otro">Otro: </label></div>');
}

function generarSlug(nombreEvento) {
    var slug = nombreEvento.toLowerCase()
            .replace(/[^\w ]+/g, '') //reemplaza caracteres alfanumericos
            .replace(/ +/g, '-'); //

    var html = '<div class="col-12"> <input type="radio" id="opc1" name="shortName" value="' + slug + '"> '
            + '<label for="opc1"> ' + slug + '</label> </div>';
    return html;
}

function generarInicialesYear(nombreEvento) {
    var year = new Date().getFullYear();
    var inicialesYear = nombreEvento.match(/\b(\w)/g)
            .join('');
    inicialesYear += year;
    var html = '<div class="col-12"><input type="radio" id="opc2" name="shortName" value="' + inicialesYear + '"> '
            + '<label for="opc2"> ' + inicialesYear + '</label>  </div>';
    return html;
}

function generarCortoYear(nombreEvento) {
    var year = new Date().getFullYear();
    var cortoYear = year;
//    cortoYear += "-" + nombreEvento.split(' ').slice(0, 2).join('-');
    cortoYear += "-" + nombreEvento.toLowerCase().replace(/[^\w ]+/g, '') //reemplaza caracteres alfanumericos
            .replace(/ +/g, '-').split('-').slice(0, 2).join('-')
    //
    var html = '<div class="col-12">  <input type="radio" id="opc3" name="shortName" value="' + cortoYear + '"> '
            + '<label for="opc3"> ' + cortoYear + '</label>  </div>';
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

function visualizarQrModal(unaUrl, titulo) {
    //hace la petición a la url
    //si para cargar el formulario necesita enviarle data, se especifica
    $.ajax({
        url: unaUrl
                //        data: {data: data}
    }).done(function (data) {
        $('#QRModal').modal('show')
                .find('.modal-body')
                .html(data);
        $('#QRModal').find('.modal-header')
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
//        console.log(data);
        $('#modalCertificado').modal('show');
        //convertimos a html la vista recibida
        var dataHTML = $.parseHTML(data); //<----try with $.parseHTML().
        //buscamos el div que queremos mostrar en la vista recibida y lo escribimos sobre el cuerpo del modal
        $(dataHTML).find('div.certificates-buttons').each(function () {
            $('.modal-header').html("<h3>Certificados</h3>");
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
        url: "/site/buscar-provincias",
        data: {pais: nombrePais},
        type: "POST",
        dataType: "json"
    })
            .done(function (data) {
//                console.log(data);
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
        url: "/site/buscar-localidades",
        data: {provincia: nombreProvincia},
        type: "POST",
        dataType: "json"
    })
            .done(function (data) {
//                console.log(data);
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

//link about us
//$(document).ready(function () {
//    $('.linkAbout').click(function (link) {
//        //impedimos que el cambio de pestaña se active
//        link.preventDefault();
//        //llamamos a la funcion que se encargue de mostrar el formulario
////        alert();
////        abrirContactoModal(($(this).attr('data-id')));
//        buscarDataUser(($(this).attr('data-id')));
//    });
//});

function buscarDataUser(unUsuario) {
    $.ajax('../json/dataContacto.json', {
        dataType: 'json',
        contentType: 'application/json'
    })
            .done(function (response) {
                //buscamos la data del user relacionado
                var datosUsuario = (response.filter(p => p.name === unUsuario));

                //llamamos a la funcion que se encargue de todo xdxdxDxd
                abrirContactoModal(unUsuario, datosUsuario);
            })
            .fail(function () {
                alert("Algo salió tan mal que deprimí");
            });
}
function abrirContactoModal(usuario, datosUsuario) {
    //creamos las opciones que podran salir como display y seleccionamos una al azar
//    var opcionesDisplay = new Array("tabla", "botones", "enlace", "broma"),
    var opcionesDisplay = new Array("tabla", "broma"),
            opcionDisplayRandom = opcionesDisplay[Math.floor(Math.random() * opcionesDisplay.length)];

    alert(opcionDisplayRandom);

    $('#aboutUsModal').modal('show');
    $('#aboutUsModal').find('.modal-title')
            .html(usuario);
    $('#aboutUsModal').find('.modal-body')
            .html(cargarContenidoModalAboutUs(opcionDisplayRandom, datosUsuario));
}

//function cargarContenidoModalAboutUs(opcion, arrayOpcionesContacto, usuario) {
function cargarContenidoModalAboutUs(opcion, arrayContacto) {
    var content = "";

    switch (opcion) {
        case "broma":
            //insertar pero-que-a-pasao.mp3
            content = '<div class="row">';
            content += '<div class="col-12">';
            content += '<p class="text-center text-white"> <strong> ¿Otro error? <strong> </p>';
            content += '<div class="d-flex justify-content-center"> <audio controls controlsList="nodownload">';
//            content += '<source src="../audio/pero-que-a-pasao.ogg" type="audio/ogg">';
            content += '<source src="../audio/pero-que-a-pasao.mp3" type="audio/mpeg">';
            content += 'Your browser does not support the audio element.';
            content += '</audio> </div>';
            content += '</div>';
            content += '</div>';
            break;

            //        case "enlace":
//
//            $.each(arrayContacto[0]['contacto'], function (indice) {
//            content += '<div class="text-white col-md-6 col-sm-12 m-auto">';
////            arrayOpcionesContacto.contacto.forEach(function (indice) {
////                console.log(indice);
////                if (arrayContacto[0]['contacto'][indice].content !== null && arrayContacto[0]['contacto'][indice].content != '') {
////                    content += '<tr> <th scope="col">' + arrayContacto[0]['contacto'][indice].titulo + '</th> <td> ' + arrayContacto[0]['contacto'][indice].content + '</td> </th> </tr>';
//                    content += '<a class="nav-link" href="'+arrayContacto[0]['contacto'][indice].content+'">' + arrayContacto[0]['contacto'][indice].titulo + '</a>';
////                }
//            content += "</div>";
//            });
////            arrayContacto.forEach(function (indice) {
////                content += '<a href="'++'">' + indice + '</a>';
////            });
//
//            break;
//        case "botones":
//break;

        case "tabla":
//            break;
        default: //tabla
            content = '<div class="row">';
            content += '<div class="col-12">';
            content += '<div class="d-flex justify-content-center">';
            content += '<table class="table table-hover col-md-8 col-sm-12"> <tbody class="text-white">';

            $.each(arrayContacto[0]['contacto'], function (indice) {
                content += '<tr> <th scope="col">' + arrayContacto[0]['contacto'][indice].titulo + '</th> <td> ' + arrayContacto[0]['contacto'][indice].content + '</td> </th> </tr>';
            });

            content += "</tbody> </table>";
            content += "</div>";
            content += "</div>";
            content += "</div>";
            break;
    }
    return content;
}

// random order para las cards en about us
var cards = $(".randomcards");
for (var i = 0; i < cards.length; i++) {
    var target = Math.floor(Math.random() * cards.length);
    var target2 = Math.floor(Math.random() * cards.length);
    cards.eq(target).before(cards.eq(target2));
}
var cards = $(".randomcardsProfes");
for (var i = 0; i < cards.length; i++) {
    var target = Math.floor(Math.random() * cards.length);
    var target2 = Math.floor(Math.random() * cards.length);
    cards.eq(target).before(cards.eq(target2));
}

// arrays para descripciones de cada uno (si se quiere) en el about us
$(document).ready(function () {
    var quotesNS = new Array("We aim above the mark to hit the mark.",
            "Ich esse gern Brot mit warmem Käse.",
            "私はビールを飲み、チップを食べるのが好きです。"),
            random = quotesNS[Math.floor(Math.random() * quotesNS.length)];
    $('#descriptionNS').text(random);
});
// arrays para descripciones de cada uno (si se quiere) en el about us
$(document).ready(function () {
    var quotesNS = new Array("Este es el resultado de muchas noches de desvelo.",
            "Este equipo es lo más. ",
            "Programado 100% en modo remoto - casita.",
            "¿Sabes todo el helado que necesité para hacer este proyecto?",
            "Nunca dudes de un grupo de entusiastas.",
            "¡Proyecto exitoso realizado en cuarentena!."),
            random = quotesNS[Math.floor(Math.random() * quotesNS.length)];
    $('#descriptionLM').text(random);
});

$(document).ready(function () {
    var quotesNS = new Array("Si encuentran algún error, yo no fui..",
        //"你在浪费你的时间来翻译这个",
        "Pase días haciendo los formularios dinámicos, espero que les gusten."
        ,"Si estás leyendo esto, espero que tengas un lindo día.",
        "Si nosotros pudimos, todos pueden.",
        //"La persona de al lado tiene olor a pata",
        //"Campeón mundial de borrar archivos en los commits",
        //"No busquen mensajes secretos, porque no los van a encontrar...",
        "Hola persona del futuro, ¿Cómo te va?",
        //"Fire, Walk with me",
        //"Nos esforzamos mucho en hacer la página, no la rompan por favor",
        //"Rompe paga",
        //"Era penal"
        ),
        random = quotesNS[Math.floor( Math.random() * quotesNS.length )];
    $('#descripcionDC').text( random );
});


// arrays para descripciones de cada uno (si se quiere) en el about us
/* Kevin */
$(document).ready(function () {
    var quotesNS = new Array(
            "omae wa mou shindeiru",
            "Mira mamá!!! Aparezco en los créditos :D",
            "¿En cuántos proyectos universitarios ves algo así de genial?",
            "Me miraba 3 o 4 videos en YouTube antes de ponerme a programar (?",
            "Si jugás al League of Legends, agregame: ''Mekuru'' (LAS)"),
            random = quotesNS[Math.floor(Math.random() * quotesNS.length)];
    $('#KevinMekuruTheBassistAndGamer-ahre').text(random);
});

// arrays para descripciones de Yii Modales
$(document).ready(function () {
    var quotesFB = new Array("Yii Modales tiene modales",
            "Me dijeron que era único, pero nunca me validaron",
            "Más allá del bien y del mal.",
            "Smile while it's free :-)",
            "Si no funcionó con un foreach, puede que funcione con dos",
            "Fixer nocturno",
            "Me llama usted, entonces voy. Don Yii Modales es quien yo soy",
            "O sea sí. Pero no.",
//            "100% real no fake, 1 link juntar",
//            "Si los leés, te entretenés xD",
// JAJAJAJAJAJ adoro los mensajes de Felipe XDD       by: Kevin (?
            "Tienes que hacerlo por mi Pipo, por Yii Modales",
            "Cuatro lineas más y termino el código..",
            "OIGA! Estoy tratando de terminar mi código espaguetti.",
            ),
            random = quotesFB[Math.floor(Math.random() * quotesFB.length)];
    $('#descripcionFB').text(random);
});