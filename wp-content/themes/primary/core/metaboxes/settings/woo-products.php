<?php
    // WooCommerce PRODUCTS
    $meta_boxes[] = array(
        'id' => THEME_SLUG . '_woo_products_settings',
        'title' => __( THEME_NAME . 'Product Settings', THEME_SLUG ),
        'pages' => array( 'product' ),
        'context' => 'normal',
        'priority' => 'high',
        'autosave' => true,

        'fields' => array(
            // Subtitle
            array(
                'name'  => 'Subtitle:',
                'id'    => THEME_SLUG . "_subtitle",
                'type'  => 'hidden'
            )
        )
    );