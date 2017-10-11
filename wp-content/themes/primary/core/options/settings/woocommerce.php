<?php

$this->sections[] = array(
    'title'     => __('WooCommerce', THEME_SLUG),
    'icon'      => 'el-icon-shopping-cart',
    'fields'    => array(

        array(
            'id'        => 'show_menu_cart',
            'type'      => 'button_set',
            'title'     => __('Show Cart in Header Menu?', THEME_SLUG),
            'subtitle'  => __('You can disable it here.', THEME_SLUG),
            'options'   => array(
                1       => '&nbsp;I&nbsp;',
                0       => 'O',
            ),
            'default'   => 1
        ),

        //Product Image Sizes Section
        array(
           'id' => 'section-woo-img-sizes',
           'type' => 'section',
           'subtitle' =>  __('These settings let you choose how many products per row will be displayed on your shop main page and at the related products section. Also here you can set a quantity of related products.', THEME_SLUG),
           'indent' => true
        ),

            array(
                'id'       => 'shop_catalog_image_size',
                'type'     => 'dimensions',
                'units'    => false,
                'title'    => __('Catalog Images', THEME_SLUG),
                'desc'     => __('Dimensions of catalog images.', THEME_SLUG),
                'default'  => array(
                    'width'   => '270',
                    'height'  => '270'
                ),
            ),

            array(
                'id'       => 'shop_single_image_size',
                'type'     => 'dimensions',
                'units'    => false,
                'title'    => __('Single Product Images', THEME_SLUG),
                'desc'     => __('Dimensions of single product images.', THEME_SLUG),
                'default'  => array(
                    'width'   => '547',
                    'height'  => '547'
                ),
            ),

            array(
                'id'       => 'shop_thumbnail_image_size',
                'type'     => 'dimensions',
                'units'    => false,
                'title'    => __('Product Thumbnails', THEME_SLUG),
                'desc'     => __('Dimensions of product thumbnails.', THEME_SLUG),
                'default'  => array(
                    'width'   => '90',
                    'height'  => '90'
                ),
            ),

        array(
            'id'     => 'section-woo-img-sizes-end',
            'type'   => 'section',
            'indent' => false
        ),

        // Quantity & Columns Section
        array(
           'id' => 'section-woo-qtys',
           'type' => 'section',
           'subtitle' => '<div class="redux_field_th" style="font-size: 14px;color: #333;margin-top: 20px;">'. __('Quantity & Columns', THEME_SLUG) .'</div>' . __('These settings let you choose how many products per row will be displayed on your shop main page and at the related products section. <br />Also here you can set a quantity of related products.', THEME_SLUG),
           'indent' => true
        ),

            array(
                'id'       => 'goods_grid_qty',
                'type'     => 'spinner',
                'title'    => __('Catalog Products Columns', THEME_SLUG),
                'desc'     => __('Products of your main shop catalog will be organized in this number of columns.', THEME_SLUG),
                'default'  => '4',
                'min'      => '1',
                'step'     => '1',
                'max'      => '12',
            ),

            array(
                'id'       => 'related_goods_cols',
                'type'     => 'spinner',
                'title'    => __('Related Products Columns', THEME_SLUG),
                'desc'     => __('Related products will be organized in this number of columns.', THEME_SLUG), // arranged in 4 columns
                'default'  => '4',
                'min'      => '1',
                'step'     => '1',
                'max'      => '12',
            ),

            array(
                'id'       => 'related_goods_qty',
                'type'     => 'spinner',
                'title'    => __('Related Products Quantity', THEME_SLUG),
                'desc'     => __('How many related products to show.', THEME_SLUG),
                'default'  => '4',
                'min'      => '1',
                'step'     => '1',
                'max'      => '12',
            ),

        array(
            'id'     => 'section-woo-qtys-end',
            'type'   => 'section',
            'indent' => false
        ),

    ),
);
