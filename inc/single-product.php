<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Oxygen&display=swap" rel="stylesheet">
<?php 
$pmeta = get_post_meta( $post->ID);
 if ( ! array_key_exists( 'product_price', $pmeta)) {
$children = get_children( array('post_parent' =>$post->ID, 'post_type'=>'productosvar' ) );
$precios_child = array();
$imgs_child = array();
$atributos_child = array();
foreach ( $children as $children_id => $children ) {
 $meta = get_post_meta($children_id);
 $at = get_term_meta($children_id);
 foreach($meta as $key=>$value) {
   if(substr( $key, 0, 7 ) === "precio-" ) {
 $precios_child[$children_id] = $value[0];
   }
   if(substr( $key, 0, 4 ) === "img-" ) {
    $imgs_child[$children_id] = $value[0];
      }
 }
 foreach($at as $key=>$value) {
  if(substr( $key, 0, 3 ) === "at-" ) {
   $atributos_child[$children_id][] = $value[0];
  }
}
} 
 }
?>
<?php 
$añadir = true;
if (isset($_POST['submit'])) {
if ( ! array_key_exists( 'product_price', $pmeta )) {
  $selecciones = array();
  foreach($_POST as $key=>$value) {
    if ( (substr( $key, 0, 7 ) === "select-")) {
      $selecciones[] = $value;
    }
  }
  $compra = array();
  foreach($atributos_child as $child=>$ats) {
    if($ats === $selecciones && isset($_POST['cantidad'])) {
      if(isset($_SESSION['prodseleccionado'])) {
        foreach( $_SESSION['prodseleccionado'] as $key => $elem) {
            if($key=== $child) {
              $añadir = false;
            $qtty = $elem[0] + $_POST['cantidad'];
            $compra[] = $qtty;
            $precio = money_format("%!n", $precios_child[$child]);
            $compra[] = $precio;
            $_SESSION['prodseleccionado'][$child] = $compra;
            break;
            } else {
              $añadir = true;
          }
        }
      }
      if($añadir) {
      $compra[] = $_POST['cantidad'];
      $precio = money_format("%!n", $precios_child[$child]);
      $compra[] = $precio;
      $_SESSION['prodseleccionado'][$child] = $compra;
      }
    }
  }
   } else {
    $compra = array();
    if(isset($_SESSION['prodseleccionado'])) {
      foreach( $_SESSION['prodseleccionado'] as $key => $elem) {
          if($key === $post->ID) {
            $añadir = false;
            $qtty = $elem[0] + $_POST['cantidad'];
            $compra[] = $qtty;
            $pm = get_post_meta( $post->ID);
            $precio = money_format("%!n", $pm['product_price'][0]);
            $compra[] = $precio;
            // $_SESSION['prodseleccionado']=array_diff($_SESSION['prodseleccionado'],$compra);
            $_SESSION['prodseleccionado'][$post->ID] = $compra;
          break;
          } else {
            $añadir = true;
          }
      }
    }
    if($añadir) {
    $pm = get_post_meta( $post->ID);
    $precio = money_format("%!n", $pm['product_price'][0]);
    if (isset($_POST['cantidad']) && $_POST['cantidad'] != '' ) {
    $compra[] = $_POST['cantidad'];
    $compra[] = $precio;
      $_SESSION['prodseleccionado'][$post->ID] = $compra;
    }
   }
  }
}
function get_page_id_by_title($title){
  $page = get_page_by_title($title);
  return $page->ID;
}
   ?>
<?php get_header(); ?>

<button id="btn-back" style="font-size: 16px;  padding: 9px 25px;" onclick="location.href='<?php echo home_url(); ?>'" type="button">Volver atrás</button>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php $notValid = array("_edit_last", "_edit_lock", "productvar_stock", "productvar_price", "productvar_sku", "product_stock", "product_sku", "product_price"); 
$tmeta = get_term_meta( $post->ID);?>
<?php // si usuario está logeado, user page; sino login
if ( is_user_logged_in() ) {
  $cuenta = get_permalink(get_page_id_by_title('Mi cuenta'));
  $comprar = get_permalink(get_page_id_by_title('Pedido'));
} else {
  $cuenta = get_permalink(get_page_id_by_title('Login'));
  $comprar = get_permalink(get_page_id_by_title('Login'));
} ?>
<!--------------------------------  div del carrito --------------------------------------------->
<div id="mycarrito" style="display:none">
<h5 id="carrito-titulo">Mi carrito</h5>
<?php  if(isset($_SESSION['prodseleccionado'])){
  $productos = $_SESSION['prodseleccionado'];
  $subtotal = 0;
    foreach($productos as $id=>$cant) {
      echo '<div class="container">';
      echo '<output id="'.$id.'" class="close"name="close><a class="close">&times;</a></output>';
      $pm = get_post_meta( $id);
      if ( array_key_exists( 'product_price', $pm )) {
        echo '<div class="div-prod" id="div-'.$id.'">';
        echo '<a href="'.get_permalink($id).'">';
        echo ' <img class="singleImagen" src="'.get_the_post_thumbnail_url($id).'"alt="" width="35" height="35">';
        echo '</a>';
        echo '<div class="div-title-precio">';
        ?>
      <h5 style="font-size: 15px;"><a href="<?php echo get_permalink($id); ?> "><?php echo get_the_title($id); ?></a></h5>
      <?php
        $subtotal += $cant[1] * $cant[0];
        echo '<h5 style="padding-bottom: 5px;">'.$cant[1] .' €</h5>';
      } else {
        echo '<div class="div-prod" id="div-'.$id.'">';
        echo '<a href="'.get_permalink(wp_get_post_parent_id($id)).'">';
        echo ' <img class="singleImagen" src="'.get_the_post_thumbnail_url(wp_get_post_parent_id($id, array(25,25))).'"alt="" style="width:100px; height:auto;">';
        echo '</a>';
        echo '<div class="div-title-precio">';
        ?>
        <h5 style="font-size: 15px;"><a href="<?php echo get_permalink(wp_get_post_parent_id($id)); ?> "><?php echo get_the_title(wp_get_post_parent_id($id)); ?></a></h5>
        <?php
        $subtotal += $cant[1] * $cant[0];
        echo '<h5 style="padding-bottom: 5px;">'.$cant[1].' €</h5>';
      } 
      echo '</div>';
      echo '<input class="cant-prod" id="cant-'.$id.'" type="number" min="1" style="width: 60px; height:30px; font-size: 15px;
      border-width: thin;" value="'.$cant[0].'">';
      echo '</div>';
      echo '</div>';
    }
    
  
  $subtotal = money_format("%!n", $subtotal);
  echo '<h4 style= id="stotal">Subtotal:    '. $subtotal . ' €</h4>'; 
 ?>
  <button id="btn-comprar" onclick="location.href='<?php echo $comprar; ?>'">Realizar compra</button>
  <?php 
  echo '<br>';
  echo '<a id="ver-cesta" href="'.get_permalink(get_page_id_by_title('Carrito')).'">Ver cesta</a>';
 } else {?>
<h4 id="carrito-vacio">Carrito vacío</h4>
<?php } ?>
</div>
<!-------------------------------- fin div del carrito --------------------------------------------->
<!-------------------------------- div botones --------------------------------------------->
<? if ( is_user_logged_in() ) { 
  $url = wp_logout_url(home_url());
?> <button id="logout" onclick="location.href='<?php echo $url; ?>'"><i class="fa fa-sign-out" style="font-size:27px" aria-hidden="true"></i></button> 
    <div class="div-botones">
  <button id="ver-cuenta" class="ver-cuenta" onclick="location.href='<?php echo $cuenta; ?>'"><i class="fa fa-user"  aria-hidden="true"></i>Mi perfil</button>
  <?php
    } else {?>
    <div class="div-botones">
  <button id="ver-cuenta" class="ver-cuenta"  onclick="location.href='<?php echo $cuenta; ?>'"><i class="fa fa-user" aria-hidden="true"></i></button>
  <?php } ?>
  <button id="open-carrito" class="ver-cuenta" >
    <i class="fa fa-shopping-cart" ></i>Ver Carrito</button>
  </div>
  <!-------------------------------- fin div botones --------------------------------------------->
<?php
while ( have_posts() ) :
    the_post(); ?>
    <table style="border-collapse: collapse; border: none; margin-left: 15%;">
  <tr>
    <td class="prodtable-field">
      <?php  $category_detail=get_the_category($post->ID);
      foreach($category_detail as $cd){
      echo "<span class='categories'>".$cd->cat_name." / </span>";
      }
      echo '<br><br>';
      echo '<h4 style="font-size: 23px; font-weight: bold;">'.get_the_title($post->ID).'</h4>'; 
       if ( array_key_exists( 'product_price', $pmeta )) {
        $precio = $pmeta['product_price'][0]; 
       } else {
       $precio = $pmeta['productvar_price'][0];
       }
      setlocale(LC_MONETARY, 'en_ES');
      $precio = money_format("%!n", $precio);
      echo '<h4 id="precio-id">' . $precio . ' €</h4>';
    ?></td>
    <td class="prodtable-field"></td>
    <td class="prodtable-field"></td>
</tr>
<tr>
    <td class="prodtable-field" id="img-id">
      <!------------------------ slider para fotos--------------------------- -->
    <div class="slideshow-container">

     <div class="mySlides fade"> 
      <img class="imagenslide" src="<?php echo get_the_post_thumbnail_url($post->ID); ?>" alt="">
      </div>

      <?php
       if ( ! array_key_exists( 'product_price', $pmeta )) {
         foreach ($imgs_child as $children_id  => $img ) {
           echo '  <div class="mySlides fade">';?>
          <img class="imagenslide" src="<?php echo $imgs_child[$children_id]; ?>" alt=""> 
          <?php 
           echo '</div>';
         }
       } 
      ?>

    <a class="prev" onclick="plusSlides(-1)">❮</a>
    <a class="next" onclick="plusSlides(1)">❯</a>
    </div>
<!---------------------------------- fin slider fotos -------------------------------->
      <br><br>
    <?php if( '' !== get_post()->post_content ) { 
      echo "<h3>Descripcion</h3> "; 
      echo '<p style="font-size:15px; margin-top: 5px;">'.the_content().'</p>';
      }?><br>
    <?php
    foreach($pmeta as $product_key => $value) {
      if ( (substr( $product_key, 0, 15 ) === "product-cf-var-")) {
        echo '<h4>'.substr( $product_key, 15 ).'</h4><br>';
        echo '<h5>'.$value[0].'</h5><br>';
      } else if ( (substr( $product_key, 0, 11 ) === "product-cf-")) {
        echo '<h4>'.substr( $product_key, 11 ).'</h4><br>';
        echo '<h5>'.$value[0].'</h5><br>';
      }
    }?>
    </td>
    <form  id="form-atributos" action="<?php echo get_permalink($page_id); ?>" method="POST" class="form_style">
      <?php  // si es prod var
      $atributos = array();
      if ( ! array_key_exists( 'product_price', $pmeta )) {
      foreach($tmeta as $product_key => $value) { 
        if( (substr( $product_key, 0, 7 ) === "product") && (! in_array($product_key, $notValid))) { 
          echo '<br>';
          $nombreAtributo = ucfirst(substr( $product_key, 11 ));
          $slug = substr( $product_key, 11 );
          $atributos[] = $slug;
           echo '<td class="prodtable-field atrib" >' . $nombreAtributo . '<br>' ;
           ?>
        <select name=<?php echo "select-".$slug; ?> id=<?php echo "select-".$slug; ?>>
        <option>--Selecciona--</option>
          <?php
          $atValues = explode(', ', $value[0]);
          foreach( $atValues as $atributo) {
            echo '<option value="' . $atributo . '">' . $atributo . '</option>';
            selected($valor, $slug);
          }
          ?>
      </select>
      <?php
      // echo '</td><td class="prodtable-field atrib"></td>';
      // echo '</tr><td class="prodtable-field atrib"></td>';
        }
      }
     } ?>
         <div class="select-cant"><label for="cantidad" style="font-size: 17px;">Selecciona cantidad:</label><br>
  <input type="number" id="cantidad" name="cantidad" min="1" value="1"><br><br>
   <input type="submit" id="add-to-cart" name="submit" value="Añadir al carrito">
   </div>
    </form>
        <br>
        <?php  if ( ! array_key_exists( 'product_price', $pmeta )) {
    echo '<button id="select">Selecciona</button><br><br>'; 
    }?>

   

  </tr> 
</table>

<!----------------------------------------- JS, jquery script --------------------------------->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
  let slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  let i;
  let slides = document.getElementsByClassName("mySlides");
  if (n > slides.length) {slideIndex = 1}    
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";  
  }
  slides[slideIndex-1].style.display = "block";  
}
   $(document).ready( function(){ 
    $(".close").click(function(){
      $(this).closest("div").remove();
    });
    $("#open-carrito").click(function(){
        $("#mycarrito").slideToggle();
      });
  <?php
 if ( ! array_key_exists( 'product_price', $pmeta )) { ?>
    var precios_child = <?php echo json_encode($precios_child); ?>;
    var imgs_child = <?php echo json_encode($imgs_child); ?>;
    var atributos_child = <?php echo json_encode($atributos_child); ?>;
    var atributos = <?php echo json_encode($atributos); ?>;
    console.log(imgs_child);
    $("#select").click(function(){
      var selecciones = new Array();
      for (var i in atributos) {
      var atributoSeleccionado = $('#select-'+atributos[i]+' :selected').text();
      selecciones[i] = atributoSeleccionado;
      }
      for(var i in atributos_child) {
        if(atributos_child[i].sort().join(',')=== selecciones.sort().join(',')){
          var precioConseguido = precios_child[i];
          var idProducto = i;
          if (precioConseguido.includes('.') || precioConseguido.includes(',')) {
            $('#precio-id').text(precioConseguido+ ' €');
            $(".imagenslide").attr("src", imgs_child[idProducto]);
        }  else {
            var precioInt = parseInt(precioConseguido);
            $('#precio-id').text(precioInt.toFixed(2)+ ' €');
            $(".imagenslide").attr("src", imgs_child[idProducto]);
      }
        }
      }
    });
    <?php }?>
  });

 </script>
<!------------------------- JS, jquery script --------------------------------------------------->
<?php
endwhile;
?>

<style>

  *{
    font-family: 'Oxygen', sans-serif;  
  }
  #select {
    padding: 10px 20px;
    font-size: 14px;
  }
  #add-to-cart {
    background-color: #0630b1;
    padding: 10px 20px;
    font-size: 14px;
    font-weight: bold;
    border-radius: 50px;
    color: white;
    transition: all 300ms ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.20);
    border: none;
  }
  #add-to-cart:hover {
    background-color: #5d3eff;
    cursor: pointer;
  }
  .select-cant {
    position: absolute;
    bottom: 260px;
    right: 350px;
  }
  input[type=number] {
    padding: 5px 5px;
    text-align: center;
    margin-top: 5px;
    width: 55px;
border-radius: 12px;
font-size: 15px;
  }
  .atrib {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    margin-left: 20%;
    width: 200px;
  }
/* Slideshow container */
.slideshow-container {
  max-width: 1000px;
  position: relative;
  margin: auto;
}

/* Next & previous buttons */
.prev, .next {
  cursor: pointer;
  position: absolute;
  top: 50%;
  width: auto;
  padding: 16px;
  margin-top: -22px;
  color: white;
  font-weight: bold;
  font-size: 18px;
  transition: 0.6s ease;
  border-radius: 0 3px 3px 0;
  user-select: none;
}

/* Position the "next button" to the right */
.next {
  right: 0;
  border-radius: 3px 0 0 3px;
}

/* On hover, add a black background color with a little bit see-through */
.prev:hover, .next:hover {
  background-color: rgba(0,0,0,0.3);
}


/* Fading animation */
.fade {
  animation-name: fade;
  animation-duration: 1.5s;
}

@keyframes fade {
  from {opacity: .4} 
  to {opacity: 1}
}

select {
padding: 5px;
border-radius: 12px;
font-size: 15px;
}
    #logout {
    position:absolute; 
    top:6%; 
    left:15%;
  }
  .singleImagen, .imagenslide {
    width:  200px;
    height: 200px;
  }
  #ver-cesta:hover {
    color: rgb(209 209 228);
  }
.close {
  cursor: pointer;
  margin-left: 90%;
  margin-top: -25px;
}
.close:hover {
  color: rgb(209 209 228);
}
  a {
    text-decoration: none;
  }
  #btn-comprar {
    border-radius: 15px;
    padding: 5px 22px;
    font-size: 15px;
    margin-bottom: 10px;
  }

  .container {
    display: flex;
    flex-direction: column;
    margin-top: 15px;
    margin-bottom: 15px;
  }
  .div-title-precio {
    margin: 0 15px;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
  }
  .div-prod {
    display: flex;
    justify-content: space-between;
    margin: 10px;
    padding-bottom: 15px;
    border-bottom: solid;
    border-bottom-width: thin;
  }
  .fa-shopping-cart, .fa-user{
  margin-right: 0.7em;
}
#carrito-titulo {
  margin-top: -30px;
  padding-bottom: 15px;
  font-size: 17px;
}

div #carrito-vacio{
  text-align: center;
}

.div-botones {
  position:absolute;
  padding: auto;
   top: 5%;
   right:5%;
}
 #ver-cuenta {
   border-radius: 15px;
 }
 .ver-cuenta {
  font-size: 18px;
  font-weight: bold;
 }
  #open-carrito {
    border-radius: 15px;
  }
 #mycarrito {
   z-index: 100;
  overflow: scroll;
  overflow-x: hidden;
  max-height: 350px;
  width: 300px;
  max-width: 600px;
  padding:50px 25px;
  text-align: center;
  background-color: white;
  position:absolute;
   top: 20%;
   right:5%;
}
.prodtable-field {
  border-collapse: collapse;
  border: none; 
  top: 40%;  
  padding: 0px 10px;
}

table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
  }

  .categories {
    font-size: 17px;
  }

  #btn-back {
    border-radius: 15px;
    position:absolute;
    padding: auto;
   top: 6%;
   left: 22%;
  }
  </style>