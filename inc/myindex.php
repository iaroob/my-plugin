<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Oxygen&display=swap" rel="stylesheet">
<?php 
 get_header(); 
 function get_page_id_by_title($title){
  $page = get_page_by_title($title);
  return $page->ID;
  }
  function get_post_id_by_title($title) {
    $mypost = get_page_by_title($title, OBJECT, 'pedidos');
    return $mypost->ID;
  }
 ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php $args = array(
  'post_type'   => 'productos',
  'fields' => 'ids'
);
$productos = get_posts( $args ); 
$array_precios = array();
foreach($productos as $key => $id) {
  $postmeta = get_post_meta( $id);
if ( array_key_exists( 'product_price', $postmeta )) {
  $prec = $postmeta['product_price'][0]; 
 } else {
 $prec = $postmeta['productvar_price'][0];
 }
 $array_precios[] = $prec;
}
sort($array_precios);
$precioIni = $array_precios[0];
$precioFin = $array_precios[array_key_last($array_precios)];
?>
<form action="<?php echo get_permalink($page_id); ?>" method="POST" class="form_style main">
<div class="sidenav">
<h4 style="color: white; opacity: 0.8; margin-left: 35px;">Categorías</h4>
<?php get_the_categories(); ?>
<h4 style="color: white; opacity: 0.8; margin-left: 35px;">Filtros</h4>
<select name="orderby" id="orderby" style="font-size: 14px; width: 110px; opacity: 0.9;">
        <option value="" selected disabled hidden>Selecciona</option>
        <option value="dateDesc" <?php if(isset($_POST['orderby'])) {
          if ($_POST['orderby'] == 'dateDesc') { echo 'selected'; }} ?> >Más reciente</option>
        <option value="dateAsc" <?php if(isset($_POST['orderby'])) {
          if ($_POST['orderby'] == 'dateAsc') { echo 'selected'; }} ?>>Más antiguo</option>
        <option value="precioAsc" <?php if(isset($_POST['orderby'])) {
          if ($_POST['orderby'] == 'precioAsc') { echo 'selected'; }} ?>>Precio ascendente</option>
        <option value="precioDesc" <?php if(isset($_POST['orderby'])) {
          if ($_POST['orderby'] == 'precioDesc') { echo 'selected'; }} ?>>Precio descendente</option>
</select><br>
<div class="rango-precios" style="margin-left: 15px; margin-top: 10px; padding: 10px 0;">
<label for="min-price" class="min-price" >Precio mínimo</label>
<input type="range" id="min-price" value="<?php 
if(isset($_POST['min-price'])) {echo $_POST['min-price']; } else { echo "0";} ?>" 
name="min-price" min="0" max="<?php echo $precioFin;?>"  oninput="this.nextElementSibling.value = this.value">
<output id="min-price-text">
  <?php 
if(isset($_POST['min-price'])) {echo $_POST['min-price']; } else { echo "0";} ?>
</output><br>
<label for="max-price" class="max-price">Precio maximo</label><br>
<input type="range" id="max-price" value="<?php 
if(isset($_POST['max-price'])) {echo $_POST['max-price']; } else { echo $precioFin;} ?>" 
name="max-price" min="0" max="<?php echo $precioFin;?>" oninput="this.nextElementSibling.value = this.value">
<output id="max-price-text">
  <?php 
if(isset($_POST['max-price'])) {echo $_POST['max-price']; } else { echo $precioFin;} ?>
</output>
</div>
<button type="submit" class="submit-btn">Filtrar</button>
</form>
</div>
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
        echo ' <img class="singleImagen" src="'.get_the_post_thumbnail_url($id,array( 25, 25 )).'"alt="" width="75" height="75">';
        echo '</a>';
        echo '<div class="div-title-precio">';
        ?>
        <h5><a style="font-size: 15px; color: black;" href="<?php echo get_permalink($id); ?> "><?php echo get_the_title($id); ?></a></h5>
        <?php
        $subtotal += $cant[1] * $cant[0];
        echo '<h6 style="font-size: 15px;">'.$cant[1] .' €</h6>';
      } else {
        echo '<div class="div-prod" id="div-'.$id.'">';
        echo '<a href="'.get_permalink(wp_get_post_parent_id($id)).'">';
        echo ' <img class="singleImagen" src="'.get_the_post_thumbnail_url($id,array( 25, 25 )).'"alt="" width="75" height="75">';
        echo '</a>';
        echo '<div class="div-title-precio">';
        ?>
        <h5><a style="font-size: 15px; color: black; margin-top: -5%;" href="<?php echo get_permalink(wp_get_post_parent_id($id)); ?> "><?php echo get_the_title(wp_get_post_parent_id($id)); ?></a></h5>
        <?php
        $subtotal += $cant[1] * $cant[0];
        echo '<h6 style="font-size: 15px;">'.$cant[1].' €</h6>';
      }
      echo '</div>';
      echo '<input class="cant-prod"  id="cant-'.$id.'" type="number" min="1" style="width: 60px; height:30px; font-size: 15px;
      border-width: thin; border-radius: 15px; text-align: center; " value="'.$cant[0].'">';
      echo '</div>';
      echo '</div>';
    }
  
  $subtotal = money_format("%!n", $subtotal);
  echo '<h4 style="padding-bottom: 15px" id="stotal">Subtotal:    '. $subtotal . ' €</h4>'; 
// si usuario está logeado, user page; sino login
if ( is_user_logged_in() ) {
  $cuenta = get_permalink(get_page_id_by_title('Mi cuenta'));
  $comprar = get_permalink(get_page_id_by_title('Pedido'));
} else {
  $cuenta = get_permalink(get_page_id_by_title('Login'));
  $comprar = get_permalink(get_page_id_by_title('Login'));
} ?>
  <button id="btn-comprar" onclick="location.href='<?php echo $comprar; ?>'">Realizar compra</button>
<?php 
  echo '<br>';
  echo '<a id="ver-cesta" style="font-weight: bold;" href="'.get_permalink(get_page_id_by_title('Carrito')).'">Ver cesta</a>';
}else {?>
<h4 style="font-size: 15px;" id="carrito-vacio">Carrito vacío</h4>
<?php } ?>
</div>
<? if ( is_user_logged_in() ) { 
    $cuenta = get_permalink(get_page_id_by_title('Mi cuenta'));
  $url = wp_logout_url(home_url());
?> <button id="logout" onclick="location.href='<?php echo $url; ?>'"><i class="fa fa-sign-out" style="font-size:27px" aria-hidden="true"></i></button> 
    <div class="div-botones">
  <button id="ver-cuenta" class="ver-cuenta" onclick="location.href='<?php echo $cuenta; ?>'"><i class="fa fa-user"  aria-hidden="true"></i>Mi perfil</button>
  <?php
    } else {
      $cuenta = get_permalink(get_page_id_by_title('Login'));?>
    <div class="div-botones">
  <button id="ver-cuenta" class="ver-cuenta"  onclick="location.href='<?php echo $cuenta; ?>'"><i class="fa fa-user" aria-hidden="true"></i></button>
  <?php } ?>
  <button id="open-carrito" class="ver-cuenta" >
    <i class="fa fa-shopping-cart" ></i>Ver Carrito</button>
  </div>

<?php 
function get_the_categories( $parent = 0 ) {
    $categories = get_categories( "hide_empty=0&parent=$parent" );
    if ( $categories ) {
        echo '<ul>';
        foreach ( $categories as $cat ) {
            if ( $cat->category_parent == $parent ) { ?>
              <input type="checkbox" class="subcat" name="category_select[]" value="<?php echo $cat->term_id; ?>" 
              <?php if(isset($_POST['category_select'])) {
              if (in_array("$cat->term_id", $_POST['category_select'])) 
              echo "checked='checked'"; 
              } ?>>
      <label for="category_select[]" class="subcattext" style="font-size: 14px;"><?php echo $cat->name; ?></label><br><?php
                get_the_categories( $cat->term_id );
            }
        }
        echo '</ul>';
    }
}

if(! isset($_POST['min-price']) || ! isset($_POST['max-price'])) {
  $meta_query_args = array(
   array(
     'key'     => array('product_price', 'productvar_price'),
     'compare' => 'EXISTS',
     'meta_type' => 'NUMERIC'
   ),
 );
} else {
 $meta_query_args = array(
   'relation' => 'AND', 
  array(
    'key'     => array('product_price', 'productvar_price'),
    'compare' => 'EXISTS',
    'meta_type' => 'NUMERIC'
  ),
    array(
        'key'     => array('product_price', 'productvar_price'),
        'value'   => array( $_POST['min-price'], $_POST['max-price'] ),
        'type'    => 'numeric',
        'compare' => 'BETWEEN',
    ), 
);

if ($_POST['min-price'] > $_POST['max-price']) {
  ?> <script>alert("El precio mínimo debe ser menor que el máximo");</script> <?php
}
}

if (isset($_POST['orderby']) && !isset($_POST['category_select'])) {
  $cat = '';
if ($_POST['orderby']==='dateDesc')  {
  $orderby = 'date';
  $order = 'DESC';
  $m_v_n =  $meta_query_args;

} else if ($_POST['orderby']==='dateAsc') {
  $orderby = 'date';
  $order = 'ASC';
  $m_v_n =  $meta_query_args;

} else if ($_POST['orderby']==='precioAsc') {
    $orderby = 'meta_value_num';
    $order = 'ASC';
    $m_v_n =  $meta_query_args;

} else if ($_POST['orderby']==='precioDesc') {
    $orderby = 'meta_value_num';
    $order = 'DESC';
    $m_v_n =  $meta_query_args;
}
} else if (! isset($_POST['orderby']) && isset($_POST['category_select'])) {
  $orderby = 'date';
  $order = 'DESC';
  $m_v_n = $meta_query_args;
  $cat = $_POST['category_select'];
} else if ( isset($_POST['orderby']) && isset($_POST['category_select'])) {
  $cat = $_POST['category_select'];
  if ($_POST['orderby']==='dateDesc')  {
    $orderby = 'date';
    $order = 'DESC';
    $m_v_n =  $meta_query_args;
  } else if ($_POST['orderby']==='dateAsc') {
    $orderby = 'date';
    $order = 'ASC';
    $m_v_n =  $meta_query_args;
  } else if ($_POST['orderby']==='precioAsc') {
    $orderby = 'meta_value_num';
      $order = 'ASC';
      $m_v_n =  $meta_query_args;
  } else if ($_POST['orderby']==='precioDesc') {
      $orderby = 'meta_value_num';
      $order = 'DESC';
      $m_v_n =  $meta_query_args;
  }
} else {
  $orderby = 'date';
  $order = 'DESC';
  $m_v_n = $meta_query_args;
  $cat = '';
}
$args = array(
  'post_type' => 'productos',
  'post_status' => 'publish',
  'posts_per_page' => 10,
  'orderby'=> $orderby,
  'order'   => $order,
  'meta_query' => $m_v_n,
  'category__in' => $cat
);
$arr_posts = new WP_Query( $args ); ?>
  <?php
if ( $arr_posts->have_posts() ) :
  echo '<table style="margin-top: -10%;">';
  echo '<tr>';
  echo '<th class = "prodtable-field">';
  if (isset($_POST['category_select'])) {
    foreach($_POST['category_select'] as $catID) {
      echo '<h2 style="font-size: 40px;  margin-left: -25%;">' . ucfirst(get_the_category_by_ID($catID)) . '</h2>';
    }
  } else echo '<h3 style="font-size: 40px; margin-left: -25%;">Todos</h3>';
  echo '</th>';
  echo '</tr><tr>';
  $i = 0;
while ( $arr_posts->have_posts() ) :
  echo "<div class='main'>";
  if ($i == 3) {
    echo '</tr><tr>';
    $i = 0;
  }
  $i++;
  echo '<td class = "prodtable-field">';
$arr_posts->the_post();
?> <a href="<?php echo get_permalink(); ?>"> <?php
$pmeta = get_post_meta( $post->ID);
if ( array_key_exists( 'product_price', $pmeta )) {
  $precio = $pmeta['product_price'][0]; 
 } else {
 $precio = $pmeta['productvar_price'][0];
 }
setlocale(LC_MONETARY, 'en_ES');      
if (strpos($precio, ',') !== false) {
  $precio = str_replace(',', '.', $precio);
}
  $precio = money_format("%!n", $precio);
  echo '<h4 style="font-weight: bold; font-size: 17px;">' . get_the_title($post->ID). '</h4>';
    $prec = (float) $precio;
    echo '<h5>' . $precio . ' €</h5>';
    echo '<br>';
    if(has_post_thumbnail()) {
      echo ' <img class="singleImagen" src="'.get_the_post_thumbnail_url($id,array( 25, 25 )).'"alt="" width=230" height="230">';
     }
    echo '<br>';
    if( '' === get_post()->post_content ) {
      echo '<p class="descrip" style="font-size: 13px;">No hay descripción.</p>';
} else {
    echo '<p class="descrip" style="font-size: 13px;">'.get_the_content($post->ID).'</p>';
}
    echo '<br>';
    echo '<button class="ver-prod">Ver producto</button>';
    echo '</td>';
endwhile;endif;
echo '</div>';
wp_reset_postdata();
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
document.getElementById('orderby').value = "<?php if(isset($_POST['orderby'])) echo $_POST['orderby'];?>";
//document.getElementById('category_select').value = "<?php //echo $_POST['category_select'];?>";
$(document).ready(function(){
      $("#open-carrito").click(function(){
        $("#mycarrito").slideToggle();
      });
    });
</script>

<style>
  *{
    font-family: 'Oxygen', sans-serif;  
  }
  .ver-prod {
    display: block; 
    margin: auto;
    padding: 8px 23px;
  }
  #logout {
    position:absolute; 
    top:6%; 
    left:20%;
  }
  #ver-cesta {
    font-size: 14px;
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
    padding: 5px 20px;
    font-size: 15px;
    margin-bottom: 5px;
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
  .fa-shopping-cart, .fa-user {
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
   font-size: 18px;
 }
  #open-carrito {
    border-radius: 15px;
    margin-left: 0.7em;
    font-size: 18px;
  }
 #mycarrito {
   z-index: 100;
  overflow: scroll;
  overflow-x: hidden;
  max-height: 350px;
  max-width: 600px;
  width: 300px;
  padding:50px 25px;
  text-align: center;
  background-color: white;
  position:absolute;
   top: 20%;
   right:2%;
}
  .sidenav {
  height: 100%;
  width: 220px;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: #36454F;
  overflow-x: hidden;
  padding-top: 40px;
}

.sidenav::-webkit-scrollbar {
  width: 15px;      
  background-color: #28303d;    
}

label {
  font-size: 13px;
}

.submit-btn {
font-size: 15px; 
padding: 5px; 
display: block;
margin-top: 15px;
margin-bottom: 15px;
  margin-left: auto;
  margin-right: auto;
  letter-spacing: 1px;
  width: 110px;
}
.sidenav ul {
  padding: 20px 8px 6px 13px;
  text-decoration: none;
  color: #00008B;
  display: block;
}

.sidenav select {
  display: block;
  margin-top: 15px;
  margin-left: auto;
  margin-right: auto;
  padding: 5px;
border-radius: 12px;
font-size: 20px;
}
.sidenav h6 {
  display: block;
  margin-top: 15px;
  margin-left: auto;
  margin-right: auto;
  text-align: center;
}
input[type="range"] {
  width:140px;
  border-radius: 8px;
  height: 7px;
}
input[type=range]::-webkit-slider-thumb {
  background: var(--color, white);
  appearance: none;
  -webkit-appearance: none;
  width: 20px;
  height: 20px;
  border-radius: 20px;
  border: 1px solid white;
  content: var(--thumbNumber);
}
.subcattext {
  cursor:pointer; 
  user-select:none; 
}
input[type='checkbox'] {
        width:17px;
        height:17px;
        font-size: 10px;
    }
    .sidenav label {
      color: white; 
      opacity: 0.8; 
      font-size: 14px; 
  text-align: center;
    }
p {
  font-size: 15px;
}
.prodtable-field {
  float: left; 
  width: 250px; 
  margin: 0 25px 25px 25px; 
  border-collapse: collapse;
  border: none; 
}
table {
  margin-left: 205px;
  padding: 0px 10px;
  float: left;
  position:absolute;
   top: 40%;
}
a {
  text-decoration: none;
}
.form_style {
  margin-left: 205px;
  padding: 0px 10px;
  float: left;
}
#min-price-text, #max-price-text {
  color: white;
  font-size: 13px;
}
</style>
