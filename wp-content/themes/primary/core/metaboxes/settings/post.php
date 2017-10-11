<?php

// POST Formats {
    // PhoenixTeam_link_post_custom_fields
    // PhoenixTeam_quote_post_custom_fields
    // PhoenixTeam_gallery_post_custom_fields
    // PhoenixTeam_video_post_custom_fields
    // PhoenixTeam_audio_post_custom_fields

    // Link
   $meta_boxes[] = array(
       'id' => 'PhoenixTeam_link_post_custom_fields',
       'title' => __( 'Link Post Options', THEME_SLUG ),
       'pages' => array( 'post' ),
       'context' => 'normal',
       'priority' => 'high',
       'autosave' => true,

       'fields' => array(

            // Link URL
            array(
                'name'  => __( 'Link URL:', THEME_SLUG ),
                'id'    => THEME_SLUG . "_postformat_link_url",
                'desc'  => __( 'Post title will be a link to the URL.', THEME_SLUG ),
                'type'  => 'url',
                'std'   => 'http://google.com',
            ),
// DIVIDER
array(
    'type' => 'divider',
    'id'   => THEME_SLUG . "_postformat_link_id", // Not used, but needed
),
           // Link Target
           array(
               'name'    => __( 'Target of link:', THEME_SLUG ),
               'id'    => THEME_SLUG . "_postformat_link_target",
               'type'    => 'radio',
               'desc'  => __( 'Set target of link.', THEME_SLUG ),
               'options' => array(
                   '_blank' => '_blank: ' . __( 'New window or tab', THEME_SLUG ) . "<br />",
                   '_self' =>  '_self: '. __( 'Same window or tab', THEME_SLUG )
               ),
               'std'  => '_blank',
           ),
// DIVIDER
array(
    'type' => 'divider',
    'id'   => THEME_SLUG . "_postformat_link_id2", // Not used, but needed
),
           // Link Relationship
           array(
               'name'  => __( 'Link Relationship (optional):', THEME_SLUG ),
               'id'    => THEME_SLUG . "_postformat_link_rel",
               'desc'  => __( 'Set link "rel" attribute. Example: nofollow, dofollow or etc.', THEME_SLUG ),
               'type'  => 'text'
               // 'std'   =>
           ),

       )
   );

    // Quote
   $meta_boxes[] = array(
       'id' => 'PhoenixTeam_quote_post_custom_fields',
       'title' => __( 'Quote Post Options', THEME_SLUG ),
       'pages' => array( 'post' ),
       'context' => 'normal',
       'priority' => 'high',
       'autosave' => true,

       'fields' => array(

            // Quote text
            array(
                'name' => __( 'Quote text:', THEME_SLUG ),
                'desc' => __( 'Add text for quote.', THEME_SLUG ),
                'id'   => THEME_SLUG . "_postformat_quote_text",
                'type' => 'textarea',
                'cols' => 20,
                'rows' => 6,
            ),
// DIVIDER
array(
    'type' => 'divider',
    'id'   => THEME_SLUG . "_postformat_quote_id", // Not used, but needed
),
            //  Quote author
            array(
                'name'  => __( 'Quote author:', THEME_SLUG ),
                'id'    => THEME_SLUG . "_postformat_quote_author",
                'desc'  => __( 'Who said this quote?', THEME_SLUG ),
                'type'  => 'text'
                // 'std'   =>
            ),
       )
   );

    // Gallery
    $meta_boxes[] = array(
        'id' => 'PhoenixTeam_gallery_post_custom_fields',
        'title' => __( 'Gallery Post Options', THEME_SLUG ),
        'pages' => array( 'post' ),
        'context' => 'normal',
        'priority' => 'high',
        'autosave' => true,

        'fields' => array(
            array(
                'name'             => __( 'Gallery', THEME_SLUG ),
                'id'               => THEME_SLUG . "_postformat_gallery",
                'type'             => 'image_advanced',
                'max_file_uploads' => 0,
                'desc'  => __( 'Ctrl/Cmd + click: select multiply images from media library.', THEME_SLUG ),
            )
        )
    );

    // Video
   $meta_boxes[] = array(
       'id' => 'PhoenixTeam_video_post_custom_fields',
       'title' => __( 'Video Post Options', THEME_SLUG ),
       'pages' => array( 'post' ),
       'context' => 'normal',
       'priority' => 'high',
       'autosave' => true,

       'fields' => array(
            // Source switch
            array(
                'name'  => __( 'Video source:', THEME_SLUG ),
                'id'    => THEME_SLUG . "_postformat_video_type",
                'desc'  => __( 'Select video source.', THEME_SLUG ),
                'type'  => 'select',
                'options' => array(
                    'url' => 'URL',
                    'embed' => 'Embed code'
                ),
                'std'   => 'url'
            ),

// DIVIDER
array(
    'type' => 'divider',
    'id'   => THEME_SLUG . "_postformat_video_id", // Not used, but needed
),
            // Video Url
            array(
                'name'  => __( 'Video Url:', THEME_SLUG ),
                'id'    => THEME_SLUG . "_postformat_video_url",
                'desc'  => __( 'Video URL. For example:<br/>YouTube - <a href="#">https://www.youtube.com/watch?v=BsekcY04xvQ</a><br/>Vimeo - <a href="#">http://vimeo.com/102671169</a>', THEME_SLUG ),
                'type'  => 'oembed'
            ),
            // Video Embed
            array(
                'name' => __( 'Video embed code:', THEME_SLUG ),
                'desc' => __( 'Add your embed code here. <a href="#">Get the example.</a>', THEME_SLUG ),
                'id'   => THEME_SLUG . "_postformat_video_embed",
                'type' => 'textarea',
                'cols' => 20,
                'rows' => 6
            )
       )
   );
    // Quote
   $meta_boxes[] = array(
       'id' => 'PhoenixTeam_audio_post_custom_fields',
       'title' => __( 'Audio Post Options', THEME_SLUG ),
       'pages' => array( 'post' ),
       'context' => 'normal',
       'priority' => 'high',
       'autosave' => true,
       'fields' => array(
            // Source switch
            array(
                'name'  => __( 'Audio source:', THEME_SLUG ),
                'id'    => THEME_SLUG . "_postformat_audio_type",
                'desc'  => __( 'Select audio source.', THEME_SLUG ),
                'type'  => 'select',
                'options' => array(
                    'url' => 'URL',
                    'file' => 'File'
                ),
                'std'   => 'url'
            ),
// DIVIDER
array(
    'type' => 'divider',
    'id'   => THEME_SLUG . "_postformat_audio_id", // Not used, but needed
),
            // Audio Url
            array(
                'name'  => __( 'Audio Url:', THEME_SLUG ),
                'id'    => THEME_SLUG . "_postformat_audio_url",
                'desc'  => __( 'Audio URL. For example:<br/>SoundCloud - <a href="#">https://soundcloud.com/alunageorge/coldplay-magic-alunageorge-remix</a>', THEME_SLUG ),
                'type'  => 'oembed'
            ),
            // Audio file
            array(
                'name' => __( 'Audio file:', THEME_SLUG ),
                'desc' => __( 'Upload your audio file here.', THEME_SLUG ),
                'id'   => THEME_SLUG . "_postformat_audio_file",
                'type' => 'file_advanced',
                'max_file_uploads' => 1,
                'mime_type' => 'audio',
            ),
       )
   );
// }

// POST General
$meta_boxes[] = array(
    'id' => THEME_SLUG . '_post_settings',
    'title' => __( 'Post Settings', THEME_SLUG ),
    'pages' => array( 'post' ),
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
        // Title Section
        array(
            'name'    => __( 'Title Section:', THEME_SLUG ),
            'id'   => THEME_SLUG . "_post_title_section",
            'type'    => 'select',
            'desc'  => __( 'By default this post used general theme settings, defined on '.THEME_NAME.' Options page.', THEME_SLUG ),
            'options' => array(
               '1' => __( 'Show', THEME_SLUG ),
               '0' => __( 'Hide', THEME_SLUG ),
            ),
            'std'  => '-1',
        ),
        // Breadcrumbs
        array(
            'name'    => __( 'Breadcrumbs:', THEME_SLUG ),
            'id'   => THEME_SLUG . "_post_breadcrumbs",
            'type'    => 'select',
            'desc'  => __( 'By default page used general theme settings, defined on '.THEME_NAME.' Options page.', THEME_SLUG ),
            'options' => array(
                '-1' => __( 'Default', THEME_SLUG ),
                '1' => __( 'Show', THEME_SLUG ),
                '0' => __( 'Hide', THEME_SLUG ),
            ),
            'std'  => '-1',
        ),
    )
);
