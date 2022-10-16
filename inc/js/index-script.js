jQuery(document).ready(function(){
  $(".close").click(function(){
    $(this).closest("div").remove();
  });
  
  if (($("#stotal").text()=='Subtotal:    0.00 €') || ($("#stotal").text()=='Subtotal: 0.00 €')) {
  $( "#btn-comprar" ).remove();
  $(".carrito-vacio").text("Carrito vacio");
  }
  $('.cant-prod').change(function() {
    var changed_product_id = $(this).attr('id'); 
    var changed_product = parseInt(changed_product_id.replace('cant-',''));
    var qtty = $(this).val();
    $.ajax({
      url : index_vars.ajaxurl,
      type: 'POST',
      dataType: 'html',
      data: {
				action : 'change_qtty',
				id_post: changed_product,
        qtty: qtty
			},
      success: function(response){
        $("#stotal").text('Subtotal:    '+response+'.00 €');
     }
    });
   });
  $(document).on('click','.close', function(e){
    var deleted_product = $(this).attr('id');
    $.ajax({
      url : index_vars.ajaxurl,
      type: 'POST',
      dataType: 'html',
      data: {
				action : 'remove_from_cart',
				id_post: deleted_product,
			},
      success: function(response){
        if (response == '0') {
         $("#stotal").text('Subtotal:    0.00 €');
          $( "#btn-comprar" ).remove();
        } else {
          $("#stotal").text('Subtotal:    '+response+'.00 €');
        }
        console.log(response);
     }
    });
  });

  $(document).on('click','.close-item', function(e){
    var deleted_product = $(this).attr('id');
    $.ajax({
      url : index_vars.ajaxurl,
      type: 'POST',
      dataType: 'html',
      data: {
				action : 'remove_from_cart',
				id_post: deleted_product,
			},
      success: function(response){
        if (response == '0') {
         $("#stotal").text('Subtotal: 0.00 €');
          $( "#btn-comprar" ).remove();
          $(".carrito-vacio").text("Carrito vacio");
        } else {
          $("#stotal").text('Subtotal: '+response+'.00 €');
        }
        console.log(response);
     }
    });
  });
});