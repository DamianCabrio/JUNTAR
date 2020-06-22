/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {
    antiguoRol = null;
    rolSeleccionado = null;
    page = 1;

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

    $(document).on('click', '.buttonRol', function () {
        rolSeleccionado = $(this).data('id');
        if (antiguoRol !== rolSeleccionado) {
            $('#dataPermission').removeClass('d-none');
            $('#dataPermission').addClass('d-block');

            //quita de la vista el rol correspondiente
            $('#' + antiguoRol).removeClass('invisible');
            $('#' + rolSeleccionado).addClass('invisible');
            antiguoRol = rolSeleccionado;
            cargarBotonera(rolSeleccionado, "click");
//            cargarBotonera2(rolSeleccionado, "click", page);
        }
    });

    $(document).on('click', '.pageLink', function () {
//        if (antiguoRol !== rolSeleccionado) {
        cargarBotonera2(rolSeleccionado, 'click', (Number($(this).attr('data-page')) + 1));
//        }
    });

    $(document).on('click', '.addPermiso, .removePermiso', function () {
        var permisoSeleccionado = $(this).data('id');
//        var permisoSeleccionado = $(this).data('key');
        console.log(permisoSeleccionado);
        var esRol = ($(".addPermiso, .removePermiso").hasClass("esRol") ? 'true' : null);
        agregarPermiso(permisoSeleccionado, rolSeleccionado, $(this), esRol);
    });

});

function agregarPermiso(nombrePermiso, nombreRol, boton, esRol) {
    $.ajax({
        url: "index.php?r=permission/asignar-permiso-a-rol",
        data: {search: 'si', unPermiso: nombrePermiso, unRol: nombreRol},
        type: "POST",
        dataType: "json"
    })
            .done(function (data) {
                if (data && data.hasOwnProperty('success')) {
                    if (data.success === "Added") {
                        boton.html('<img src="iconos/x-circle.svg" class="filter-red" alt="Quitar" title="Quitar" role="img" width="20" height="20" style="margin-top: -4px 0 0;">');
                    } else {
                        boton.html('<img src="iconos/plus-circle.svg" class="filter-green" alt="Agregar" title="Agregar" role="img" width="20" height="20" style="margin-top: -4px 0 0;">');
                    }
                }

                if (esRol !== null) {
                    cargarBotonera(nombreRol, 'click');
//                    cargarBotonera(nombreRol, 'click', page);
                }
            });
}

function cargarBotonera(rolSeleccionado, click) {
    $.ajax({
        url: "index.php?r=permission/get-permisos-by-rol",
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
                            divActionRol.html('<a class="btn btn-sm btn-danger removePermiso esRol" data-id="' + rol + '"> Remover Permisos </a>');
                            cargarBotonera(rol, '');
                        } else {
                            divActionRol.html('<a class="btn btn-sm btn-primary addPermiso esRol" data-id="' + rol + '"> Agregar Permisos </a>');
                        }
                    });
                }

                var tablePermissions = $("tbody").find("tr").map(function () {
//                    return $(this).attr("class");
//                    return $(this).attr("data-key");
                    return $(this);
                }).get();

//                    console.log(tablePermissions);
                tablePermissions.forEach(function (permiso, index) {
                    //busca si el permiso actual de la tabla existe en el arreglo de permisos del rol
                    var tablaCoincideConPermiso = (data.filter(p => p.name === permiso.attr("data-key")));
                    //selecciona el div de la acción
//                    var action = $('.' + ($.escapeSelector(permiso))).find('.actionDiv');
                    var action = permiso.find('.actionDiv');
//                    var tablaCoincideConPermiso = (data.filter(p => p.name === permiso));
//                    //selecciona el div de la acción
//                    var action = $('.' + ($.escapeSelector(permiso))).find('.actionDiv');

                    //si la variable click viene del click en el rol
                    if (click === "click") {
                        if (tablaCoincideConPermiso.length !== 0) {
                            //si el permiso existe agrega el boton quitar bajo la clase removePermiso
                            html = '<a class="btn btn-sm btn-light removePermiso" data-id="' + permiso.attr("data-key") + '">';
                            html += '<img src="iconos/x-circle.svg" class="filter-red" alt="Quitar" title="Quitar" role="img" width="20" height="20" style="margin-top: -4px 0 0;">';
                        } else {
                            //si el permiso no existe, agrega el boton agregar bajo la clase addPermiso
                            html = '<a class="btn btn-sm btn-light addPermiso" data-id="' + permiso.attr("data-key") + '">';
                            html += '<img src="iconos/plus-circle.svg" class="filter-green" alt="Agregar" title="Agregar" role="img" width="20" height="20" style="margin-top: -4px 0 0;">';
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

function cargarBotonera2(rolSeleccionado, click, nroPagina) {
//    if (page > 0) {
//        modifyStyle(nroPagina);
//    }
    alert(nroPagina);

//    page = nroPagina;
//    alert(page);
//    var start = ( (nroPagina - 1));
    $.ajax({
        url: "index.php?r=permission/get-permisos-by-rol",
        data: {search: 'si', unRol: rolSeleccionado},
        type: "POST",
        dataType: "json"
    })
            .done(function (data) {
                var html = "";

                var roleMenu = $("#roleDiv").find(".roles").map(function () {
                    return $(this).attr("id");
                }).get();

                var dataRoles = (data.filter(p => p.type === '1'));
                if (dataRoles.length > 0) {
                    roleMenu.forEach(function (rol, index) {
                        verificarPermisosTabla(rol, page);
//                        var rolCoincideConDataroles = (dataRoles.filter(r => r.name === rol));
//                        var divActionRol = $('#' + rol).find('.roleActionDiv');
//                        if (rolCoincideConDataroles.length !== 0) {
//                            divActionRol.html('<a class="btn btn-sm btn-danger removePermiso esRol" data-id="' + rol + '"> Remover Permisos </a>');
//                        } else {
//                            divActionRol.html('<a class="btn btn-sm btn-primary addPermiso esRol" data-id="' + rol + '"> Agregar Permisos </a>');
//                        }
//                        if (rolCoincideConDataroles.length !== 0) {
//                            cargarBotonera2(rol, '', page);
//                        }
                    }
                    );

                }

                var tablePermissions = $("tbody").find("tr").map(function () {
//                    return $(this).attr("data-key");
//                    return $(this).attr("class");C
                    return $(this);
                }).get();

//                console.log(tablePermissions);
                tablePermissions.forEach(function (permiso, index) {
                    //busca si el permiso actual de la tabla existe en el arreglo de permisos del rol
//                    var tablaCoincideConPermiso = (data.filter(p => p.name === permiso));
                    var tablaCoincideConPermiso = (data.filter(p => p.name === permiso.attr("data-key")));
                    //selecciona el div de la acción
                    console.log(rolSeleccionado + ' - ' + tablaCoincideConPermiso);
//                    var action = $('.' + ($.escapeSelector(permiso))).find('.actionDiv');
                    var action = permiso.find('.actionDiv');
//console.log(permiso.attr("data-key"));

                    //si la variable click viene del click en el rol
                    if (click === "click") {
                        if (tablaCoincideConPermiso.length !== 0) {
                            //si el permiso existe agrega el boton quitar bajo la clase removePermiso
                            html = '<a class="btn btn-sm btn-light removePermiso" data-id="' + permiso + '">';
                            html += '<img src="iconos/x-circle.svg" class="filter-red" alt="Quitar" title="Quitar" role="img" width="20" height="20" style="margin-top: -4px 0 0;">';
                        } else {
                            //si el permiso no existe, agrega el boton agregar bajo la clase addPermiso
                            html = '<a class="btn btn-sm btn-light addPermiso" data-id="' + permiso + '">';
                            html += '<img src="iconos/plus-circle.svg" class="filter-green" alt="Agregar" title="Agregar" role="img" width="20" height="20" style="margin-top: -4px 0 0;">';
                        }
                        //cierra tag enlace
                        html += '</a>';
                        //agrega el contenido al div de la accion
                        action.html(html);
                    }

                    //si no viene del click y el permiso actual de la tabla coincide con algun elemento del arreglo recibido
//                    if (click === "" && tablaCoincideConPermiso.length !== 0) {
                    if (click === "") {
                        if (tablaCoincideConPermiso.length !== 0) {
                            //sobreescribe el contenido con rol del cual depende
                            action.html(rolSeleccionado);
                        }
//                        }
                    }
                });

                if (click === 'click') {

                }
            });
}
