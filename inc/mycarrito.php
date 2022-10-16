<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Oxygen&display=swap" rel="stylesheet">
<?php get_header(); 
function get_page_id_by_title($title){
  $page = get_page_by_title($title);
  return $page->ID;
}
// si usuario está logeado, user page; sino login
if ( is_user_logged_in() ) {
  $cuenta = get_permalink(get_page_id_by_title('Mi cuenta'));
  $comprar = get_permalink(get_page_id_by_title('Pedido'));
  $url = wp_logout_url(home_url());
  ?> <button id="logout" onclick="location.href='<?php echo $url; ?>'"><i class="fa fa-sign-out" style="font-size:22px" aria-hidden="true"></i></button> <?php
} else {
  $cuenta = get_permalink(get_page_id_by_title('Login'));
  $comprar = get_permalink(get_page_id_by_title('Login'));
} ?>
<button id="btn-back" style="font-size: 16px;  padding: 9px 25px;" onclick="history.go(-1);" type="button">Volver atrás</button>
  <button id="ver-cuenta" onclick="location.href='<?php echo $cuenta; ?>'"><i class="fa fa-user" style="font-size:20px; padding-right: 10px;" aria-hidden="true"></i>Mi cuenta</button>  <br><br>
 <div class="mycarrito">
<h2 style="font-size: 40px; padding-bottom: 15px;">Mi carrito</h2>
<div class="carrito-vacio"></div>
<?php 
  if (isset($_SESSION['prodseleccionado'])) {
  $productos = $_SESSION['prodseleccionado']; 
  $subtotal = 0;
    foreach($productos as $id=>$cant) {
      echo '<div class="div-producto">';
      $pm = get_post_meta( $id);
      if ( array_key_exists( 'product_price', $pm )) {
       echo '<div class="div-imagen">';
      echo '<a href="'.get_permalink($id).'">';
      echo ' <img class="singleImagen" src="'.get_the_post_thumbnail_url($id,array( 25, 25 )).'"alt="" width="200" height="200">';
        echo '</a>'; 
        echo '</div>';
        echo '<div class="titulo-precio">';
        echo '<h4>'.$cant[1] .' €</h4>'; ?>
        <h6 class="titulo"><a href="<?php echo get_permalink($id); ?> "><?php echo get_the_title($id); ?></a></h6>
         <?php $subtotal += $cant[1] * $cant[0];
      } else {
        echo '<div class="div-imagen">';
        echo '<a href="'.get_permalink(wp_get_post_parent_id($id)).'">';
        echo ' <img class="singleImagen" src="'.get_the_post_thumbnail_url(wp_get_post_parent_id($id),array( 25, 25 )).'"alt="" width="200" height="200">';
        echo '</a>'; 
        echo '</div>'; 
        echo '<div class="titulo-precio">'; 
        echo '<h4>'.$cant[1].' €</h4>';?>
        <h6 class="titulo"><a href="<?php echo get_permalink(wp_get_post_parent_id($id)); ?> "><?php echo get_the_title(wp_get_post_parent_id($id)); ?></a></h6>
        <?php
        $subtotal += $cant[1] * $cant[0];
      }
      echo '<h6 style="font-size: 18px;">Cantidad: </h6>';
      echo '<input class="cant-prod"  id="cant-'.$id.'" type="number" min="1" style="margin-top: -15px; width: 60px; height:30px; font-size: 15px; border-radius: 15px; text-align: center;
      border-width: thin;" value="'.$cant[0].'">';
      echo '</div>'; 
      echo '<div class="close-div">'; 
      echo '<a id="'.$id.'" class="close-item">&times;</a>';
      echo '</div>';
      echo '</div>'; 
    }
  $subtotal = money_format("%!n", $subtotal);
  echo '<div class="subtotal">';
  echo '<h6 style="font-size: 20px;"><b>Resumen subtotal</b></h6>';
  echo '<h5 style="font-size: 17px;"id="stotal">Subtotal: '.$subtotal.' €</h5><br><br>';
?>
  <button id="btn-comprar" onclick="location.href='<?php echo $comprar; ?>'">Realizar compra</button>
  <?php
  echo '</div>';
} else {
  echo '<h3 class="carrito-vacio">Carrito vacío.</h3>';
}?>
</div> 

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
   $(document).ready( function(){ 
    $(".close-item").click(function(){
      $(this).parents(".div-producto").remove();
    });
  });
</script>
<style>
    *{
    font-family: 'Oxygen', sans-serif;  
  }
  .mycarrito {
      margin-top: 15%;
      margin-left: -5%;
  }
    #logout {
    position:absolute; 
    top:30%; 
    right:25%;
  }
  .carrito-vacio {
    margin-left: 15%;
    font-size: 25px;
  }
   #ver-cuenta {
    border-radius: 15px;
    padding: 9px 25px;
   position: absolute;
   font-size: 18px;
   top: 30%;
   right: 13%;
 }
 #btn-comprar {
   font-size: 18px;
   align-item: center;
    border-radius: 15px;
    padding: 5px 22px;
 }
  .close-div {
    padding-left: 10%;
  }
  .close-item {
    font-size: 24px;
    margin-top: 20%;
}
.close-item:hover {
  color: rgb(209 209 228);
  cursor: pointer;
}
    #btn-back {
    border-radius: 15px;
    position:absolute;
    padding: 5px 20px;
   top: 30%;
   left: 10%;
  }
  .subtotal {
    position:absolute;
   top:40%;
   right:10%;
   width: 250px;
    background-color: white;
    padding: 30px;
  }
  .titulo {
    font-size: 27px;
    margin-bottom: 5px;
    margin-top: 10px;
  }
  a {
    text-decoration: none;
  }
.titulo-precio {
  padding-bottom: 5%;
  display: flex;
  flex-direction: column;
  margin-left: -5%;
}

.div-imagen, h2 {
  margin: 0 10%;
}
.div-producto {
  margin-left: 10%;
  width: 700px;
  padding-top: 30px;
  display: flex;
  border-bottom-style: solid;
    border-bottom-width: thin;
}
</style>