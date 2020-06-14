/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {
    antiguoRol = null;
    rolSeleccionado = null;

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
    $(document).on('mouseleave', '.permissionName', function () {
        //capturamos la opcion seleccionada
        var option = $(this).find("option:selected");
        //obtenemos el texto de la opcion
        var text = option.text();
        //asignamos el texto como valor de option
        option.val(text).change();
    });

    $('.buttonRol').ready(function () {
//        var activo = ($(".nav-link").hasClass('active'));
        var algo = ($('.buttonRol').data('id'));
//        console.log(activo);
        console.log(algo);

//        removeClass('active');
//        console.log(algo4);
    });



    $(document).on('click', '.buttonRol', function () {

        //controlamos que no haya nada en el div (el div está vacío
//            if ($.trim($('#dataContainer').text()).length === 0) {

        rolSeleccionado = $(this).data('id');
        if (antiguoRol !== rolSeleccionado) {

            $('#dataContainer').removeClass('invisible');

            //quita de la vista el rol correspondiente
            $('#' + antiguoRol).removeClass('invisible');
            $('#' + rolSeleccionado).addClass('invisible');
            antiguoRol = rolSeleccionado;
            
            cargarBotonera(rolSeleccionado);
        }
    });

    $(document).on('click', '.addPermiso, .removePermiso', function () {
        var permisoSeleccionado = $(this).data('id');
        console.log(permisoSeleccionado);
        agregarPermiso(permisoSeleccionado, rolSeleccionado, $(this));
    });

});

function agregarPermiso(nombrePermiso, nombreRol, boton) {
    $.ajax({
        url: "index.php?r=permission-manager%2Fassing-permission",
        data: {search: 'si', unPermiso: nombrePermiso, unRol: nombreRol},
        type: "POST",
        dataType: "json"
    })
            .done(function (data) {
                if (data && data.hasOwnProperty('success')) {
                    if (data.success === "Added") {
                        boton.html('<img src="icons/x-circle.svg" class="filter-red" alt="Quitar" title="Quitar" role="img" width="20" height="20" style="margin-top: -4px 0 0;">');
                    } else {
                        boton.html('<img src="icons/plus-circle.svg" class="filter-green" alt="Agregar" title="Agregar" role="img" width="20" height="20" style="margin-top: -4px 0 0;">');
                    }
                }

//                console.log(data);
            });
}

function cargarBotonera(rolSeleccionado) {
    $.ajax({
        url: "index.php?r=permission-manager%2Fget-permisos-by-rol",
        data: {search: 'si', unRol: rolSeleccionado},
        type: "POST",
        dataType: "json"
    })
            .done(function (data) {
                var html = "";

                //verificamos si tiene asignados roles y deshabilitamos todas sus acciones
                var result = (data.filter(p => p.type === '1'));
                result.forEach(function (permiso, index) {
//                    console.log(permiso);
//no puede ser la misma funcion porque tiene que inhabilitar el boton.
                });
//                console.log(result);

                var allPermissions = $("body").find("tr").map(function () {
                    return $(this).attr("class");
                }).get();

//                console.log(allPermissions);

                allPermissions.forEach(function (permiso, index) {
                    var result2 = (data.filter(p => p.name === permiso));
//                    console.log(result2);
                    //Si el permiso existe el el 
                    if (result2.length !== 0) {
                        html = '<a class="btn btn-sm btn-light removePermiso" data-id="' + permiso + '">';
                        html += '<img src="icons/x-circle.svg" class="filter-red" alt="Quitar" title="Quitar" role="img" width="20" height="20" style="margin-top: -4px 0 0;">';
                    } else {
                        html = '<a class="btn btn-sm btn-light addPermiso" data-id="' + permiso + '">';
                        html += '<img src="icons/plus-circle.svg" class="filter-green" alt="Agregar" title="Agregar" role="img" width="20" height="20" style="margin-top: -4px 0 0;">';
                    }
                    html += '</a>';


                    var button = $('.' + ($.escapeSelector(permiso))).find('.buttonDiv');
                    button.html(html);
                });
            });
}

function restringirRol(dataRol) {

}
