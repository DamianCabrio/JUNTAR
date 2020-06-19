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

    //funcionalidad editar perfil
    $('.editProfile').click(function (link) {
        //impedimos que el cambio de pestaña se active
        link.preventDefault();
        //llamamos a la funcion que se encargue de mostrar el formulario
        editarPerfilModal($(this).attr('href'), 'Datos de la cuenta');
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
});

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
        var dataHTML = $.parseHTML(data);  //<----try with $.parseHTML().
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

/**
 * Metodo editProfileModal --> El modelo relacionado a la edicion del perfil en un documento html
 * y captura su div para mostrarlo en un modal, para evitar pasear de una pagina a otra
 * 
 * @returns none
 */
function uploadNewProfileImage(url) {
    //hace la petición a la url
    //si para cargar el formulario necesita enviarle data, se envia.
    $.ajax({
        url: url,
//        data: {data: data}
    }).done(function (data) {
        //data recibe la vista que deberia renderizarse al visitar la url
        //hacemos visible el modal
        $('#modalProfile').modal('show');
        //convertimos a html la vista recibida
        var dataHTML = $.parseHTML(data);  //<----try with $.parseHTML().
        //buscamos el div que queremos mostrar en la vista recibida y lo escribimos sobre el cuerpo del modal
        $(dataHTML).find('div.uploadProfileImageForm').each(function () {
//            $('.modal-header').append("Nueva imagen de perfil");
            $('.modal-header').html("<h3> Nueva imagen de perfil </h3>");
            $('.modal-body').html($(this).html());
        });
    });
}

/**
 * Metodo editProfileModal --> El modelo relacionado a la edicion del perfil en un documento html
 * y captura su div para mostrarlo en un modal, para evitar pasear de una pagina a otra
 * 
 * @returns none
 */
function editProfileModal(url) {
    //hace la petición a la url
    //si para cargar el formulario necesita enviarle data, se envia.
    $.ajax({
        url: url
//        data: {data: data}
    }).done(function (data) {
        //data recibe la vista que deberia renderizarse al visitar la url
        //hacemos visible el modal
        console.log(data);
        $('#modalProfile').modal('show');
        //convertimos a html la vista recibida
        var dataHTML = $.parseHTML(data);  //<----try with $.parseHTML().
        //buscamos el div que queremos mostrar en la vista recibida y lo escribimos sobre el cuerpo del modal
        $(dataHTML).find('div.profileForm').each(function () {
            $('.modal-header').html("<h3> Editar Perfil </h3>");
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
        url: "search-localidades",
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
