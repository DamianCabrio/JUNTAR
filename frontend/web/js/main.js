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

  //Utilizado para eliminar los caracteres especiales en nombres de provincias (acentos)
  function eliminarDiacriticos(texto) {
    return texto.normalize('NFD').replace(/[\u0300-\u036f]/g, "");
  }

  //input provincia
  if (($('#signupform-pais').val()) == 'Argentina') {
    autocompleteProvincias(eliminarDiacriticos('Argentina'));
  } else {
    $('#signupform-pais').change(function() {
      autocompleteProvincias(eliminarDiacriticos($('#signupform-pais').val()));
    });
  }
  //input localidad
  $('#signupform-provincia').change(function() {
    autocompleteLocalidades(eliminarDiacriticos($('#signupform-provincia').val()));
  });
});

function autocompleteProvincias(paisName) {
  $.ajax({
      url: "index.php?r=site%2Fsearch-provincias&name=" + paisName,
      type: "POST",
      dataType: "json"
    })
    .done(function(data) {
      console.log(data);
      if ($("#signupform-provincia").autocomplete !== undefined) {
        $("#signupform-provincia").autocomplete({
          "autoFill": true,
          "minLength": "2",
          "source": data,
          "select": function(event, ui) {
            $("#signupform-provincia").val(ui.item.id);
          }
        });
      }
    });
}

function autocompleteLocalidades(pronvinceName) {
  $.ajax({
      url: "index.php?r=site%2Fsearch-localidades&name=" + pronvinceName,
      type: "POST",
      dataType: "json"
    })
    .done(function(data) {
      //                    console.log(data);
      if ($("#signupform-localidad").autocomplete !== undefined) {
        $("#signupform-localidad").autocomplete({
          "autoFill": true,
          "minLength": "2",
          "source": data,
          "select": function(event, ui) {
            $("#signupform-localidad").val(ui.item.id);
          }
        });
      }
    });
}
