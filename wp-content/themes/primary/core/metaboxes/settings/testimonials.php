<?php

$meta_boxes[THEME_SLUG . '_testimonials'] = array(
    'id' => THEME_SLUG . '_testimonials',
    'title' => __( 'Testimonial Details', THEME_SLUG ),
    'pages' => array( THEME_SLUG . '_testimonials' ),
    'context' => 'normal',
    'priority' => 'high',
    'autosave' => true,

    'fields' => array(
        // TEXT
        array(
            'name'  => __( 'Author Name:', THEME_SLUG ),
            'id'    => THEME_SLUG . "_testimonials_author",
            'type'  => 'text',
            'std'   => __( 'John Doe', THEME_SLUG ),
        ),

        // IMAGE ADVANCED (WP 3.5+)
        array(
            'name'             => __( 'Author Photo:', THEME_SLUG ),
            'id'               => THEME_SLUG . "_testimonials_author_pic",
            'type'             => 'image_advanced',
            'max_file_uploads' => 1,
        ),

array(
    'type' => 'divider',
    'id'   => THEME_SLUG . "_testimonials_divider_id1", // Not used, but needed
),

        array(
            'name'  => __( 'Company or Position:', THEME_SLUG ),
            'id'    => THEME_SLUG . "_testimonials_authors_company",
            'type'  => 'text',
            'std'   => __( 'Google Inc.', THEME_SLUG ),
        ),

array(
    'type' => 'divider',
    'id'   => THEME_SLUG . "_testimonials_divider_id2", // Not used, but needed
),

        // TEXTAREA
        array(
            'name' => __( 'Text', THEME_SLUG ),
            // 'desc' => __( 'Textarea description', THEME_SLUG ),
            'id'   => THEME_SLUG . "_testimonials_text",
            'type' => 'textarea',
            'cols' => 20,
            'rows' => 3,
            'std'  => __( 'Your text here...', THEME_SLUG ),
        ),

array(
    'type' => 'divider',
    'id'   => THEME_SLUG . "_testimonials_divider_id3", // Not used, but needed
),

    )

);