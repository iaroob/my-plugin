jQuery(document).ready(function(){
  
  $("#pagar").click(function(e){
    e.preventDefault();
    var user_id = $("#info-contacto").attr("class");
    var pago = $("#tarjeta").text();
    var direccion = $('#direccion').val();
    var ciudad = $('#ciudad').val();
    var provincia = $('#provincia').val();
    var codpostal = $('#codpostal').val();
    var pais = $('#pais').val();

    var nombre = $('#nombre').val();
    var apellido = $('#apellido').val();
    var tel = $('#tel').val();
    var email = $('#email').val();
    var contacto = [];
    contacto.push(nombre, apellido, tel, email);

    var preciototal = $('#total-precio').text();
    var productosId = $('.div-producto').map(function() {
      return $(this).attr('id');
    });
    productosId = productosId.toArray();
    // var ids = productosId.toString();
    var productos = $('.titulo').map(function() {
      return $(this).text();
    });
    productos = productos.toArray();
   
    $.ajax({
      url : mypedido_vars.ajaxurl,
      type: 'POST',
      dataType: 'html',
      data: {
        action : 'order',
        user: user_id,
        direccion: direccion,
        ciudad: ciudad,
        provincia: provincia,
        codpostal:  codpostal,
        pais: pais,
        nombre: nombre,
        apellido: apellido,
        tel: tel,
        email: email,
        pago: pago,
        total: preciototal,
        productosId: productosId,
        productos: productos
      },
      success: function(response){
        alert("Pedido realizado con éxito.");
        window.location.href = '/test/?pedidos='+response;
      }
    });

  });
});