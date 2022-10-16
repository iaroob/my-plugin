<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Oxygen&display=swap" rel="stylesheet">
<?php 
function get_page_id_by_title($title){
   $page = get_page_by_title($title);
   return $page->ID;
}
if ( is_user_logged_in() ) {
    $url = wp_logout_url(home_url());
    global $current_user;
    wp_get_current_user();
    $id = get_current_user_id();
    $email = $current_user->user_email;
    $nombre = $current_user->user_firstname;
    $apellido = $current_user->user_lastname;
    $display_name = $current_user->display_name;
    $password = $current_user->user_pass;
    $umeta = get_user_meta( $id );
}
    ?>
<?php get_header(); ?>
<div class="user-sidebar">
<ul>
  <li><a class="active" href="<?php echo home_url(); ?>"><b>Inicio</b></a></li>
  <li><a href="#ajustes-user">Ajustes</a></li>
  <li><a href="#pedidos">Pedidos</a></li>
  <li><a href="<?php echo get_permalink(get_page_id_by_title('Carrito'));?>">Ver cesta</a></li>
  <li><a href="<?php echo $url; ?>">Cerrar sesión</a></li>
</ul>
</div>

<h2 class="perfil" id="<?php echo $id; ?>">Hola <?php echo $nombre; ?></h2>
<div id="ajustes">
<div id="ajustes-user">
  <h4 class="titulo-main">Ajustes</h4><br>

  <div class="div" id="div-nombres">
  <label for="nombre">Nombre</label>
  <input type="text" name="nombre" id="nombre-user" value="<?php echo $nombre ." ". $apellido;?>" readonly><br>
  </div><br>

  <div class="div" id="div-email">
  <label for="email">Correo</label>
  <input type="email" name="email" id="email-user" value="<?php echo $email;?>" readonly><br>
  </div><br>

  <div class="div" id="div-pass">
  <label for="pw">Contraseña</label>
  <input type="password" name="pw" id="pw-user" value="<?php echo $password;?>" readonly><br>
  </div><br><button class="change-pw" id="change-pw" style="font-size: 15px;  padding: 9px 20px;">Cambiar contraseña</button><br>
  
  <div class="div" id="div-newpass"></div>
  <div class="div" id="div-confirmpass"></div>
</div>

<div id="ajustes-dir">
<h4 class="titulo-main">Mi dirección</h4>
<label for="direccion">Direccion</label>
    <input type="text" name="direccion" id="direccion" value="<?php  if(isset($umeta['direccion'])) {
      echo $umeta['direccion'][0];} ?>" style="width: 400px;">
    <div class="dir-dir">
    <div class="dir-cp">
      <label for="ciudad">Ciudad</label>
    <input type="text" name="ciudad" id="ciudad" value="<?php  if(isset($umeta['ciudad'])) {
      echo $umeta['ciudad'][0];} ?>">
    </div>
    <div class="dir-pais">
    <label for="provincia">Provincia</label>
    <input type="text" name="provincia" id="provincia" value="<?php  if(isset($umeta['provincia'])) {
      echo $umeta['provincia'][0];} ?>">
</div>
</div>
<div class="dir-dir">
<div class="dir-cp">
    <label for="codpostal">C.P.</label>
    <input type="text" name="codpostal" id="codpostal" value="<?php  if(isset($umeta['codpostal'])) {
      echo $umeta['codpostal'][0];} ?>">
</div>
<div class="dir-pais">
    <label for="pais">Pais</label>
    <input type="text" name="cpais" id="pais" value="<?php  if(isset($umeta['pais'])) {
      echo $umeta['pais'][0];} ?>"><br><br>
</div>
    </div>
    <button class="nueva-dir" id="nueva-dir" style="font-size: 16px;  padding: 9px 25px;">Guardar</button><br>

</div>
</div>
<!----------------------------- seccion de pedidos----------------------------------->

  <h3 id="titulo-pedidos" >Historial de pedidos</h3>
  <div id="pedidos"><?php
  foreach($umeta as $key => $value) {
    if(substr( $key, 0, 7 ) === "pedido#"){ 
      echo '<div class="pedido">';
      echo '<h5>ID pedido:   <h5>';
        $pedido = $value[0];
        $pmeta = get_post_meta($pedido);
        $url =  $pmeta['url'][0];
        echo '<a href="/test/?pedidos='.$url.'">'.$key.'</a>';
        echo '<h5>Estado: confirmado<h5>';
        echo '<h5>'.$pmeta['total'][0].'<h5>';
        echo '</div>';
    }}
      ?>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<style>
    *{
    font-family: 'Oxygen', sans-serif;  
  }
  .pedido {
    border-bottom-style: solid;
    border-bottom-width: thin;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    max-width: 700px;
    padding: 15px;
  }
  #titulo-pedidos {
    margin-top: 10%;
    margin-left: 20%;
  }
  #pedidos {
    max-width: 700px;
    border-top-style: solid;
    border-right-style: solid;
    border-left-style: solid;
    border-bottom-style: solid;
    border-bottom-width: 0px;
    border-top-width: thin;
    border-right-width: thin;
    border-left-width: thin;
    margin-left: 20%;
    display: flex;
    flex-direction: column;
  }
.dir-dir {
  display: flex;
  flex-direction: row;
  justify-content: left;
}

  #ajustes{
    display: flex;
    flex-direction: row;
   }
  .titulo-main {
    margin-left: 30%;
    font-size: 20px;
  }
  #newpass, #confirmpass {
    font-size: 13px;
  }
#change-pw, #btn-pw{
  padding: 6px;
  padding-right: 20px;
  padding-left: 20px;
  max-width: 250px;
    border-radius: 13px;
    font-size: 14px;
    margin-left: auto; 
margin-right: 0;
}
#nueva-dir {
  padding: 6px;
  padding-right: 20px;
  padding-left: 20px;
  max-width: 350px;
    border-radius: 13px;
    font-size: 14px;
    margin-left: 20%; 
}
#ajustes-user label {
    display: inline-block;
    width: 300px;
  text-align: right;
  padding-right: 10px;
  }
  #ajustes-dir label {
    display: inline-block;
    width: 300px;
  text-align: left;
  }
  #ajustes-dir input {
    display: inline-block;
  text-align: left;
  margin-bottom: 5px;
  }
  .div {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
  }
  #ajustes-user{
    max-width: 450px;
    margin-left: 10%;
    margin-top: 10%;
    display: flex;
    flex-direction: column;
  }
  #ajustes-dir {
    margin-top: 10%;
    width: 400px;
    max-width: 450px;
    margin-left: 10%;
    display: flex;
    flex-direction: column;
  }
.perfil {
  margin-left: 20%;
  margin-top: -10%;
}
input[type="text"],  input[type="email"], input[type="password"]{
    width:250px;
    padding-left: 10px;
    font-size: 15px;
    border-style: solid;
    border-width: thin;
  border-radius: 12px;
  height: 35px;
  }
ul {
  list-style-type: none;
  height: 100%;
  margin-top: -1%;
  width: 210px;
  position: fixed;
  font-size: 18px;
  z-index: 100;
  top: 0;
  left: 0;
  background-color: #36454F;
  overflow-x: hidden;
  padding-top: 60px;

}

li a {
  display: block;
  color: #000;
  padding: 8px;
  text-decoration: none;
  margin-left: -6%;
}

li a.active {
  color: white;
}

li a:hover:not(.active) {
  background-color: #f9f9f9;
  color: black;
  font-weight: bold; 
}
</style>