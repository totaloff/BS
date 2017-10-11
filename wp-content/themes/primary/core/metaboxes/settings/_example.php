<?php

$meta_boxes[] = array(
    // Meta box id, UNIQUE per meta box. Optional since 4.1.5
    'id' => 'standard',

    // Meta box title - Will appear at the drag and drop handle bar. Required.
    'title' => __( 'Standard Fields', 'rwmb' ),

    // Post types, accept custom post types as well - DEFAULT is array('post'). Optional.
    'pages' => array( 'post', 'page' ),

    // Where the meta box appear: normal (default), advanced, side. Optional.
    'context' => 'normal',

    // Order of meta box: high (default), low. Optional.
    'priority' => 'high',

    // Auto save: true, false (default). Optional.
    'autosave' => true,

    // List of meta fields
    'fields' => array(

        // TEXT
        array(
            // Field name - Will be used as label
            'name'  => __( 'Author:', 'rwmb' ),
            // Field ID, i.e. the meta key
            'id'    => THEME_SLUG . "_portfolio_author",
            // Field description (optional)
            // 'desc'  => __( 'Text description', 'rwmb' ),
            'type'  => 'text',
            // Default value (optional)
            'std'   => __( 'John Doe', 'rwmb' ),
            // CLONES: Add to make the field cloneable (i.e. have multiple value)
            // 'clone' => true,
        ),

        // CHECKBOX
        array(
            'name' => __( 'Checkbox', 'rwmb' ),
            'id'   => THEME_SLUG . "_checkbox",
            'type' => 'checkbox',
            // Value can be 0 or 1
            'std'  => 1,
        ),

        // RADIO BUTTONS
        array(
            'name'    => __( 'Radio', 'rwmb' ),
            'id'      => THEME_SLUG . "_radio",
            'type'    => 'radio',
            // Array of 'value' => 'Label' pairs for radio options.
            // Note: the 'value' is stored in meta field, not the 'Label'
            'options' => array(
                'value1' => __( 'Label1', 'rwmb' ),
                'value2' => __( 'Label2', 'rwmb' ),
            ),
            'std'  => 1,
        ),

        // SELECT BOX
        array(
            'name'     => __( 'Select', 'rwmb' ),
            'id'       => THEME_SLUG . "_select",
            'type'     => 'select',
            // Array of 'value' => 'Label' pairs for select box
            'options'  => array(
                'value1' => __( 'Label1', 'rwmb' ),
                'value2' => __( 'Label2', 'rwmb' ),
            ),
            // Select multiple values, optional. Default is false.
            'multiple'    => false,
            'std'         => 'value2',
            'placeholder' => __( 'Select an Item', 'rwmb' ),
        ),

        // HIDDEN
        array(
            'id'   => THEME_SLUG . "_hidden",
            'type' => 'hidden',
            // Hidden field must have predefined value
            'std'  => __( 'Hidden value', 'rwmb' ),
        ),

        // Date (mm.dd.yyyy)
        array(
            'name' => __( 'Date (mm.dd.yyyy):', 'rwmb' ),
            'id'   => THEME_SLUG . "_portfolio_date",
            'type' => 'date',
            // jQuery date picker options. See here http://api.jqueryui.com/datepicker
            'js_options' => array(
                // 'appendText'      => 
                'dateFormat'      => __( 'mm.dd.yy', 'rwmb' ),
                'changeMonth'     => true,
                'changeYear'      => true,
                // 'showButtonPanel' => true,
            ),
        ),

        // PASSWORD
        // array(
        //     'name' => __( 'Password', 'rwmb' ),
        //     'id'   => THEME_SLUG . "_password",
        //     'type' => 'password',
        // ),

        // WYSIWYG
        array(
            'name' => __( 'Description:', 'rwmb' ),
            'id'   => THEME_SLUG . "_portfolio_description",
            'type' => 'wysiwyg',
            // Set the 'raw' parameter to TRUE to prevent data being passed through wpautop() on save
            'raw'  => false,
            'std'  => __( 'Your Description here...', 'rwmb' ),
            // Editor settings, see wp_editor() function: look4wp.com/wp_editor
            'options' => array(
                'textarea_rows' => 6,
                'teeny'         => true,
                'media_buttons' => false,
            ),
        ),

        // TEXTAREA
        array(
            'name' => __( 'Textarea', 'rwmb' ),
            'desc' => __( 'Textarea description', 'rwmb' ),
            'id'   => THEME_SLUG . "_textarea",
            'type' => 'textarea',
            'cols' => 20,
            'rows' => 3,
        ),
    ),
    // 'validation' => array(
    //     'rules' => array(
    //         THEME_SLUG . "_password" => array(
    //             'required'  => true,
    //             'minlength' => 7,
    //         ),
    //     ),
    //     // optional override of default jquery.validate messages
    //     'messages' => array(
    //         THEME_SLUG . "_password" => array(
    //             'required'  => __( 'Password is required', 'rwmb' ),
    //             'minlength' => __( 'Password must be at least 7 characters', 'rwmb' ),
    //         ),
    //     )
    // )
);

// 2nd meta box
$meta_boxes[] = array(
    'title' => __( 'Advanced Fields', 'rwmb' ),

    'fields' => array(
        // HEADING
        array(
            'type' => 'heading',
            'name' => __( 'Heading', 'rwmb' ),
            'id'   => 'fake_id', // Not used but needed for plugin
        ),
        // SLIDER
        array(
            'name' => __( 'Slider', 'rwmb' ),
            'id'   => THEME_SLUG . "_slider",
            'type' => 'slider',

            // Text labels displayed before and after value
            'prefix' => __( '$', 'rwmb' ),
            'suffix' => __( ' USD', 'rwmb' ),

            // jQuery UI slider options. See here http://api.jqueryui.com/slider/
            'js_options' => array(
                'min'   => 10,
                'max'   => 255,
                'step'  => 5,
            ),
        ),

        // NUMBER
        array(
            'name' => __( 'Number', 'rwmb' ),
            'id'   => THEME_SLUG . "_number",
            'type' => 'number',

            'min'  => 0,
            'step' => 5,
        ),

        // DATETIME
        array(
            'name' => __( 'Datetime picker', 'rwmb' ),
            'id'   => $prefix . 'datetime',
            'type' => 'datetime',

            // jQuery datetime picker options.
            // For date options, see here http://api.jqueryui.com/datepicker
            // For time options, see here http://trentrichardson.com/examples/timepicker/
            'js_options' => array(
                'stepMinute'     => 15,
                'showTimepicker' => true,
            ),
        ),
        // TIME
        array(
            'name' => __( 'Time picker', 'rwmb' ),
            'id'   => $prefix . 'time',
            'type' => 'time',

            // jQuery datetime picker options.
            // For date options, see here http://api.jqueryui.com/datepicker
            // For time options, see here http://trentrichardson.com/examples/timepicker/
            'js_options' => array(
                'stepMinute' => 5,
                'showSecond' => true,
                'stepSecond' => 10,
            ),
        ),
        // COLOR
        array(
            'name' => __( 'Color picker', 'rwmb' ),
            'id'   => THEME_SLUG . "_color",
            'type' => 'color',
        ),
        // CHECKBOX LIST
        array(
            'name' => __( 'Checkbox list', 'rwmb' ),
            'id'   => THEME_SLUG . "_checkbox_list",
            'type' => 'checkbox_list',
            // Options of checkboxes, in format 'value' => 'Label'
            'options' => array(
                'value1' => __( 'Label1', 'rwmb' ),
                'value2' => __( 'Label2', 'rwmb' ),
            ),
        ),
        // EMAIL
        array(
            'name'  => __( 'Email', 'rwmb' ),
            'id'    => THEME_SLUG . "_email",
            'desc'  => __( 'Email description', 'rwmb' ),
            'type'  => 'email',
            'std'   => 'name@email.com',
        ),
        // RANGE
        array(
            'name'  => __( 'Range', 'rwmb' ),
            'id'    => THEME_SLUG . "_range",
            'desc'  => __( 'Range description', 'rwmb' ),
            'type'  => 'range',
            'min'   => 0,
            'max'   => 100,
            'step'  => 5,
            'std'   => 0,
        ),

        // URL
        array(
            'name'  => __( 'URL', 'rwmb' ),
            'id'    => THEME_SLUG . "_url",
            'desc'  => __( 'URL description', 'rwmb' ),
            'type'  => 'url',
            'std'   => 'http://google.com',
        ),

        // OEMBED
        array(
            'name'  => __( 'oEmbed', 'rwmb' ),
            'id'    => THEME_SLUG . "_oembed",
            'desc'  => __( 'oEmbed description', 'rwmb' ),
            'type'  => 'oembed',
        ),

        // SELECT ADVANCED BOX
        array(
            'name'     => __( 'Select', 'rwmb' ),
            'id'       => THEME_SLUG . "_select_advanced",
            'type'     => 'select_advanced',
            // Array of 'value' => 'Label' pairs for select box
            'options'  => array(
                'value1' => __( 'Label1', 'rwmb' ),
                'value2' => __( 'Label2', 'rwmb' ),
            ),
            // Select multiple values, optional. Default is false.
            'multiple'    => false,
            // 'std'         => 'value2', // Default value, optional
            'placeholder' => __( 'Select an Item', 'rwmb' ),
        ),

        // TAXONOMY
        array(
            'name'    => __( 'Taxonomy', 'rwmb' ),
            'id'      => THEME_SLUG . "_taxonomy",
            'type'    => 'taxonomy',
            'options' => array(
                // Taxonomy name
                'taxonomy' => 'category',
                // How to show taxonomy: 'checkbox_list' (default) or 'checkbox_tree', 'select_tree', select_advanced or 'select'. Optional
                'type' => 'checkbox_list',
                // Additional arguments for get_terms() function. Optional
                'args' => array()
            ),
        ),

        // POST
        array(
            'name'    => __( 'Posts (Pages)', 'rwmb' ),
            'id'      => THEME_SLUG . "_pages",
            'type'    => 'post',

            // Post type
            'post_type' => 'page',
            // Field type, either 'select' or 'select_advanced' (default)
            'field_type' => 'select_advanced',
            // Query arguments (optional). No settings means get all published posts
            'query_args' => array(
                'post_status'    => 'publish',
                'posts_per_page' => - 1,
            )
        ),

        // FILE ADVANCED (WP 3.5+)
        array(
            'name' => __( 'File Advanced Upload', 'rwmb' ),
            'id'   => THEME_SLUG . "_file_advanced",
            'type' => 'file_advanced',
            'max_file_uploads' => 4,
            'mime_type' => 'application,audio,video', // Leave blank for all file types
        ),

        // BUTTON
        array(
            'id'   => THEME_SLUG . "_button",
            'type' => 'button',
            'name' => ' ', // Empty name will "align" the button to all field inputs
        ),

    )
);