<?php

$meta_boxes[THEME_SLUG . '_services'] = array(
    'id' => THEME_SLUG . '_services',
    'title' => __( 'Service Details', THEME_SLUG ),
    'pages' => array( THEME_SLUG . '_services' ),
    'context' => 'normal',
    'priority' => 'high',
    'autosave' => true,

    'fields' => array(
        // Abuut
        array(
            'name' => __( 'Service Text:', THEME_SLUG ),
            'desc' => __( 'Add your text for the service item.', THEME_SLUG ),
            'id'   => THEME_SLUG . "_services_text",
            'type' => 'textarea',
            'cols' => 20,
            'rows' => 6,
        ),
        // DIVIDER
        array(
            'type' => 'divider',
            'id'   => THEME_SLUG . "_services_divider", // Not used, but needed
        ),
        // HEADING
        array(
            'name' => __( 'Service Icon:', THEME_SLUG ),
            'type' => 'heading',
            'id'   => 'fake_id', // Not used but needed for plugin
        ),

        // HIDDEN
        array(
            'id'   => THEME_SLUG . "_services_icons_list",
            'type' => 'hidden',
            // Hidden field must have predefined value
            'std'  => ""
        ),
    )
);