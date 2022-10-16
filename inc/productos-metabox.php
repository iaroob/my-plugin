<?php
  function productos_add_metabox() {
    add_meta_box(
        'productos_box_id',             
        'Producto Simple',     
        'productos_metabox_html',  
        ['productos'],
    );
  }

  function productos_metabox_html( $post ) {
  $meta = get_post_meta( $post->ID );
?>
<style>
.product-table {
    border-collapse: collapse;
    border: none;
  }
  .prodtable-field {
    border-collapse: collapse;
    border: none; 
    padding: 0.5em;
  }
  table, th, td {
      border: 1px solid black;
      border-collapse: collapse;
      font-size: 14px;
    }
    td {
      height: 25px;
      text-align:center;
      align-items: center;
    }
    .total-combinaciones {
      color: white;
      border-collapse: collapse;
      border: none;
    }
</style>
      <table class="product-table">
      <tr>
      <td class="prodtable-field"><label for="precio_field">Precio</label></td>
      <td class="prodtable-field"><input type="number" id="precio_field" value="<?php if(isset($meta['product_price'][0])) echo $meta['product_price'][0]; ?>" name="precio_field"></td>
      <td class="prodtable-field"><input type="text" id="nuevo-campo-input" placeholder="nuevo campo"></td>
      <td class="prodtable-field"><button id="btn-nuevo-campo" type="button">Añadir campo</button></td>
    </tr>
      <tr>
      <td class="prodtable-field"><label for="sku_field" >SKU</label></td>
      <td class="prodtable-field"><input type="number" value="<?php if(isset($meta['product_sku'][0])) echo $meta['product_sku'][0]; ?>" id="sku_field" name="sku_field"></td>
    </tr>
    <tr>
      <td class="prodtable-field"><label for="stock_field">Stock</label></td>
      <td class="prodtable-field"><input type="number" id="stock_field" value="<?php if(isset($meta['product_stock'][0])) echo $meta['product_stock'][0]; ?>" name="stock_field"></td>
    </tr>
    <tr>
      <td class="prodtable-field" id="tabla-campos-label"></td>
      <td class="prodtable-field" id="tabla-campos-input"></td>
    </tr>
  </table> 
      <?php 
  }
  function productos_save_postdata( $post_id) {
    $dict_campos = array("product_stock"=>"stock_field", "product_price"=>"precio_field", "product_sku"=>"sku_field");
    foreach($dict_campos as $product_key => $product_field) {
    if ( array_key_exists( $product_field, $_POST ) && strlen( $_POST[$product_field]) > 0) {
        update_post_meta(
            $post_id,
            $product_key,
            $_POST[$product_field],
        );
    }
    
  }
  foreach($_POST as $key => $value) {
    if(substr( $key, 0, 3 ) === "cf-"){
      update_post_meta(
        $post_id,
        "product-".$key,
        $_POST[$key],
    );
    }
  }
}
  function productosvar_add_metabox() {
    add_meta_box(
        'productosvar_box_id',             
        'Producto Variante',     
        'productosvar_metabox_html', 
         ['productos'],
    );
  }
  function productosvar_metabox_html( $post ) {
    $meta = get_post_meta( $post->ID );
    $atributos = get_terms( array(
      'taxonomy' => 'atributo',
      'hide_empty' => false,
  ) );
  $dict_atributos = array();
  foreach( $atributos as $atributo) {
    $dict_atributos['productvar_'.$atributo->slug] = 'campo-'.$atributo->slug;
  }
      ?>
      <table style="border-collapse: collapse; border: none;">
      <tr>
        <td class="prodtable-field"><label for="preciovar-field">Precio</label></td>
        <td class="prodtable-field"><input type="text" id="preciovar_field" value="<?php if(isset($meta['productvar_price'][0])) echo $meta['productvar_price'][0]; ?>" name="preciovar_field"></td>
        <td class="prodtable-field"><input type="text" id="var-nuevo-campo-input" placeholder="nuevo campo"></td>
      <td class="prodtable-field"><button id="var-btn-nuevo-campo" type="button">Añadir campo</button></td>
      </tr>
      <tr>
        <td class="prodtable-field"><label for="stockvar-field">Stock</label></td>
        <td class="prodtable-field"><input type="text" id="stockvar_field" value="<?php if(isset($meta['productvar_stock'][0])) echo $meta['productvar_stock'][0]; ?>" name="stockvar_field"></td>
      </tr>
      <tr>
        <td class="prodtable-field"><label for="skuvar-field">SKU</label></td>
        <td class="prodtable-field"><input type="text" id="skuvar_field" value="<?php if(isset($meta['productvar_sku'][0])) echo $meta['productvar_sku'][0]; ?>" name="skuvar_field"></td>
      </tr>
      <tr>
      <td class="prodtable-field" id="tablavar-campos-label"></td>
      <td class="prodtable-field" id="tablavar-campos-input"></td>
    </tr>
      <tr>
        <td class="prodtable-field"><label for="atributosvar-field">Atributo</label></td>
        <td class="prodtable-field">
        <select name="atributosvar_field" id="atributosvar_field">
        <option>--Selecciona--</option>
          <?php
          foreach( $atributos as $atributo) {
            echo '<option value="'.$atributo->slug.'">'.$atributo->name.'</option>';
            selected($valor, $atributo->slug);
          }
          ?>
      </select>
      <button id="btn1" type="button">Select</button></td>
    </tr>
    </table>
      <div id="respuesta"></div>
      <div id="div-variaciones"></div>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script type="text/javascript">
        var listaAtributos = [];     // array para guardar atributos seleccionados
        var atributosTerms = new Object();   // diccionario para guardar valores por cada atributo
        var nuevosCampos = ["nuevo", "otro"];      // array para guardar nombres de nuevos campos añadidos
        $(document).ready(function(e){
         
          $("#btn-nuevo-campo").click(function(){
            var inputValor = $("#nuevo-campo-input").val();
            nuevosCampos.push(inputValor);
            $("#nuevo-campo-input").val('');
            $('<label>').attr({
          id: "label-"+inputValor
      }).appendTo("#tabla-campos-label");
     
      $("#label-"+inputValor).html(inputValor);

      $('<input>').attr({
          type: 'text',
          id: "cf-"+inputValor,
          name: "cf-"+inputValor
      }).appendTo("#tabla-campos-input");
      $("#tabla-campos-label").append("<br><br>");
      $("#tabla-campos-input").append("<br><br>");
    });

    $("#var-btn-nuevo-campo").click(function(){
            var inputValor = $("#var-nuevo-campo-input").val();
            $("#var-nuevo-campo-input").val('');
            $('<label>').attr({
          id: "varlabel-"+inputValor
      }).appendTo("#tablavar-campos-label");
      $("#varlabel-"+inputValor).html(inputValor);

      $('<input>').attr({
          type: 'text',
          id: "cf-var-"+inputValor,
          name: "cf-var-"+inputValor
      }).appendTo("#tablavar-campos-input");

      $("#tablavar-campos-label").append("<br><br>");
      $("#tablavar-campos-input").append("<br><br>");
    });
        
        $("#btn1").click(function(){
          var atributo = $('#atributosvar_field :selected').text();
          if ( listaAtributos.includes(atributo)) {
            alert("El atributo " + atributo + " ya está añadido"); 
          } else {
            $("#btn-combinar").remove();
            listaAtributos.push(atributo);
            atributosTerms[atributo] = [];            // añadir el atributo seleccionado al dict
          $("#respuesta").append(atributo + " ");

          $('<input>').attr({
          type: 'text',
          id: "campo-"+atributo,
          name: "campo-"+atributo,
          placeholder: 'Separado por ", "'
      }).appendTo("#respuesta");

      $('<button>').attr({
          type: 'button',
          id: "btn-add-"+atributo
      }).appendTo("#respuesta");
      $("#btn-add-"+atributo).html("Guardar");

      $('<button>').attr({
          type: 'button',
          id: "btn-combinar"
      }).appendTo("#respuesta");
      $("#btn-combinar").html("Crear variaciones");

      $("#btn-add-"+atributo).click(function(){           // añadir los términos de atributos
        var inputTerms = $("#campo-"+atributo).val();
        if (inputTerms.length == 0) {
          alert("Introduce términos");
        } else {
          var terms = inputTerms.split(', ');
          atributosTerms[atributo] = terms;
          $("#campo-"+atributo).attr('readonly', true);
        }
      });

      $("#btn-combinar").click(function(){          // crear la tabla de variaciones
        var preparado = true;
        for (var atr of listaAtributos) {
          if ($("#campo-"+atr).val().length == 0) {
            preparado = false;
            alert("Introduce términos para el atributo " + atr);
          } else {
          if (atributosTerms[atr].length == 0) {
            preparado = false;
            alert("Guarda los cambios para crear las variaciones");
          }
        }
        }
        if (preparado) {                          // si todos los campos estan completos y guardados
          var precio = $("#preciovar_field").val();
          var skuInput = $("#skuvar_field").val();
          var sku = parseInt(skuInput); 
          var stock = $("#stockvar_field").val();
          var terms = new Array(listaAtributos.length);  // array 2d con todos los terminos de atributos
          for (var i = 0; i < terms.length; i++) {
            terms[i] = atributosTerms[listaAtributos[i]];
          }

          var combinaciones = combinations(terms);
        $('#div-variaciones').empty();
        var $table = $('<table style="width:80%"/>');
        $table.append('<tr>');
        $table.append('<tr>');
        for (var atr of listaAtributos) {
          $table.append( '<th>' + atr + '</th>' );
        }
        $table.append( '<th>' + 'Precio' + '</th>' );
        $table.append( '<th>' + 'SKU' + '</th>' );
        $table.append( '<th>' + 'Stock' + '</th>' );
        $table.append( '<th>' + 'Imagen' + '</th>' );
         $table.append('</tr>');
        for(let i=0; i<combinaciones.length; i++){       // bucle for para cada producto
          $table.append('<tr>');
          let j = 0;
          for(j=0; j<combinaciones[0].length; j++) {
            $table.append( '<td><input type="text" name="prod-'+i+'-'+j+'" id="prod-'+i+'-'+j+'" value="' +combinaciones[i][j] + '" readonly></td>' );     // combinacion de producto
          }
          $table.append( '<td><input type="number" id="precio-'+i+'-'+j+'" name="precio-'+i+'-'+j+'" value="' + precio + '"></td>' );       // precio
          $table.append( '<td><input type="number" name="sku-'+i+'-'+j+'" id="sku-'+i+'-'+j+'" value="' + sku + '" readonly></td>' );       // sku
          sku += 1;
          $table.append( '<td><input type="number" id="stock-'+i+'-'+j+'" name="stock-'+i+'-'+j+'" value=' + stock + '></td>' );        // stock
          $table.append( '<td><input type="button" class="upload-button" name="'+i+'-'+j+'" value="Selecciona"><br><input id="img-'+i+'-'+j+'" type="text" name="img-'+i+'-'+j+'" /></td>' );        // imagen
          $table.append('</tr>');
        }
        $('#div-variaciones').append($table);
      }
      });

      $("#respuesta").append("<br><br>");
    }
        });
});
        function combinations(arr) {
          if (arr.length === 0) return [[]];
            let res = [], [first, ...rest] = arr;
            let remaining = combinations(rest);
            first.forEach(e => {
                remaining.forEach(smaller => {
                res.push([e].concat(smaller));
              });
            });
          return res;
}
</script>
   <?php
  }
  function productosvar_save_postdata( $post_id ) {
    $dict_varcampos = array("productvar_stock"=>"stockvar_field", "productvar_price"=>"preciovar_field", "productvar_sku"=>"skuvar_field");
    foreach($dict_varcampos as $product_key => $product_field) {
    if ( array_key_exists( $product_field, $_POST ) && strlen( $_POST[$product_field]) > 0) {
        update_post_meta(
            $post_id,
            $product_key,
            $_POST[$product_field],
        );
    }
  }
 $atributos = get_terms( array(
  'taxonomy' => 'atributo',
  'hide_empty' => false,
) );
$dict_atributos = array();
foreach( $atributos as $atributo) {
$dict_atributos['productvar_'.$atributo->slug] = 'campo-'.$atributo->slug;
}
 foreach($dict_atributos as $product_key => $product_field) {
  if ( array_key_exists( $product_field, $_POST ) ) {
      update_term_meta(
          $post_id,
          $product_key,
          $_POST[$product_field],
      );
  }
}
foreach($_POST as $key => $value) {
  if(substr( $key, 0, 7 ) === "cf-var-"){
    update_post_meta(
      $post_id,
      "product-".$key,
      $_POST[$key],
  );
  }
}
}
add_action( 'add_meta_boxes', 'productos_add_metabox');
add_action( 'add_meta_boxes', 'productosvar_add_metabox');
if (!isset($_POST['precio_field']) || trim($_POST['precio_field']) == '') {  // es un producto variante
    add_action( 'save_post', 'productosvar_save_postdata' );
} else {
  add_action( 'save_post', 'productos_save_postdata' );
}
function crear_prod_var($post_id) {
  $totalComb = 0;
  $totalAtributos = 0;
  foreach($_POST as $key => $value) {
    if(substr( $key, 0, 7 ) === "precio-"){
        $totalComb += 1;
    }
  }
  foreach($_POST as $key => $value) {
    if(substr( $key, 0, 5 ) === "campo"){
        $totalAtributos += 1;
    }
  }
  if(!isset($_POST['precio_field']) || trim($_POST['precio_field']) == '') {
    for($i = 0; $i<$totalComb; $i++) {
    $new_post = array(
      'post_title' => 'Producto variante',
      'post_content' => 'Producto variante',
      'post_status' => 'publish',
      'post_type' => 'productosVar',
      'post_parent' => get_the_ID()
  );
  $new_id = wp_insert_post($new_post);
}
  }
 }
 function save_prodvar_data($post_id) {
  $totalAtributos = 0;
  foreach($_POST as $key => $value) {
    if(substr( $key, 0, 5 ) === "campo"){
        $totalAtributos += 1;
    }
  }
  $children = get_children( array('post_parent' =>$post_id ) );
  $meta = get_post_meta( $post_id );
  $numItem = 0;
  foreach ( $children as $children_id => $children ) {
    for($i = 0; $i < $totalAtributos; $i++) {
      if (isset($_POST['prod-'.$numItem.'-'.$i])) {
      update_term_meta(
        $children_id,
        'at-'.$i,
       $_POST['prod-'.$numItem.'-'.$i],
      );
    }
  }
        if (isset($_POST['precio-'.$numItem.'-'.$i])) {
        update_post_meta(
          $children_id,
          'precio-'.$i,
          $_POST['precio-'.$numItem.'-'.$i],
        );
      }
      if (isset($_POST['sku-'.$numItem.'-'.$i])) {
        update_post_meta(
          $children_id,
          'sku-'.$i,
          $_POST['sku-'.$numItem.'-'.$i],
        );
      }
      if (isset($_POST['stock-'.$numItem.'-'.$i])) {
        update_post_meta(
          $children_id,
          'stock-'.$i,
          $_POST['stock-'.$numItem.'-'.$i],
        );
      }
       if (isset($_POST['img-'.$numItem.'-'.$i])) {   /* --------- imagen de cada prodvar ---------*/
        update_post_meta(
          $children_id,
          'img-'.$i,
          $_POST['img-'.$numItem.'-'.$i],
        ); 
        $filename =  $_POST['img-'.$numItem.'-'.$i];
        $filetype = wp_check_filetype( basename( $filename ), null );
        $attachment = array(
            'guid'           => basename( $filename ), 
            'post_mime_type' => $filetype['type'],
            'post_status'    => 'inherit'
        );
        $attach_id = wp_insert_attachment( $attachment, $filename, $children_id );
        require_once( ABSPATH . 'wp-admin/includes/image.php' );
        set_post_thumbnail( $children_id, $attach_id );
      }

        $numItem++;
        foreach($_POST as $key=>$value) {
          if(substr( $key, 0, 7 ) === "cf-var-"){
            update_post_meta(
              $children_id,
              "campo-".$key,
              $value,
          );
          }
        }
     }
 }
 add_action('draft_to_publish', 'crear_prod_var');
 add_action( 'save_post', 'save_prodvar_data' );
 add_action("admin_enqueue_scripts", "metabox_script");
 function metabox_script(){
	wp_enqueue_media();
    wp_register_script('my_upload', plugin_dir_url( __FILE__ ).'/js/metabox.js', array('jquery'), '1', true );
    wp_enqueue_script('my_upload');
}
?>