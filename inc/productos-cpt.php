<?php

function productos_cpt() {

	$labels = array(
		'name'                  => _x( 'Productos', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Producto', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Productos', 'text_domain' ),
		'name_admin_bar'        => __( 'Productos', 'text_domain' ),
		'archives'              => __( 'Archivos de items', 'text_domain' ),
		'attributes'            => __( 'Atributos de items', 'text_domain' ),
		'parent_item_colon'     => __( 'Producto', 'text_domain' ),
		'all_items'             => __( 'Todos los items', 'text_domain' ),
		'add_new_item'          => __( 'Añadir nuevo item', 'text_domain' ),
		'add_new'               => __( 'Añadir nuevo', 'text_domain' ),
		'new_item'              => __( 'Nuevo item', 'text_domain' ),
		'edit_item'             => __( 'Modificar item', 'text_domain' ),
		'update_item'           => __( 'Actualizar item', 'text_domain' ),
		'view_item'             => __( 'Ver item', 'text_domain' ),
		'view_items'            => __( 'Ver items', 'text_domain' ),
		'search_items'          => __( 'Buscar item', 'text_domain' ),
		'not_found'             => __( 'No encontrado', 'text_domain' ),
		'not_found_in_trash'    => __( 'No encontrado en papelera', 'text_domain' ),
		'featured_image'        => __( 'Imagen destacada', 'text_domain' ),
		'set_featured_image'    => __( 'Establecer imagen destacada', 'text_domain' ),
		'remove_featured_image' => __( 'Quitar imagen destacada', 'text_domain' ),
		'use_featured_image'    => __( 'Utilizar como imagen destacada', 'text_domain' ),
		'insert_into_item'      => __( 'Insertar en item', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Publicada a este item', 'text_domain' ),
		'items_list'            => __( 'Lista de items', 'text_domain' ),
		'items_list_navigation' => __( 'Lista de navegación de items', 'text_domain' ),
		'filter_items_list'     => __( 'Filtrar lista de items', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'Producto', 'text_domain' ),
		'description'           => __( 'Los productos', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'comments', 'revisions', 'custom-fields', 'page-attributes' ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-products',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'productos', $args );

}
add_action( 'init', 'productos_cpt', 0 );

/*function productos_tax() {
    register_taxonomy();
}*/

?>