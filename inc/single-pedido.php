<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Oxygen&display=swap" rel="stylesheet">
<?php $meta = get_post_meta( $post->ID );?>
<?php get_header(); 
?>
<button id="btn-back" onclick="location.href='<?php echo home_url(); ?>'" type="button">Volver al inicio</button>
<form action="" id="form-info">
<h4 id="titulo-main" style="margin-bottom: 10px; margin-top: 15%; font-size: 20px;">Pedido#<?php echo $post->ID;?> confirmado! </h4>
  <h5 class="subtitulo">Contacto</h5>
<div id="info-contacto">
  <input type="text" id="nombre" name="nombre" value="Nombre: <?php if(isset($meta['nombre'])) echo $meta['nombre'][0];?>" placeholder="Nombre*" style="width: 295px;" readonly>

  <input type="text" id="apellido" name="apellido" value="Apellido: <?php if(isset($meta['apellido'])) echo $meta['apellido'][0];?>" placeholder="Apellidos*" style="width: 295px;" readonly><br><br>

  <input type="text" id="tel" name="tel" value="Tel: <?php if(isset($meta['tel'])) echo $meta['tel'][0];?>" placeholder="Telefono*" style="width: 400px;" readonly><br>
</div>
<h5 class="subtitulo" >Dirección</h5>
<div id="info-direccion">
  <input type="text" id="direccion" name="direccion" value="Direccion: <?php if(isset($meta['direccion'])) echo $meta['direccion'][0];?>" style="width: 600px;" placeholder="Dirección*" readonly><br><br>

  <input type="text" id="ciudad" name="ciudad" value=" Ciudad: <?php if(isset($meta['ciudad'])) echo $meta['ciudad'][0];?>" placeholder="Ciudad*" style="width: 295px;" readonly>

  <input type="text" id="provincia" name="provincia" value="Provincia: <?php if(isset($meta['provincia'])) echo $meta['provincia'][0];?>" placeholder="Provincia*" style="width: 295px;" readonly><br><br>

  <input type="text" id="codpostal" name="codpostal" value="Codpostal: <?php if(isset($meta['codpostal'])) echo $meta['codpostal'][0];?>" placeholder="Código Postal*" style="width: 295px;" readonly>

  <input type="text" id="pais" name="pais" value="Pais: <?php if(isset($meta['pais'])) echo $meta['pais'][0];?>" placeholder="Pais*" style="width: 295px;" readonly><br><br>

  <input type="text" id="otros" name="otros" value="" placeholder="Otra información" style="width: 600px; height: 60px;" readonly>
</div>
<h5 class="subtitulo">Tipo de Pago</h5>
<div id="info-pago">
<h4><?php if(isset($meta['pago'])) echo $meta['pago'][0];?></h4><br>
</div>
</form>
<div class="resumen">
<div class="mycarrito">
<h4 style="margin-bottom: 35px; margin-top: -10px; font-size: 20px;">Resumen</h4>
<?php 
     foreach($meta as $key => $value) {
      if(substr( $key, 0, 4 ) === "prod"){
      echo '<div class="div-producto">';
        echo '<div class="titulo-precio">'; ?>
        <h5 class="titulo" style="font-size: 15px;"><?php echo $value[0]; ?></h5><?php
         echo '</div>'; 
         echo '</div>'; 
      }
    }
?>
</div>
<div class="subtotal">
  <div class="item" style="margin-bottom: 4%;">
  <h5 style="font-size: 15px;">Subtotal: </h5>
  <h5 style="font-size: 15px;"><?php if(isset($meta['total'])) echo $meta['total'][0];?></h5>
  </div>
  <div class="item">
  <h5 style="font-size: 15px;">Coste de envío: </h5>
  <h6 style="font-size: 14px;">No calculado</h6>
  </div>
  <div class="item" style="margin-top: 6%; font-size: 16px;">
  <h4 >Total</h4>
  <h4 style="font-size: 16px;"><?php echo $meta['total'][0];?> </h4>
  </div>
</div>
</div>
<?php get_footer(); ?>

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
    border-color: transparent;
    border-width: thin;
  border-radius: 18px;
  height: 40px;
  padding-left: 10px;
  background-color: inherit;
  }
  input[type="radio"] {
    border-style: solid;
    border-width: thin;
  }
#pagar {
  border-radius: 18px;
    position:absolute;
    padding: 5px 148px;
    left:69%;
    top: 93%;
}
</style>