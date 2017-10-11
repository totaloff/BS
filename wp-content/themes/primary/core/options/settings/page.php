<?php

$this->sections[] = array(
    'title'     => __('Page', THEME_SLUG),
    'fields'    => array(


        array(
            'id'        => 'page_sidebar_position',
            'type'      => 'image_select',
            'title'     => __('Page Sidebar Position', THEME_SLUG),
            'subtitle'  => __('Select a sidebar position for pages.', THEME_SLUG),
            'options'   => array(
                'right' => array('alt' => 'Sidebar Right',  'img' => ReduxFramework::$_url . 'assets/img/2cr.png'),
                'no' => array('alt' => 'No Sidebar',  'img' => ReduxFramework::$_url . 'assets/img/1col.png'),
                'left' => array('alt' => 'Sidebar Left',  'img' => ReduxFramework::$_url . 'assets/img/2cl.png')
            ),
            'default'   => 'no'
        ),

        array(
            'id'        => 'page_sidebar_widgets_area',
            'type'      => 'select',
            'title'     => __('Page Sidebar Widgets Area', THEME_SLUG),
            'subtitle'  => __('Select widgets area for pages.', THEME_SLUG),
            'data' => 'sidebars',
            'default'   => 'blog-sidebar'
        ),

        array(
            'id'        => 'breadcrumbs',
            'type'      => 'button_set',
            'title'     => __('Show Breadcrumbs?', THEME_SLUG),
            'subtitle'  => __('Show Breadcrumbs on top of the pages?', THEME_SLUG),
            'options'   => array(
                1       => '&nbsp;I&nbsp;',
                0       => 'O',
            ),
            'default'   => 1
        ),

        array(
            'id'        => 'page_display_comments',
            'type'      => 'button_set',
            'title'     => __('Show Comments on Pages?', THEME_SLUG),
            'subtitle'  => __('Enables comments for static pages.', THEME_SLUG),
            'options'   => array(
                1       => '&nbsp;I&nbsp;',
                0       => 'O',
            ),
            'default'   => 0
        ),
    ),
);
