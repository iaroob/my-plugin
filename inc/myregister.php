<?php
    function redirect($url){
      $string = '<script type="text/javascript">';
      $string .= 'window.location = "' . $url . '"';
      $string .= '</script>';
      echo $string;
    }
function get_page_id_by_title($title){
    $page = get_page_by_title($title);
    return $page->ID;
  }
  function auto_login( $user ) {
    $username   = $user;
    if ( !is_user_logged_in() ) {
        $user = get_user_by('email', $username);
        $user_id = $user->ID;
        wp_set_current_user( $user_id );
        wp_set_auth_cookie( $user_id );
        do_action( 'wp_login', $user_id );
    }     
  }
  if(isset($_POST['nombre'])) {
    $nombre = $_POST['nombre'];
 }
 if(isset($_POST['apellido'])) {
   $apellido = $_POST['apellido'];
 }
 if(isset($_POST['email'])) {
   $email = $_POST['email'];
 }
 if(isset($_POST['pw'])) {
   $pw = $_POST['pw'];
 }
 if(isset($_POST['cpw'])) {
   $cpw = $_POST['cpw'];
 }
 if(isset($_POST['crear'])) {
  global $reg_errors;
  registration_validation($nombre, $apellido, $email, $pw, $cpw);
  if ( 1 > count( $reg_errors->get_error_messages() ) ) {
          $user_id = wp_insert_user( array(
            'user_login' => $email,
            'user_pass' => $pw,
            'user_email' => $email,
            'first_name' => $nombre,
            'last_name' => $apellido,
            'display_name' => $nombre
          ));
          auto_login( $_POST['email']);
          redirect(home_url());
    }
}
$cuenta = get_permalink(get_page_id_by_title('Login')); 
get_header(); ?>
<body>
<form method="POST" name="registerForm" id="registerForm" style="  
  padding-bottom: 200px;">
       <h4 style="margin-bottom: 5px;">Registro de usuario</h4>
        <label class="label" for="nombre">Nombre*</label>
        <input type="text" class="item" id="nombre" name="nombre" 
        value="<?php if(isset($_POST['nombre'])) echo $_POST['nombre']; ?>" required>

        <label class="label" for="apellido">Apellidos*</label>
        <input type="text" class="item" id="apellido" name="apellido" 
        value="<?php if(isset($_POST['apellido'])) echo $_POST['apellido']; ?>" required>

        <label class="label" for="email">Email*</label>
        <input type="email" class="item" id="email" name="email" 
        value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" required>

        <label class="label" for="pw">Contraseña*</label>
        <input type="password" class="item" id="pw" name="pw" 
        value="<?php if(isset($_POST['pw'])) echo $_POST['pw']; ?>" required>

        <label class="label" for="pw">Confirma contraseña*</label>
        <input type="password" class="item" id="cpw" name="cpw" 
        value="<?php if(isset($_POST['cpw'])) echo $_POST['cpw']; ?>"required><br>
        
        <input type="submit" name="crear" class="item" id="submit"value="Crear cuenta">
        <a class=inicio" style="font-size: 13px; margin-left: 17%;" href="<?php echo home_url(); ?>">Volver al inicio</a>
    </form>
    <a id="login" href="<?php echo $cuenta; ?>">¿Ya tienes una cuenta? <b>Iniciar sesión</b></a>

    <div id="white"></div>
    </body>
<?php
function registration_validation( $nombre, $apellido, $email, $pw, $cpw)  {
  global $reg_errors;
  $reg_errors = new WP_Error;
  if ( email_exists( $email ) ) {
    $reg_errors->add('emailerror', 'El email introducido ya existe.');
}
if ( 5 > strlen( $pw) ) {
  $reg_errors->add( 'pwlength', 'La contraseña debe tener al menos 5 caracteres.' );
}
if ( $pw !== $cpw ) {
  $reg_errors->add( 'pwmatch', 'Las constraseñas no coinciden.' );
}
if ( is_wp_error( $reg_errors ) ) {
  foreach($reg_errors as $error) {
    foreach($error as $id=>$msg) {
      echo '<span id="'.$id.'">'.$msg[0].'</span>';
    }
  }
}
}
?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Oxygen&display=swap" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<style>
    *{
    font-family: 'Oxygen', sans-serif;  
  }
  #submit {
    background-color: #0630b1;
    padding: 8px 20px;
    border-radius: 50px;
    color: white;
    transition: all 300ms ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.20);
    border: none;
}

#submit:hover {
    background-color: #5d3eff;
    cursor: pointer;
}
  span {
    font-size: 11px;
    color: red;
  }
  #pwlength {
    position: absolute;
    top: 54.5%;
    right: 35%;
  }
  #pwmatch {
    position: absolute;
    top: 64%;
    right: 36.5%;
  }
  #emailerror {
    position: absolute;
    top: 43.5%;
    right: 45%;
  }
      #white {
    background-color: white; 
    width: 430px;
    height: 650px;
    position: absolute;
    left: 33.5%;
    z-index: -1;
    top: 0;
    bottom: 1px;
    margin-top: 60px;
    margin-bottom: 60px;
  border-radius: 12px;
  }
    #login {
        font-size: 15px;
        align-item: center;
        position: absolute;
        left: 40%;
        z-index: 5;
        top: 91%;
    }
    #submit:hover {
      cursor: pointer;
    }
    .label {
        font-size: 16px;
        margin-top: 10px;
        margin-left: 3px;
        font-weight: bold;
    }
    a {
  color: black;
  font-weight: bold;
  text-decoration: none;
}
a:hover {
  color: #5d3eff;
}
    .item {
        margin-bottom: 10px;
    }
     #submit {
    border-radius: 15px;
    font-size: 18px;
    padding: 5px;
    width: 250px;
    padding: 8px 20px;
  }
#registerForm {
    display: flex;
    flex-direction: column;
    width: 500px;
    justify-content: center;
    margin-left: 39%;
    margin-top: 4%;
}
div #registerForm {
    position: absolute;
    top: 190px;
    left: 17%;
    right: 0;
    margin: auto;
    margin-bottom: 45px;
}
input[type="text"], input[type="email"], input[type="password"] {
    width: 250px;
    border-style: solid;
    border-width: thin;
  border-radius: 10px;
  height: 30px;
  }
</style>