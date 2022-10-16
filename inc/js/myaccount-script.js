jQuery(document).ready(function(){
 var user_id = $(".perfil").attr('id');
 var email = $("#email-user").val();

  $(".change-pw").click(function(){
    $(".change-pw").remove();
    $('<label>').attr({
      id: "new-pass-label"
  }).appendTo("#div-newpass");

  $('<input>').attr({
    type: 'password',
    id: "newpass",
    name: "newpass",
    placeholder: "introduce la nueva contraseña"
}).appendTo("#div-newpass");

$('<label>').attr({
  id: "confirm-pass-label"
}).appendTo("#div-confirmpass");

$('<input>').attr({
  type: 'password',
  id: "confirmpass",
  name: "confirmpass",
  placeholder: "confirma la nueva contraseña"
}).appendTo("#div-confirmpass");

$('<button>').attr({
  type: 'button',
  id: "btn-pw"
}).appendTo("#ajustes-user");
$("#btn-pw").html("Guardar");

  $("#new-pass-label").append("Nueva");
  $("#confirm-pass-label").append("Confirma");
  });

  $(document).on('click','#btn-pw', function(e){
          if($("#newpass").val().length < 5) {
            $("#newpass").val("");
            $("#confirmpass").val("");
            $("#newpass").attr("placeholder", "Mínimo 5 caracteres");
            $("#confirmpass").attr("placeholder", "Mínimo 5 caracteres");
          } else {
              if($("#confirmpass").val()==$("#newpass").val()) {
                $.ajax({
                  url : myaccount_vars.ajaxurl,
                  type: 'POST',
                  dataType: 'html',
                  data: {
                    action : 'change_pw',
                    new_pw: $("#newpass").val(),
                    user: user_id,
                    login: email
                  },
                  success: function(response){
                    alert(response);
                    $("#new-pass-label").remove();
                    $("#confirm-pass-label").remove();
                    $("#newpass").remove();
                    $("#confirmpass").remove();
                    $("#btn-pw").remove();
                    $('<button>').attr({
                      type: 'button',
                      id: "change-pw",
                      class: "change-pw"
                    }).appendTo("#ajustes-user");
                    $(".change-pw").html("Cambiar contraseña");
                 }
                });
            } else {
              $("#confirmpass").val("");
              $("#confirmpass").attr("placeholder", "La constraseña no coincide");
            }
          }
  });

  $(document).on('click','.nueva-dir', function(e){
      var direccion = $('#direccion').val();
      var ciudad = $('#ciudad').val();
      var provincia = $('#provincia').val();
      var codpostal = $('#codpostal').val();
      var pais = $('#pais').val();
      
      $.ajax({
        url : myaccount_vars.ajaxurl,
        type: 'POST',
        dataType: 'html',
        data: {
          action : 'change_dir',
          user: user_id,
          direccion: direccion,
          ciudad: ciudad,
          provincia: provincia,
          codpostal:  codpostal,
          pais: pais
        },
        success: function(response){
          alert(response);
        }
      });
  });
});