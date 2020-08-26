/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {
//    antiguoRol = null;
//    rolSeleccionado = null;
//    page = 1;

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
    });

    //reseteamos el atributo value para que sea registrado con éxito
    $(document).on('mouseout', '.permissionName', function () {
        //capturamos la opcion seleccionada
        var option = $(this).find("option:selected");
//        alert($(this). children("option:selected"). val());
        if (option.val() !== "") {
//            alert(option.val('value'));
//            console.log(option.attr('value'));
            //obtenemos el texto de la opcion
            var text = option.text();
            //asignamos el texto como valor de option
            option.val(text).change();
        }
    });

    //funcionalidad modificar organizador
    $('.popUpModifyOrganizer').click(function (link) {
        //impedimos que el cambio de pestaña se active
        link.preventDefault();
        //llamamos a la funcion que se encargue de mostrar el formulario
        popUpModifyOrganizer($(this).attr('href'), 'Modificar organizador del evento');
    });
    //funcionalidad cambiar contraseña
    $('.popUpChangePassword').click(function (link) {
        //impedimos que el cambio de pestaña se active
        link.preventDefault();
        //llamamos a la funcion que se encargue de mostrar el formulario
        popUpChangePassword($(this).attr('href'), 'Modificar contraseña del usuario');
    });

});

function popUpModifyOrganizer(unaUrl, titulo) {
    //hace la petición a la url
    //si para cargar el formulario necesita enviarle data, se especifica
    $.ajax({
        url: unaUrl
        //        data: {data: data}
    }).done(function (data) {
        $('#modalModifyOrganizer').modal('show')
            .find('.modal-body')
            .html(data);
        $('#modalModifyOrganizer').find('.modal-header')
            .html("<h3> " + titulo + " </h3>");
    });
}

function popUpChangePassword(unaUrl, titulo) {
    //hace la petición a la url
    //si para cargar el formulario necesita enviarle data, se especifica
    $.ajax({
        url: unaUrl
        //        data: {data: data}
    }).done(function (data) {
        $('#modalChangePassword').modal('show')
            .find('.modal-body')
            .html(data);
        $('#modalChangePassword').find('.modal-header')
            .html("<h3> " + titulo + " </h3>");
    });
}