/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {

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


    $("#evento-preinscripcion").change(function(){
        respuesta = $("#evento-preinscripcion").val();
        if(respuesta == 0){
            $("#fechaLimite").hide();
            $("#evento-fechalimiteinscripcion").attr("required", false);
        }
        if(respuesta == 1){
            $("#fechaLimite").show();
            $("#evento-fechalimiteinscripcion").attr("required", true);
        }
    });
});