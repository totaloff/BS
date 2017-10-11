<?php

$this->sections[] = array(
    'title'     => __('Header', THEME_SLUG),
    'icon'      => 'el-icon-website',
    'fields'    => array(

        array(
            'id'        => 'custom_logo',
            'type'      => 'media',
            'url'       => true,
            'title'     => __('Custom Logo', THEME_SLUG),
            //'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
            'subtitle'  => __('Upload your logo.', THEME_SLUG),
            'default'   => array('url' => get_template_directory_uri() . '/assets/images/logo.png')
        ),

        array(
            'id'        => 'custom_retina_logo',
            'type'      => 'media',
            'url'       => true,
            'title'     => __('Custom Retina Logo', THEME_SLUG),
            //'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
            'subtitle'  => __('Upload your retina logo.', THEME_SLUG),
            'default'   => array('url' => get_template_directory_uri() . '/assets/images/logo@2x.png')
        ),

         array(
            'id'        => 'use_sticky',
            'type'      => 'button_set',
            'title'     => __('Use sticky menu?', THEME_SLUG),
            'options'   => array(
                1        => '&nbsp;I&nbsp;',
                0       => 'O',
            ),
            'default'   => 1
        ),

        array(
            'id'        => 'menu_layout',
            'type'      => 'button_set',
            'title'     => __('Homepage transparent menu', THEME_SLUG),
            'subtitle'  => __('Use transparent sticky menu on the Homepage?', THEME_SLUG),
            'required'  => array('use_sticky', '=', 1),
            'options'   => array(
                1        => '&nbsp;I&nbsp;',
                0       => 'O',
            ),
            'default'   => 0
        ),

        array(
            'id'        => 'trans_menu_color',
            'type'      => 'color',
            'validate'  => 'color',
            'required'  => array('set_color','equals', 1),
            'title'     => __('Custom Color', THEME_SLUG),
            'subtitle'  => __('You can define a new custom color for the theme  scheme.', THEME_SLUG),
            'required'  => array(
                array('use_sticky',  '=', 1),
                array('menu_layout', '=', 1)
            ),
            'transparent' => false,
            'default'   => '#FFF'
        )

    ),

);
