jQuery(document).ready( function(){
  var test = "test";

  $.ajax({
    type: "POST",
    url: 'productos-metabox.php',
    data: {test: test},
    success: function(response) {
      alert("ok");
    }
  });
});

/*
add_action( 'wp_enqueue_scripts', 'my_scripts' );
add_action( 'admin_enqueue_scripts', 'my_scripts' );

function my_scripts() {
	wp_enqueue_script( 'test', plugins_url( '/ajax-script.js', __FILE__ ), array('jquery'), '1.0', true );
	wp_localize_script('test', 'wp_ajax_tests_vars', array(
    'ajax_url' => admin_url( 'admin-ajax.php' )
));
}
*/