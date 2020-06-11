/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function() {

  $('.showpw .custom-control-input').click(function() {
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
  $(function() {
    $("[data-toggle='popover']").popover({
      trigger: 'hover'
    });
  });

  function eliminarDiacriticos(texto) {
    return texto.normalize('NFD').replace(/[\u0300-\u036f]/g, "");
  }

  $("#signupform-provincia").change(function() {
    var name_province = eliminarDiacriticos($("#signupform-provincia").val());
    $.ajax({
        url: "http://yii.juntar.net:8080/index.php?r=site%2Fsearch-locations&name=" + name_province,
        type: "POST",
        dataType: "json"
      })
      .done(function(data) {
        if ($("#signupform-localidad").autocomplete !== undefined) {
          $("#signupform-localidad").autocomplete({
            "autoFill": true,
            "minLength": "3",
            "source": data,
            "select": function(event, ui) {
              $("#signupform-localidad").val(ui.item.id);
            }
          });
        }
      });
  });
});
