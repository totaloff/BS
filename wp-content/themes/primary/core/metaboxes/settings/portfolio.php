<?php

$port_cats_array = array('none' => __('Default (All Categories)', THEME_SLUG));
$port_cats = get_terms( THEME_SLUG . '_portfolio_category', 'orderby=name&order=ASC&hide_empty=1' );
foreach ($port_cats as $key => $value) {
    $port_cats_array[$value->term_id] = $value->name;
}

// Portfolio box
$meta_boxes[] = array(
    'id' => THEME_SLUG . '_portfolio_gallery',
    'title' => __( 'Portfolio Gallery', THEME_SLUG ),
    'pages' => array( THEME_SLUG . '_portfolio' ),
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
        // Image Gallery
        array(
            'id'               => THEME_SLUG . "_portfolio_gallery",
            'type'             => 'image_advanced',
            'max_file_uploads' => 0,
            'desc'  => __( 'Ctrl/Cmd + click: select multiply images from media library.', THEME_SLUG ),
        ),

    )

);


// Portfolio Details
$meta_boxes[] = array(
    'id' => THEME_SLUG . '_portfolio_details',
    'title' => __( 'Portfolio Details', THEME_SLUG ),
    'pages' => array( THEME_SLUG . '_portfolio' ),
    'context' => 'normal',
    'priority' => 'high',
    'autosave' => true,

    'fields' => array(

        // Date (mm.dd.yyyy)
        array(
            'name' => __( 'Date (mm.dd.yyyy):', THEME_SLUG ),
            'id'   => THEME_SLUG . "_portfolio_date",
            'type' => 'date',
            // jQuery date picker options. See here http://api.jqueryui.com/datepicker
            'js_options' => array(
                // 'appendText'      => 
                'dateFormat'      => __( 'mm.dd.yy', THEME_SLUG ),
                'changeMonth'     => true,
                'changeYear'      => true,
                // 'showButtonPanel' => true,
            ),
        ),

// DIVIDER
array(
    'type' => 'divider',
    'id'   => THEME_SLUG . "_portfolio_divider_id1", // Not used, but needed
),

        // Author
        array(
            'name'  => __( 'Author:', THEME_SLUG ),
            'id'    => THEME_SLUG . "_portfolio_author",
            'type'  => 'text',
            'std'   => __( 'John Doe', THEME_SLUG ),
        ),

        // Author URL
        array(
            'name'  => __( 'Author URL:', THEME_SLUG ),
            'id'    => THEME_SLUG . "_portfolio_author_url",
            'type'  => 'url',
            'std'   => 'http://example.net',
        ),

// DIVIDER
array(
    'type' => 'divider',
    'id'   => THEME_SLUG . "_portfolio_divider_id2", // Not used, but needed
),

        // Client
        array(
            'name'  => __( 'Client:', THEME_SLUG ),
            'id'    => THEME_SLUG . "_portfolio_client",
            'type'  => 'text',
            'std'   => __( 'Jane Doe', THEME_SLUG ),
        ),

        // Client URL
        array(
            'name'  => __( 'Client URL:', THEME_SLUG ),
            'id'    => THEME_SLUG . "_portfolio_client_url",
            'type'  => 'url',
            'std'   => 'http://example.net',
        ),    

// DIVIDER
array(
    'type' => 'divider',
    'id'   => THEME_SLUG . "_portfolio_divider_id3", // Not used, but needed
),

        // Description
        array(
            'name' => __( 'Description:', THEME_SLUG ),
            'id'   => THEME_SLUG . "_portfolio_description",
            'type' => 'wysiwyg',
            'raw'  => false,
            'std'  => __( 'Your Description here...', THEME_SLUG ),
            'options' => array(
                'textarea_rows' => 6,
                'teeny'         => true,
                'media_buttons' => false,
            ),
        ),
    )
);

// Portfolio Settings
$meta_boxes[] = array(
    'id' => THEME_SLUG . '_post_settings',
    'title' => __( 'Portfolio Settings', THEME_SLUG ),
    'pages' => array( THEME_SLUG . '_portfolio' ),
    'context' => 'normal',
    'priority' => 'low',
    'autosave' => false,

    'fields' => array(
        // Breadcrumbs
        array(
            'name'    => __( 'Breadcrumbs:', THEME_SLUG ),
            'id'   => THEME_SLUG . "_port_breadcrumbs",
            'type'    => 'select',
            'desc'  => __( 'By default page used general theme settings, defined on '.THEME_NAME.' Options page.', THEME_SLUG ),
            'options' => array(
                '-1' => __( 'Default', THEME_SLUG ),
                '1' => __( 'Show', THEME_SLUG ),
                '0' => __( 'Hide', THEME_SLUG ),
            ),
            'std'  => '-1',
        ),

// DIVIDER
array(
    'type' => 'divider',
    'id'   => THEME_SLUG . "_portfolio_divider_id4", // Not used, but needed
),

        // Category for portfolio page
        array(
            'name'    =>  __( 'Portfolio Category:', THEME_SLUG ),
            'id'      =>  THEME_SLUG . "_portfolio_recent_works_cat",
            'type'    =>  'select',
            'desc'    =>  __( 'Select category for "Recent Works" section.', THEME_SLUG ),
            'options' =>  $port_cats_array,
            'std'     =>  'none',
        ),

    )
);
