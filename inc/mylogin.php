<?php 
    function redirect($url){
      $string = '<script type="text/javascript">';
      $string .= 'window.location = "' . $url . '"';
      $string .= '</script>';
      echo $string;
    }
        function auto_login( $user ) {
          $username   = $user;
          // log in automatically
          if ( !is_user_logged_in() ) {
              $valid = username_exists($username);
              if ($valid) {
                $user = get_user_by('email', $username);
                $user_id = $user->ID;
                $pw = $_POST['pw'];
                    if ( $user && wp_check_password( $pw, $user->data->user_pass, $user_id ) ) {
                      wp_set_current_user( $user_id );
                      wp_set_auth_cookie( $user_id );
                      do_action( 'wp_login', $user_id );
                      redirect(home_url());
                    } else {
                        ?><script>alert("La contraseña es incorrecta");</script><?php
                    }
              } else {
                ?><script>alert("La cuenta no existe o el email es incorrecto");</script><?php
              }
          }     
        }
        if(isset($_POST['login'])) {
          auto_login( $_POST['email']);
        }
        function get_page_id_by_title($title){
          $page = get_page_by_title($title);
          return $page->ID;
        }
get_header(); 
$cuenta = get_permalink(get_page_id_by_title('Registro')); ?>
<form method="post" name="loginForm" id="loginForm">
    <h4 style="margin-bottom: 5px; ">Iniciar sesión</h4>
        <label class="label" for="email">Email*</label>
        <input type="email" class="item" id="email" name="email" required>
        <label class="label" for="pw">Contraseña*</label>
        <input type="password" class="item" id="pw" name="pw" required><br>
        <input type="submit" name="login" class="item" id="submit"value="Iniciar sesión">
        <a id="register" href="<?php echo $cuenta; ?>">¿No tienes una cuenta? <b>Regístrate</b></a>
        <a class=inicio" style="font-size: 13px; margin-top: 4%; margin-left: 17%;" href="<?php echo home_url(); ?>">Volver al inicio</a>
    </form>
    <div id="white"></div>
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
a {
  color: black;
  font-weight: bold;
  text-decoration: none;
}
a:hover {
  color: #5d3eff;
}
  #white {
    background-color: white; 
    width: 400px;
    height: 420px;
    position: absolute;
    left: 35%;
    z-index: -1;
    bottom: 2%;
    margin-bottom: 70px;
  border-radius: 12px;
  }
    #register {
        font-size: 15px;
        align-item: center;
        position: absolute;
        bottom: 110px;
        left: 570px;
    }
    #submit:hover {
      cursor: pointer;
    }
    .label {
      font-weight: bold;
        font-size: 16px;
        margin-top: 10px;
        margin-bottom: 2px;
        margin-left: 3px;
    }
    .item {
        margin-bottom: 35px;
    }
     #submit {
      padding: 9px 25px;
    border-radius: 15px;
    font-size: 18px;
    width: 250px;
  }
#loginForm {
    display: flex;
    flex-direction: column;
    width: 500px;
    justify-content: center;
    margin-left: 39%;
    margin-top: 10%;

}
div #loginForm {
    position: absolute;
    bottom: 0;
    top: 190px;
    left: 17%;
    right: 0;
    margin: auto;
    margin-bottom: 45px;
}
input[type="email"], input[type="password"] {
    width: 250px;
    border-style: solid;
    border-width: thin;
  border-radius: 10px;
  height: 30px;
  }
</style>