<?php

  function productos_add_metabox() {
    add_meta_box(
        'productos_box_id',             
        'Producto Simple',     
        'productos_metabox_html',  
    );
  }
  function productos_metabox_html( $post ) {
    $valor = get_post_meta( $post->ID, 'valor_metakey', true);

    $atributos = get_terms( array(
      'taxonomy' => 'atributo',
      'hide_empty' => false,
  ) );
      ?>
      <label for="precio-field">Precio</label>
      <input type="text" id="precio_field" name="precio_field"><br><br>
      <label for="codigo-field">Codigo</label>
      <input type="text" id="codigo_field" name="codigo_field"><br><br>
      <label for="atributos-field">Atributo</label> 
      <select name="atributos_field" id="atributos_field" class="postbox">
        <option>--Selecciona--</option>
          <?php
          foreach( $atributos as $atributo) {
            echo '<option value="'.$atributo->slug.'">'.$atributo->name.'</option>';
            selected($valor, $atributo->slug);
          }
          ?>
      </select> <br><br>
      <textarea id="atributos_valores" name="atributos_valores" width="100" placeholder="Introduce valores, separados por '|'" rows="4" cols="50"></textarea>
      <?php
  }

  function productos_save_postdata( $post_id ) {
    if ( array_key_exists( 'precio_field', $_POST ) ) {
        update_post_meta(
            $post_id,
            'valor_metakey',
            $_POST['precio_field']
        );
    }
  /*  if ( array_key_exists( 'codigo_field', $_POST ) ) {
      update_post_meta(
          $post_id,
          'valor_metakey',
          $_POST['codigo_field']
      );
    }
    if ( array_key_exists( 'atributos_field', $_POST ) ) {
     update_post_meta(
        $post_id,
        'valor_metakey',
        $_POST['atributos_field']
     );
   }
   if ( array_key_exists( 'atributos_valores', $_POST ) ) {
      update_post_meta(
        $post_id,
        'valor_metakey',
        $_POST['atributos_valores']
    );
   }*/
}
  
  add_action( 'add_meta_boxes', 'productos_add_metabox');
  add_action( 'save_post', 'productos_save_postdata' );

  function productosvar_add_metabox() {
    add_meta_box(
        'productosvar_box_id',             
        'Producto Variante',     
        'productosvar_metabox_html',  
    );
  }
  function productosvar_metabox_html( $post ) {
    $valor = get_post_meta( $post->ID, 'valor_metakey', true);

    $atributos = get_terms( array(
      'taxonomy' => 'atributo',
      'hide_empty' => false,
  ) );
      ?>
      <label for="preciovar-field">Precio</label>
      <input type="text" id="preciovar_field" name="preciovar_field"><br><br>
      <label for="codigovar-field">Codigo</label>
      <input type="text" id="codigovar_field" name="codigovar_field"><br><br>
      <label for="atributosvar-field">Atributo</label> 
      <select multiple name="atributosvar_field" id="atributosvar_field" class="postbox">
        <option>--Selecciona--</option>
          <?php
          foreach( $atributos as $atributo) {
            echo '<option value="'.$atributo->slug.'">'.$atributo->name.'</option>';
            selected($valor, $atributo->slug);
          }
          ?>
      </select> <br><br>
      <textarea id="atributosvar_valores" name="atributosvar_valores" width="100" placeholder="Separados por '|' y ',' cada atributo" rows="4" cols="50"></textarea>
      <?php
  }

  function productosvar_save_postdata( $post_id ) {
    if ( array_key_exists( 'preciovar_field', $_POST ) ) {
        update_post_meta(
            $post_id,
            'valor_metakey',
            $_POST['preciovar_field']
        );
    }
   /* if ( array_key_exists( 'codigovar_field', $_POST ) ) {
      update_post_meta(
          $post_id,
          'valor_metakey',
          $_POST['codigovar_field']
      );
    }
    if ( array_key_exists( 'atributosvar_field', $_POST ) ) {
     update_post_meta(
        $post_id,
        'valor_metakey',
        $_POST['atributosvar_field']
     );
   }
   if ( array_key_exists( 'atributosvar_valores', $_POST ) ) {
      update_post_meta(
        $post_id,
        'valor_metakey',
        $_POST['atributosvar_valores']
    );
   }*/
}
  
  add_action( 'add_meta_boxes', 'productosvar_add_metabox');
  add_action( 'save_post', 'productosvar_save_postdata' );
?>