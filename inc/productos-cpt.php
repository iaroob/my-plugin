<?php

function productos_custom_post_type() {
    register_post_type('Producto',
        array(
            'labels'=>array(
                'name'=>__('Productos'), 
                'singular_name'=>__('Producto'),
                'add_new'=> __( 'Añadir Nuevo' ),
                'edit_item'=> __( 'Modificar Item'),
                'update_item'=> __( 'Actualizar Item'),
                'search_items'=> __( 'Buscar Item'),
                'view_item' => __('Ver Item'),
                'menu_name' => 'Productos'
            ),
            'menu_position'=>5,
            'public'      => true,
            'has_archive' => true,
            'menu_icon'=>'dashicons-products',
            'hierarchical'=> false,
            'show_in_menu'=> true,
            'show_in_nav_menus'=> true,
            'show_in_admin_bar'=> true,
            'supports'=>array('title', 'editor','excerpt', 'custom-fields','thumbnail','page-attributes'),
            'taxonomies'=> array('category')
        )
    );
}
add_action('init', 'productos_custom_post_type');

/*function productos_tax() {
    register_taxonomy();
}*/

?>