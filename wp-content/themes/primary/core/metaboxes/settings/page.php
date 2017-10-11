<?php
global $wp_registered_sidebars;
$layout = isset($this->data['page_sidebar_position']) ? $this->data['page_sidebar_position'] : 'no';
$sidebars_list = array();
foreach ($wp_registered_sidebars as $sidebar => $attrs) {
    $sidebars_list[$attrs['id']] = $attrs['name'];
}

$port_cats_array = array('none' => __('Default (All Categories)', THEME_SLUG));
$port_cats = get_terms( THEME_SLUG . '_portfolio_category', 'orderby=name&order=ASC&hide_empty=1' );
foreach ($port_cats as $key => $value) {
    $port_cats_array[$value->term_id] = $value->name;
}

// PAGE
$meta_boxes[] = array(
    'id' => THEME_SLUG . '_page_settings',
    'title' => __( 'Page Settings', THEME_SLUG ),
    'pages' => array( 'page' ),
    'context' => 'normal',
    'priority' => 'high',
    'autosave' => true,

    'fields' => array(
        // Subtitle
        array(
            'name'  => 'Subtitle:',
            'id'    => THEME_SLUG . "_subtitle",
            'type'  => 'hidden'
        ),

        // Category for portfolio page
        array(
            'name'    =>  __( 'Portfolio Category:', THEME_SLUG ),
            'id'      =>  THEME_SLUG . "_page_portfolio_cat",
            'type'    =>  'select',
            'desc'    =>  __( 'Select category for this page. This category <b>should be</b> a parent category.', THEME_SLUG ),
            'options' =>  $port_cats_array,
            'std'     =>  'none',
        ),

        // // Header Background
        // array(
        //     'name' => __('Header background:', THEME_SLUG),
        //     'id'               => THEME_SLUG . "_page_header_bg",
        //     'type'             => 'image_advanced',
        //     'max_file_uploads' => 1,
        //     'desc'  => __( 'Select image from media library.', THEME_SLUG ),
        // ),

        // // Advanced Background Settings
        // array(
        //     'name' => __('Advanced background settings:', THEME_SLUG),
        //     'id'               => THEME_SLUG . "_page_header_advanced",
        //     'type'             => 'checkbox',
        //     'std'              => 0,
        //     'desc'  => __( 'It works <b>ONLY</b> if you choose a header background image above.', THEME_SLUG ),
        // ),

// DIVIDER
// array(
//     'type' => 'divider',
//     'id'   => THEME_SLUG . "_page_divider_id1", // Not used, but needed
// ),
//         // Header Background Color
//         array(
//             'name' => __('Page header background:', THEME_SLUG),
//             'id'               => THEME_SLUG . "_page_header_bgcol",
//             'type'             => 'color',
//             'std'              => '#000'
//             // 'desc'  => __( 'Select image from media library.', THEME_SLUG ),
//         ),

//         // Background opacity
//         array(
//             'name' => __( 'Background opacity:', THEME_SLUG ),
//             'id'   => THEME_SLUG . "_page_header_bgcol_opacity",
//             'type' => 'slider',
//             'suffix' => ' %',
//             'std' => 0.40,
//             // jQuery UI slider options. See here http://api.jqueryui.com/slider/
//             'js_options' => array(
//                 'min'   => 0.01,
//                 'max'   => 1,
//                 'step'  => 0.01,
//             ),
//         ),

//         // Title Color
//         array(
//             'name' => __('Page title color:', THEME_SLUG),
//             'id'               => THEME_SLUG . "_page_title_col",
//             'type'             => 'color',
//             'std'              => '#FFF'
//         ),

        // Subitle Color
        // array(
        //     'name' => __('Subtitle color:', THEME_SLUG),
        //     'id'               => THEME_SLUG . "_page_subtitle_col",
        //     'type'             => 'color',
        // ),

// array(
//     'type' => 'divider',
//     'id'   => THEME_SLUG . "_page_divider_id2", // Not used, but needed
// ),

        // Breadcrumbs
        array(
            'name'    => __( 'Breadcrumbs:', THEME_SLUG ),
            'id'   => THEME_SLUG . "_page_breadcrumbs",
            'type'    => 'select',
            'desc'  => __( 'By default page used general theme settings, defined on '.THEME_NAME.' Options page.', THEME_SLUG ),
            'options' => array(
                '-1' => __( 'Default', THEME_SLUG ),
                '1' => __( 'Show', THEME_SLUG ),
                '0' => __( 'Hide', THEME_SLUG ),
            ),
            'std'  => '-1',
        )

    )
);

$meta_boxes[] = array(
    'id' => THEME_SLUG . '_page_layout',
    'title' => __( 'Page Layout', THEME_SLUG ),
    'pages' => array( 'page' ),
    'context' => 'side',
    'priority' => 'low',
    'autosave' => true,

    'fields' => array(
        // Layout
        array(
            'id'       => THEME_SLUG . '_page_layout',
            'type'     => 'image_select',
            'options'  => array(
                'right' => THEME_URI . '/core/options/redux-framework/ReduxCore/assets/img/2cr.png',
                'no'  => THEME_URI . '/core/options/redux-framework/ReduxCore/assets/img/1col.png',
                'left'  => THEME_URI . '/core/options/redux-framework/ReduxCore/assets/img/2cl.png',
            ),
            'std' => $layout
        ),
        // Sidebars
            array(
                'name'  => null,
                'id'    => THEME_SLUG . "_page_widgets_area",
                'desc'  => __( 'Select widgets area for this page.', THEME_SLUG ),
                'type'  => 'select_advanced',
                'multiple'    => false,
                'options'  => $sidebars_list,
                'placeholder' => __( 'Select Widgets Area', THEME_SLUG )
            )
    )
);
