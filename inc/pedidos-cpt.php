<?php

function pedidos_custom_post_type() {
    register_post_type('Pedido',
        array(
            'labels'=>array(
                'name'=>__('Pedidos'), 
                'singular_name'=>__('Pedido'),
                'add_new'=> __( 'Añadir Nuevo' ),
                'edit_item'=> __( 'Modificar Item'),
                'update_item'=> __( 'Actualizar Item'),
                'search_items'=> __( 'Buscar Item'),
                'view_item' => __('Ver Item'),
                'menu_name' => 'Pedidos'
            ),
            'menu_position'=>5,
            'public'      => true,
            'has_archive' => true,
            'menu_icon'=>'dashicons-cart',
            'hierarchical'=> false,
            'show_in_menu'=> true,
            'show_in_nav_menus'=> true,
            'show_in_admin_bar'=> true,
            'supports'=>array('title', 'editor','excerpt', 'custom-fields','thumbnail','page-attributes')
        )
    );
}
add_action('init', 'pedidos_custom_post_type');

/*function pedidos_tax() {
    register_taxonomy();
}*/

?>