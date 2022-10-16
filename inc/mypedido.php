<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Oxygen&display=swap" rel="stylesheet">
<?php 
$id = get_current_user_id();
$umeta = get_user_meta( $id );
global $current_user;
wp_get_current_user();
$email = $current_user->user_email;
$nombre = $current_user->user_firstname;
$apellido = $current_user->user_lastname;

function get_page_id_by_title($title){
  $page = get_page_by_title($title);
  return $page->ID;
}
?>
<?php get_header(); 
?>
<button id="btn-back" onclick="history.go(-1);" type="button">Volver atrás</button>
<form method="POST" action="<?php echo home_url();?>" id="form-info">
<h4 id="titulo-main" style="margin-bottom: 10px; margin-top: 15%; font-size: 20px;">Información del pedido</h4>
  <h5 class="subtitulo">Contacto</h5>
<div id="info-contacto" class="<?php echo $id; ?>">
  <input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>" placeholder="Nombre*" style="width: 295px;" required>
  <input type="text" id="apellido" name="apellido" value="<?php echo $apellido; ?>" placeholder="Apellidos*" style="width: 295px;" required><br><br>
  <input type="text" id="tel" name="tel" value="" placeholder="Telefono*" style="width: 400px;" required><br><br>
  <input type="email" id="email" name="email" value="<?php echo $email; ?>" placeholder="Email*" style="width: 400px;" required><br>
</div>
<h5 class="subtitulo" >Dirección</h5>
<div id="info-direccion">
  <input type="text" id="direccion" name="direccion" value="<?php  if(isset($umeta['direccion'])) {
      echo $umeta['direccion'][0];} ?>" style="width: 600px;" placeholder="Dirección*" required><br><br>

  <input type="text" id="ciudad" name="ciudad" value="<?php  if(isset($umeta['ciudad'])) {
      echo $umeta['ciudad'][0];} ?>" placeholder="Ciudad*" style="width: 295px;" required>

  <input type="text" id="provincia" name="provincia" value="<?php  if(isset($umeta['provincia'])) {
      echo $umeta['provincia'][0];} ?>" placeholder="Provincia*" style="width: 295px;" required><br><br>

  <input type="text" id="codpostal" name="codpostal" value="<?php  if(isset($umeta['codpostal'])) {
      echo $umeta['codpostal'][0];} ?>" placeholder="Código Postal*" style="width: 295px;" required>

  <input type="text" id="pais" name="pais" value="<?php  if(isset($umeta['pais'])) {
      echo $umeta['pais'][0];} ?>" placeholder="Pais*" style="width: 295px;" required><br><br>

  <input type="text" id="otros" name="otros" value="" placeholder="Otra información" style="width: 600px; height: 60px;">

</div>
<h5 class="subtitulo">Tipo de Pago</h5>
<div id="info-pago">
<label id="tarjeta" for="tarjeta">Pago por transferencia</label><br>
  <input type="radio" name="tarjeta" checked>
</div>
<input type="submit" name="pagar" id="pagar" value="Pagar">
</form>
<div class="resumen">
<div class="mycarrito">
<h4 style="margin-bottom: 30px; margin-top: -10px; font-size: 20px; ">Resumen</h4>
<?php 
  if (isset($_SESSION['prodseleccionado'])) {
  $productos = $_SESSION['prodseleccionado']; 
  $subtotal = 0;
    foreach($productos as $id=>$cant) {
      echo '<div class="div-producto" id="'.$id.'">';
      $pm = get_post_meta( $id);
      if ( array_key_exists( 'product_price', $pm )) {
        echo '<div class="titulo-precio">';
        ?>
        <h5 class="titulo" style="font-size: 15px;"><?php echo $cant[0]. "x " .get_the_title($id); ?></h5><?php
        echo '<h5 style="font-size: 15px;">'.$cant[1] .' €</h5>'; ?>
         <?php $subtotal += $cant[1] * $cant[0];
      } else {; 
        echo '<div class="titulo-precio">'; ?>
        <h5 class="titulo" style="font-size: 15px;"><?php echo  $cant[0]. "x " .get_the_title(wp_get_post_parent_id($id)); ?></h5><?php
        echo '<h5 style="font-size: 15px;">'.$cant[1].' €</h5>';?>
        <?php
        $subtotal += $cant[1] * $cant[0];
      }
      echo '</div>'; 
      echo '</div>'; 
    }
}?>
</div>
<div class="subtotal">
  <div class="item" style="margin-bottom: 4%;">
  <h5 style="font-size: 15px;">Subtotal: </h5>
  <h5 style="font-size: 15px;"><?php $subtotal = money_format("%!n", $subtotal); echo $subtotal; ?> €</h5>
  </div>
  <div class="item">
  <h5 style="font-size: 15px;">Coste de envío: </h5>
  <h6 style="font-size: 14px;">No calculado</h6>
  </div>
  <div class="item" style="margin-top: 6%; font-size: 16px;">
  <h4>Total</h4>
  <h4 id="total-precio" style="font-size: 16px;"><?php echo $subtotal; ?> €</h4>
  </div>
</div>
</div>
<?php get_footer(); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<style>
* {
    font-family: 'Oxygen', sans-serif;
}
      #btn-back {
    border-radius: 15px;
    position:absolute;
    padding: 7px 23px;
   top: 18%;
   left: 8%;
   font-size: 17px;
  }
  .resumen {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }
  .div-producto {
  display: flex;
  flex-direction: row;
  justify-content: space-between; 
  padding-bottom: 5%;
}
  .titulo-precio {
  padding-bottom: 5%;
  display: flex;
  flex-direction: row;
  justify-content: space-between; 
  width: 100%;
}
.item {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
}
.subtotal {
  display: flex;
  flex-direction: column;
  max-height: 250px;
  max-width: 400px;
  width: 350px;
  padding:30px 25px;
  margin-top: 10%;
  text-align: left;
  background-color: white;
  position:absolute;
   top: 40%;
   right:5%;
   background: #F5F5F5;
  background-image: linear-gradient(white, white);
  background-size: 100% 60%;
  background-repeat: no-repeat;
}
  .mycarrito {
   overflow: scroll;
  overflow-x: hidden;
  max-height: 200px;
  max-width: 400px;
  width: 350px;
  padding:40px 25px;
  text-align: center;
  background-color: white;
  position:absolute;
   top: 20%;
   right:5%;
  }

  #form-info {
    margin-left: 2%;
    padding: 20px;
    width: 70%;
    margin-top: -5%;
  }

.subtitulo {
  padding: 10px;
  font-size: 15px; 
  font-weight: bold;
}
  #info-pago, #info-contacto, #info-direccion {
    padding: 20px;
    margin-bottom: 30px;
    border-style: solid;
    border-width: thin;
  border-radius: 12px;
    border-color: rgba(0, 0, 0, 0.3);
    width: 75%;
  }
  input[type="text"], input[type="email"]{
    font-size: 17px;
    width:160px;
    border-style: solid;
    border-width: thin;
  border-radius: 18px;
  height: 40px;
  padding-left: 10px;
  }
  input[type="radio"] {
    border-style: solid;
    border-width: thin;
  }
#pagar {
  font-weight: bold;
    position:absolute;
    font-size: 18px;
    padding: 7px 148px;
    left:69%;
    top: 110vh;
    background-color: #0630b1;
    border-radius: 50px;
    color: white;
    transition: all 300ms ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.20);
    border: none;
}
#pagar:hover {
    background-color: #5d3eff;
    cursor: pointer;
}
</style>