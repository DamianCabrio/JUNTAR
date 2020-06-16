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

//            $('#dataPermission').removeClass('invisible');
            $('#dataPermission').removeClass('d-none');
            $('#dataPermission').addClass('d-block');

            //quita de la vista el rol correspondiente
            $('#' + antiguoRol).removeClass('invisible');
            $('#' + rolSeleccionado).addClass('invisible');
            antiguoRol = rolSeleccionado;
            cargarBotonera(rolSeleccionado, "click");
        }
    });

    $(document).on('click', '.addPermiso, .removePermiso', function () {
        var permisoSeleccionado = $(this).data('id');
        console.log(permisoSeleccionado);
        var esRol = ($(".addPermiso, .removePermiso").hasClass("esRol") ? true : false);
        agregarPermiso(permisoSeleccionado, rolSeleccionado, $(this), esRol);
    });

});

//function agregarPermiso(nombrePermiso, nombreRol, boton) {
//    $.ajax({
//        url: "index.php?r=permission-manager%2Fassing-permission",
//        data: {search: 'si', unPermiso: nombrePermiso, unRol: nombreRol},
//        type: "POST",
//        dataType: "json"
//    })
//            .done(function (data) {
//                if (data && data.hasOwnProperty('success')) {
//                    if (data.success === "Added") {
//                        boton.html('<img src="icons/x-circle.svg" class="filter-red" alt="Quitar" title="Quitar" role="img" width="20" height="20" style="margin-top: -4px 0 0;">');
//                    } else {
//                        boton.html('<img src="icons/plus-circle.svg" class="filter-green" alt="Agregar" title="Agregar" role="img" width="20" height="20" style="margin-top: -4px 0 0;">');
//                    }
//                }
////                console.log(data);
//            });
//}

function agregarPermiso(nombrePermiso, nombreRol, boton, esRol) {
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

                if (esRol) {
                    cargarBotonera(nombreRol, 'click');
                }
//                console.log(data);
            });
}

function cargarBotonera(rolSeleccionado, click) {
    $.ajax({
        url: "index.php?r=permission-manager%2Fget-permisos-by-rol",
        data: {search: 'si', unRol: rolSeleccionado},
        type: "POST",
        dataType: "json"
    })
            .done(function (data) {
                var html = "";

                var roleMenu = $("#roleDiv").find(".roles").map(function () {
                    return $(this).attr("id");
                }).get();


                if (click === 'click') {
                    var dataRoles = (data.filter(p => p.type === '1'));
                    roleMenu.forEach(function (rol, index) {
                        var rolCoincideConDataroles = (dataRoles.filter(r => r.name === rol));
                        var divActionRol = $('#' + rol).find('.roleActionDiv');
                        if (rolCoincideConDataroles.length !== 0) {
//                            alert(rol);
                            divActionRol.html('<a class="btn btn-sm btn-danger removePermiso esRol" data-id="' + rol + '"> Remover Permisos </a>');
                            cargarBotonera(rol, '');
                        } else {
                            divActionRol.html('<a class="btn btn-sm btn-primary addPermiso esRol" data-id="' + rol + '"> Agregar Permisos </a>');
                        }
//                        alert(rolCoincideConDataroles);
                    });
                }
                //verificamos si tiene asignados roles y deshabilitamos todas sus acciones
//                    dataRoles.forEach(function (permiso, index) {
                //restringimos los permisos que obtiene de otro rol
                //cargamos el boton de accion del rol
//                    });
//                }

                var tablePermissions = $("tbody").find("tr").map(function () {
                    return $(this).attr("class");
                }).get();

                tablePermissions.forEach(function (permiso, index) {
                    //busca si el permiso actual de la tabla existe en el arreglo de permisos del rol
                    var tablaCoincideConPermiso = (data.filter(p => p.name === permiso));
                    //selecciona el div de la acción
                    var action = $('.' + ($.escapeSelector(permiso))).find('.actionDiv');

                    //si la variable click viene del click en el rol
                    if (click === "click") {
                        if (tablaCoincideConPermiso.length !== 0) {
                            //si el permiso existe agrega el boton quitar bajo la clase removePermiso
                            html = '<a class="btn btn-sm btn-light removePermiso" data-id="' + permiso + '">';
                            html += '<img src="icons/x-circle.svg" class="filter-red" alt="Quitar" title="Quitar" role="img" width="20" height="20" style="margin-top: -4px 0 0;">';
                        } else {
                            //si el permiso no existe, agrega el boton agregar bajo la clase addPermiso
                            html = '<a class="btn btn-sm btn-light addPermiso" data-id="' + permiso + '">';
                            html += '<img src="icons/plus-circle.svg" class="filter-green" alt="Agregar" title="Agregar" role="img" width="20" height="20" style="margin-top: -4px 0 0;">';
                        }
                        //cierra tag enlace
                        html += '</a>';
                        //agrega el contenido al div de la accion
                        action.html(html);
                    }

                    //si no viene del click y el permiso actual de la tabla coincide con algun elemento del arreglo recibido
                    if (click === "" && tablaCoincideConPermiso.length !== 0) {
                        //sobreescribe el contenido con rol del cual depende
                        action.html(rolSeleccionado);
//                        }
                    }
                });
            });
}
