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

});