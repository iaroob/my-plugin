<?php
/**
 * Plugin Name: My Plugin
 * Plugin URI: 
 * Description: Plugin para WordPress 
 * Version: 1.0
 * Author: Aroob
 **/

require __DIR__ . '/inc/productos-cpt.php';
require __DIR__ . '/inc/pedidos-cpt.php';
require __DIR__ . '/inc/productos-variantes.php';
require __DIR__ . '/inc/productos-metabox.php';
session_start();
function load_product_template($template) {
    global $post;
    if ($post->post_type == "productos"){
        $plugin_path = plugin_dir_path( __FILE__ );
        $template_name = 'inc/single-product.php';
        if($template === get_stylesheet_directory() . '/' . $template_name  || !file_exists($plugin_path . $template_name)) {
                return $template;
         }
         return $plugin_path . $template_name;
    }
    return $template;
}

function load_pedido_template($template) {
  global $post;
  if ($post->post_type == "pedidos"){
      $plugin_path = plugin_dir_path( __FILE__ );
      $template_name = 'inc/single-pedido.php';
      if($template === get_stylesheet_directory() . '/' . $template_name  || !file_exists($plugin_path . $template_name)) {
              return $template;
       }
       return $plugin_path . $template_name;
  }
  return $template;
}

function carrito_template($template) {
  global $post;
  if ($post->post_type == "page" && get_the_title($post->ID) == "Carrito"){
      $plugin_path = plugin_dir_path( __FILE__ );
      $template_name = 'inc/mycarrito.php';
      if($template === get_stylesheet_directory() . '/' . $template_name  || !file_exists($plugin_path . $template_name)) {
              return $template;
       }
       return $plugin_path . $template_name;
  }
  return $template;
}

function pedido_template($template) {
  global $post;
  if ($post->post_type == "page" && get_the_title($post->ID) == "Pedido"){
      $plugin_path = plugin_dir_path( __FILE__ );
      $template_name = 'inc/mypedido.php';
      if($template === get_stylesheet_directory() . '/' . $template_name  || !file_exists($plugin_path . $template_name)) {
              return $template;
       }
       return $plugin_path . $template_name;
  }
  return $template;
}

function registro_template($template) {
  global $post;
  if ($post->post_type == "page" && get_the_title($post->ID) == "Registro"){
      $plugin_path = plugin_dir_path( __FILE__ );
      $template_name = 'inc/myregister.php';
      if($template === get_stylesheet_directory() . '/' . $template_name  || !file_exists($plugin_path . $template_name)) {
              return $template;
       }
       return $plugin_path . $template_name;
  }
  return $template;
}

function micuenta_template($template) {
  global $post;
  if ($post->post_type == "page" && get_the_title($post->ID) == "Mi cuenta"){
      $plugin_path = plugin_dir_path( __FILE__ );
      $template_name = 'inc/myaccount.php';
      if($template === get_stylesheet_directory() . '/' . $template_name  || !file_exists($plugin_path . $template_name)) {
              return $template;
       }
       return $plugin_path . $template_name;
  }
  return $template;
}

function success_template($template) {
  global $post;
  if ($post->post_type == "page" && get_the_title($post->ID) == "Success"){
      $plugin_path = plugin_dir_path( __FILE__ );
      $template_name = 'inc/success.php';
      if($template === get_stylesheet_directory() . '/' . $template_name  || !file_exists($plugin_path . $template_name)) {
              return $template;
       }
       return $plugin_path . $template_name;
  }
  return $template;
}

function login_template($template) {
  global $post;
  if ($post->post_type == "page" && get_the_title($post->ID) == "Login"){
      $plugin_path = plugin_dir_path( __FILE__ );
      $template_name = 'inc/mylogin.php';
      if($template === get_stylesheet_directory() . '/' . $template_name  || !file_exists($plugin_path . $template_name)) {
              return $template;
       }
       return $plugin_path . $template_name;
  }
  return $template;
}

function index_override($template) {
    $plugin_path = plugin_dir_path( __FILE__ );
    $template_name = 'inc/myindex.php';
  if (is_home() || is_front_page()) {
    return $plugin_path . $template_name;
  }
  return $template;
}

function carrito_page(){
  if ( get_page_by_title( 'Carrito' ) == NULL ) {
    $page = array(
      'post_title'    => 'Carrito',
      'post_status'   => 'publish',
      'post_type' => 'page'
       );
     wp_insert_post( $page );  
      }    
}
add_action('init', 'carrito_page'); 

function pedido_page(){
  if (! get_page_by_title('Pedido', OBJECT, 'page')) {
    $page = array(
      'post_title'    => 'Pedido',
      'post_status'   => 'publish',
      'post_type' => 'page'
       );
     wp_insert_post( $page );  
      }    
}
add_action('init', 'pedido_page'); 

function register_page(){
  if (! get_page_by_title('Registro', OBJECT, 'page')) {
    $page = array(
      'post_title'    => 'Registro',
      'post_status'   => 'publish',
      'post_type' => 'page'
       );
     wp_insert_post( $page );  
      }    
}
add_action('init', 'register_page'); 

function micuenta_page(){
  if (! get_page_by_title('Mi cuenta', OBJECT, 'page')) {
    $page = array(
      'post_title'    => 'Mi cuenta',
      'post_status'   => 'publish',
      'post_type' => 'page'
       );
     wp_insert_post( $page );  
      }    
}
add_action('init', 'micuenta_page'); 

function success_page(){
  if (! get_page_by_title('Success', OBJECT, 'page')) {
    $page = array(
      'post_title'    => 'Success',
      'post_status'   => 'publish',
      'post_type' => 'page'
       );
     wp_insert_post( $page );  
      }    
}
add_action('init', 'success_page'); 

function login_page(){
  if (! get_page_by_title('Login', OBJECT, 'page')) {
    $page = array(
      'post_title'    => 'Login',
      'post_status'   => 'publish',
      'post_type' => 'page'
       );
     wp_insert_post( $page );  
      }    
}
add_action('init', 'login_page'); 

add_filter('single_template', 'load_product_template', 20, 1);
add_filter('page_template', 'carrito_template');
add_filter('page_template', 'micuenta_template');
add_filter('page_template', 'login_template');
add_filter('page_template', 'registro_template');
add_filter('page_template', 'success_template');
add_filter('page_template', 'pedido_template');
add_filter('single_template', 'load_pedido_template');
add_filter('template_include', 'index_override');

/** Borrar producto del carrito  **/

function my_script() {
  if ('productos' === get_post_type()){
   wp_enqueue_script('single_script', plugin_dir_url( __FILE__ ).'inc/js/singleprod_script.js', array('jquery'));
   $localize = array(
    'ajaxurl' => admin_url( 'admin-ajax.php' )
);
   wp_localize_script('single_script','single_vars', $localize);
  }
} 
add_action("wp_enqueue_scripts", "my_script");

function index_script() {
  if (is_home() || is_front_page() || get_page_by_title( 'Carrito' ) ){
   wp_enqueue_script('index_script', plugin_dir_url( __FILE__ ).'inc/js/index-script.js', array('jquery'));
   $localize = array(
    'ajaxurl' => admin_url( 'admin-ajax.php' )
);
   wp_localize_script('index_script','index_vars', $localize);
  }
} 
add_action("wp_enqueue_scripts", "index_script");

function  myaccount_script() {
  if (get_page_by_title( 'Mi cuenta' ) ){
   wp_enqueue_script('myaccount_script', plugin_dir_url( __FILE__ ).'inc/js/myaccount-script.js', array('jquery'));
   $localize = array(
    'ajaxurl' => admin_url( 'admin-ajax.php' )
);
   wp_localize_script('myaccount_script','myaccount_vars', $localize);
  }
} 
add_action("wp_enqueue_scripts", "myaccount_script");

function  mypedido_script() {
  if (get_page_by_title( 'Pedido' ) ){
   wp_enqueue_script('mypedido_script', plugin_dir_url( __FILE__ ).'inc/js/mypedido-script.js', array('jquery'));
   $localize = array(
    'ajaxurl' => admin_url( 'admin-ajax.php' )
);
   wp_localize_script('mypedido_script','mypedido_vars', $localize);
  }
} 
add_action("wp_enqueue_scripts", "mypedido_script");

add_action('wp_ajax_remove_from_cart', 'remove_from_cart_callback');
add_action('wp_ajax_nopriv_remove_from_cart', 'remove_from_cart_callback');
function remove_from_cart_callback() {
    $id = $_POST['id_post'];
    unset($_SESSION['prodseleccionado'][$id]);
    $total = 0;
    foreach($_SESSION['prodseleccionado'] as $id=>$cant) {
      $total += $cant[0] * $cant[1];
    }
    echo $total;
    die();
}
add_action('wp_ajax_change_qtty', 'cambio_cant_callback');
add_action('wp_ajax_nopriv_change_qtty', 'cambio_cant_callback');
function cambio_cant_callback() {
    $id = $_POST['id_post'];
    $cant = $_POST['qtty'];
    $_SESSION['prodseleccionado'][$id][0] = $cant;
    $total = 0;
    foreach($_SESSION['prodseleccionado'] as $id=>$cant) {
        $total += $cant[0] * $cant[1];
    }
    echo $total;
    die();
}

add_action('wp_ajax_change_pw', 'cambio_pw_callback');
add_action('wp_ajax_nopriv_change_pw', 'cambio_pw_callback');
function cambio_pw_callback() {
    $pw = $_POST['new_pw'];
    $usuario = $_POST['user'];
    $login= $_POST['login'];
    $userdata['ID'] =  $usuario; 
    $userdata['user_pass'] = $pw;
    wp_update_user( $userdata ); 
    echo "Contraseña cambiada con éxito.";
    die();
}

add_action('wp_ajax_change_dir', 'cambio_dir_callback');
add_action('wp_ajax_nopriv_change_dir', 'cambio_dir_callback');
function cambio_dir_callback() {
    $usuario = $_POST['user'];
    $direccion = $_POST['direccion'];
    $ciudad = $_POST['ciudad'];
    $provincia = $_POST['provincia'];
    $codpostal = $_POST['codpostal'];
    $pais = $_POST['pais'];
    update_user_meta( $usuario, 'direccion', $direccion ); 
    update_user_meta( $usuario, 'ciudad', $ciudad ); 
    update_user_meta( $usuario, 'provincia', $provincia ); 
    update_user_meta($usuario, 'codpostal', $codpostal ); 
    update_user_meta( $usuario, 'pais', $pais ); 
    echo "Dirección cambiada con éxito";
    die();
}

add_action('wp_ajax_order', 'pedido_callback');
add_action('wp_ajax_nopriv_order', 'pedido_callback');
function pedido_callback() {
    $usuario = $_POST['user'];
    $pago = $_POST['pago'];
    $total = $_POST['total'];
    $productosId = $_POST['productosId'];
    $productos = $_POST['productos'];

    $direccion = $_POST['direccion'];
    $ciudad = $_POST['ciudad'];
    $provincia = $_POST['provincia'];
    $codpostal = $_POST['codpostal'];
    $pais = $_POST['pais'];

    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];

    $new_post = array(
      'post_title' => 'Pedido',
      'post_status' => 'publish',
      'post_type' => 'pedidos'
  );
  $pedido_id = wp_insert_post($new_post);

  update_user_meta( $usuario, 'pedido#'.$pedido_id, $pedido_id ); 
  update_post_meta( $pedido_id, 'direccion', $direccion ); 
  update_post_meta( $pedido_id, 'ciudad', $ciudad ); 
  update_post_meta( $pedido_id, 'provincia', $provincia ); 
  update_post_meta( $pedido_id, 'codpostal', $codpostal ); 
  update_post_meta( $pedido_id, 'pais', $pais ); 

  update_post_meta( $pedido_id,  'nombre', $nombre); 
  update_post_meta( $pedido_id,  'apellido', $apellido ); 
  update_post_meta( $pedido_id,  'email', $email ); 
  update_post_meta( $pedido_id,  'tel', $tel ); 

  update_post_meta( $pedido_id, 'total', $total ); 
  update_post_meta( $pedido_id, 'pago', $pago ); 
  foreach($productosId as $id) {
      update_post_meta( $pedido_id, 'id-'.$id, $id ); 
  }
  foreach($productos as $p) {
    update_post_meta( $pedido_id, 'producto-'.$p, $p ); 
    }

  $post_update = array(
    'ID'         => $pedido_id,
    'post_title' => 'Pedido#'.$pedido_id
  );
  wp_update_post( $post_update );
  $pedido_info= get_post( $pedido_id );
  $_SESSION = array();
  update_post_meta( $pedido_id, 'url', $pedido_info->post_name ); 
    echo $pedido_info->post_name;
    die();
}

?>
