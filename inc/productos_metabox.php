<?php

class productos_metabox() {

  public function __construct() {
    add_action('add_meta_boxes', [$this, 'create_meta_box']);
  }

  public function create_meta_box() {
    add_meta_box(	'productos_box_id', 	'Información del producto',
    [$this, 	'productos_metabox_html' ],
    ['post']);
  }

  public function productos_metabox_html() {
    
  }
}

new productos_metabox();
?>