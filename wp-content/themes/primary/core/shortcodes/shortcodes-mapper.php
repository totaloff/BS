<?php

new PhoenixTeam_Shortcodes_Mapper();

class PhoenixTeam_Shortcodes_Mapper extends WPBakeryShortCode {

    public function __construct ()
    {
        $this->remove_vc_shortcodes();
        $this->set_vc_templates();

        add_action( 'vc_before_init', array($this, 'map_vc_row') );
        add_action( 'vc_before_init', array($this, 'map_text_block') );
        add_action( 'vc_before_init', array($this, 'map_progressbar') );

        add_action( 'vc_before_init', array($this, 'map_promo_title') );
        add_action( 'vc_before_init', array($this, 'map_portfolio_grid') );
        add_action( 'vc_before_init', array($this, 'map_service') );
        add_action( 'vc_before_init', array($this, 'map_team_member') );
        add_action( 'vc_before_init', array($this, 'map_widget_get_in_touch') );
        add_action( 'vc_before_init', array($this, 'map_testimonials') );
        add_action( 'vc_before_init', array($this, 'map_post_box') );
        add_action( 'vc_before_init', array($this, 'map_clients_slider') );
        add_action( 'vc_before_init', array($this, 'map_facts') );
    }


    public function remove_vc_shortcodes ()
    {
        vc_remove_element('vc_toggle');
        vc_remove_element('vc_posts_grid');
        vc_remove_element('vc_gallery');
        vc_remove_element('vc_images_carousel');
        vc_remove_element('vc_posts_slider');
        vc_remove_element('vc_carousel');
    }

    public function set_vc_templates ()
    {
        if (function_exists('vc_set_shortcodes_templates_dir'))
            vc_set_shortcodes_templates_dir(THEME_DIR . '/core/shortcodes/vc_templates');
    }


    public function map_post_box ()
    {
        $args = array(
          'orderby' => 'name',
          'order' => 'ASC'
          );
        $categories = get_categories($args);

        $cats_list = array(__("None", THEME_SLUG) => 'cat == false');

        foreach ($categories as $cat) {
            $cats_list[$cat->name] = $cat->slug;
        }

        if (count($cats_list) == 0)
            $cats_list["-- ".__('You sould create some posts before you can use this widget', THEME_SLUG)." --"] = null;

        vc_map(
            array(
                "name" => __("Post Box", THEME_SLUG),
                "base" => THEME_SLUG . "_postbox",
                "class" => "",
                "category" => array( THEME_NAME . " " . __("Exclusive", THEME_SLUG), __('Content', THEME_SLUG) ),
                "params" => array(
                    array(
                        "type" => "textfield",
                        "heading" => __('Select Posts Quantity', THEME_SLUG),
                        "param_name" => "qty",
                        "description" => __("How many posts to show in posts box", THEME_SLUG),
                        "value" => 2
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __('Select Posts Category', THEME_SLUG),
                        "param_name" => "cat",
                        "description" => __("You sould create some categorise & asosiate them with posts before you can use this option.", THEME_SLUG),
                        "value" => $cats_list
                    ),
                    array(
                        'type' => 'css_editor',
                        'heading' => __('Css', THEME_SLUG),
                        'param_name' => 'css',
                        'group' => __('Design options', THEME_SLUG)
                    )
                )
            )
        );
    }


    public function map_vc_row ()
    {
      vc_map(array(
        'name' => __('Row', THEME_SLUG),
        'base' => 'vc_row',
        'is_container' => true,
        'icon' => 'icon-wpb-row',
        'show_settings_on_create' => false,
        'category' => __('Content', THEME_SLUG),
        'description' => __('Place content elements inside the row', THEME_SLUG),
        'params' => array(
          array(
              "type" => "dropdown",
              "heading" => __("Type", THEME_SLUG),
              "param_name" => "row_type",
              "description" => __("You can specify whether the row is displayed fullwidth or in container.", THEME_SLUG),
              "std" => "container",
              "value" => array(
                  __("In Container", THEME_SLUG) => 'container',
                  __("Fullwidth", THEME_SLUG) => 'fullwidth'
              )
          ),
          array(
            "type" => "textfield",
            "heading" => __("ID Name for Navigation", THEME_SLUG),
            "param_name" => "id",
            "description" => __("If this row wraps the content of one of your sections, set an ID. You can then use it for navigation.", THEME_SLUG)
          ),
          array(
            'type' => 'checkbox',
            'heading' => __('Full height row?', THEME_SLUG),
            'param_name' => 'full_height',
            'description' => __('If checked row will be set to full height.', THEME_SLUG),
            'value' => array( __('Yes', 'js_composer' ) => 'yes' )
          ),
          array(
            'type' => 'dropdown',
            'heading' => __('Content position', THEME_SLUG),
            'param_name' => 'content_placement',
            'value' => array(
              __('Middle', 'js_composer' ) => 'middle',
              __('Top', 'js_composer' ) => 'top',
            ),
            'description' => __('Select content position within row.', THEME_SLUG),
            'dependency' => array(
              'element' => 'full_height',
              'not_empty' => true,
            ),
          ),
          array(
            'type' => 'checkbox',
            'heading' => __('Use video background?', THEME_SLUG),
            'param_name' => 'video_bg',
            'description' => __('If checked, video will be used as row background.', THEME_SLUG),
            'value' => array( __('Yes', 'js_composer' ) => 'yes' )
          ),
          array(
            'type' => 'textfield',
            'heading' => __('YouTube link', THEME_SLUG),
            'param_name' => 'video_bg_url',
            'description' => __('Add YouTube link.', THEME_SLUG),
            'dependency' => array(
              'element' => 'video_bg',
              'not_empty' => true,
            ),
          ),
          array(
            'type' => 'dropdown',
            'heading' => __('Parallax', THEME_SLUG),
            'param_name' => 'video_bg_parallax',
            'value' => array(
              __('None', 'js_composer' ) => '',
              __('Simple', 'js_composer' ) => 'content-moving',
              __('With fade', 'js_composer' ) => 'content-moving-fade',
            ),
            'description' => __('Add parallax type background for row.', THEME_SLUG),
            'dependency' => array(
              'element' => 'video_bg',
              'not_empty' => true,
            ),
          ),
          array(
            'type' => 'dropdown',
            'heading' => __('Parallax', THEME_SLUG),
            'param_name' => 'parallax',
            'value' => array(
              __('None', 'js_composer' ) => '',
              __('Simple', 'js_composer' ) => 'content-moving',
              __('With fade', 'js_composer' ) => 'content-moving-fade',
            ),
            'description' => __('Add parallax type background for row (Note: If no image is specified, parallax will use background image from Design Options).', THEME_SLUG),
            'dependency' => array(
              'element' => 'video_bg',
              'is_empty' => true,
            ),
          ),
          array(
            'type' => 'attach_image',
            'heading' => __('Image', THEME_SLUG),
            'param_name' => 'parallax_image',
            'value' => '',
            'description' => __('Select image from media library.', THEME_SLUG),
            'dependency' => array(
              'element' => 'parallax',
              'not_empty' => true,
            ),
          ),
          array(
            'type' => 'textfield',
            'heading' => __('Extra class name', THEME_SLUG),
            'param_name' => 'el_class',
            'description' => __('Style particular content element differently - add a class name and refer to it in custom CSS.', THEME_SLUG),
          ),
          array(
            'type' => 'css_editor',
            'heading' => __('CSS box', THEME_SLUG),
            'param_name' => 'css',
            'group' => __('Design Options', 'js_composer' )
          ),
        ),
        'js_view' => 'VcRowView'
      ));
    }


    public function map_text_block ()
    {
        vc_map( array(
            'name' => __('Text Block', THEME_SLUG),
            'base' => 'vc_column_text',
            'icon' => 'icon-wpb-layer-shape-text',
            'wrapper_class' => 'clearfix',
            'category' => __('Content', THEME_SLUG),
            'description' => __('A block of text with WYSIWYG editor', THEME_SLUG),
            'params' => array(
                array(
                    'type' => 'textarea_html',
                    'holder' => 'div',
                    'heading' => __('Text', THEME_SLUG),
                    'param_name' => 'content',
                    'value' => __('<p>I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>', THEME_SLUG)
                ),
                array(
                    "type" => "checkbox",
                    "param_name" => "dropcaps",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Show dropcaps", THEME_SLUG),
                    "description" => __("Show dropcaps to first letter?", THEME_SLUG),
                    "value" => array( 'Show' => true),
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => __('CSS Animation', THEME_SLUG),
                    'param_name' => 'css_animation',
                    'admin_label' => true,
                    'value' => array(
                        __('No', THEME_SLUG) => '',
                        __('Top to bottom', THEME_SLUG) => 'top-to-bottom',
                        __('Bottom to top', THEME_SLUG) => 'bottom-to-top',
                        __('Left to right', THEME_SLUG) => 'left-to-right',
                        __('Right to left', THEME_SLUG) => 'right-to-left',
                        __('Appear from center', THEME_SLUG) => "appear"
                    ),
                    'description' => __('Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.', THEME_SLUG)
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __('Extra class name', THEME_SLUG),
                    'param_name' => 'el_class',
                    'description' => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', THEME_SLUG)
                ),
                array(
                    'type' => 'css_editor',
                    'heading' => __('Css', THEME_SLUG),
                    'param_name' => 'css',
                    'group' => __('Design options', THEME_SLUG)
                )
            )
        ) );
    }


    public function map_progressbar ()
    {
        vc_map( array(
            'name' => __('Progress Bar', THEME_SLUG),
            'base' => 'vc_progress_bar',
            'icon' => 'icon-wpb-graph',
            'category' => __('Content', THEME_SLUG),
            'description' => __('Animated progress bar', THEME_SLUG),
            'params' => array(
                array(
                    'type' => 'textfield',
                    'heading' => __('Widget title', THEME_SLUG),
                    'param_name' => 'title',
                    'description' => __('Enter text which will be used as widget title. Leave blank if no title is needed.', THEME_SLUG)
                ),
                array(
                    'type' => 'exploded_textarea',
                    'heading' => __('Graphic values', THEME_SLUG),
                    'param_name' => 'values',
                    'description' => __('Input graph values, titles and color here. Divide values with linebreaks (Enter). Example: 90|Development|#e75956', THEME_SLUG),
                    'value' => "91|Front-end,80|Design"
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __('Units', THEME_SLUG),
                    'param_name' => 'units',
                    'description' => __('Enter measurement units (if needed) Eg. %, px, points, etc. Graph value and unit will be appended to the graph title.', THEME_SLUG)
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => __('Label Loction', THEME_SLUG),
                    'param_name' => 'view',
                    'value' => array(
                        __('Inside bar', THEME_SLUG) => 'inside',
                        __('On top of the bar', THEME_SLUG) => 'outside',
                    ),
                    'description' => __('Select bar background color.', THEME_SLUG),
                    'admin_label' => true
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => __('Bar color', THEME_SLUG),
                    'param_name' => 'bgcolor',
                    'value' => array(
                        __('Turquoise', THEME_SLUG) => 'bar_turquoise',
                        __('Blue', THEME_SLUG) => 'bar_blue',
                        __('Grey', THEME_SLUG) => 'bar_grey',
                        __('Green', THEME_SLUG) => 'bar_green',
                        __('Orange', THEME_SLUG) => 'bar_orange',
                        __('Red', THEME_SLUG) => 'bar_red',
                        __('Black', THEME_SLUG) => 'bar_black',
                        __('Custom Color', THEME_SLUG) => 'custom'
                    ),
                    'description' => __('Select bar background color.', THEME_SLUG),
                    'admin_label' => true
                ),
                array(
                    'type' => 'colorpicker',
                    'heading' => __('Bar custom color', THEME_SLUG),
                    'param_name' => 'custombgcolor',
                    'description' => __('Select custom background color for bars.', THEME_SLUG),
                    'dependency' => array( 'element' => 'bgcolor', 'value' => array( 'custom' ) )
                ),
                array(
                    'type' => 'checkbox',
                    'heading' => __('Options', THEME_SLUG),
                    'param_name' => 'options',
                    'value' => array(
                        __('Add Stripes?', THEME_SLUG) => 'striped',
                        __('Add animation? Will be visible with striped bars.', THEME_SLUG) => 'animated'
                    )
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __('Extra class name', THEME_SLUG),
                    'param_name' => 'el_class',
                    'description' => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', THEME_SLUG)
                )
            )
        ) );
    }


    public function map_promo_title ()
    {
        vc_map(
            array(
                "name" => __("Promo Title", THEME_SLUG),
                "base" => THEME_SLUG . "_promo_title",
                "class" => "",
                "category" => array( THEME_NAME . " " . __("Exclusive", THEME_SLUG), __('Content', THEME_SLUG) ),
                "params" => array(
                    array(
                        "type" => "textfield",
                        "holder" => "div",
                        "class" => "",
                        "heading" => __("Promo Title", THEME_SLUG),
                        "param_name" => "title",
                        "value" => __("Title", THEME_SLUG),
                        "description" => __("Title text.", THEME_SLUG),
                    ),
                    array(
                        'type' => 'textarea',
                        "holder" => "div",
                        "class" => "",
                        "heading" => __("Promo Subtitle", THEME_SLUG),
                        "param_name" => "content",
                        "value" => __("I am subtitle text. Click edit button to change this text.", THEME_SLUG),
                        "description" => __("Sutitle text.", THEME_SLUG),
                    ),
                    array(
                        'type' => 'css_editor',
                        'heading' => __('Css', THEME_SLUG),
                        'param_name' => 'css',
                        'group' => __('Design options', THEME_SLUG)
                    )
                )
            )
        );
    }


    public function map_portfolio_grid ()
    {
        vc_map(
            array(
                'name' => __('Portfolio Grid', THEME_SLUG),
                'base' => THEME_SLUG . '_portfolio_grid',
                "category" => array( (THEME_NAME . " " . __("Exclusive", THEME_SLUG)), __('Content', THEME_SLUG) ),
                'icon' => 'icon-wpb-application-icon-large',
                'description' => __('Portfolio items in grid view', THEME_SLUG),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "class" => "",
                        'heading' => __('Items per page', THEME_SLUG),
                        'param_name' => 'qty',
                        'value' => 6,
                        'description' => __('Select how many items do you want to see in this block.', THEME_SLUG)
                    ),
                    array(
                        'type' => 'css_editor',
                        'heading' => __('Css', THEME_SLUG),
                        'param_name' => 'css',
                        'group' => __('Design options', THEME_SLUG)
                    )
                )
            )
        );
    }


    public function map_clients_slider ()
    {
        vc_map(
            array(
                'name' => __('Clients Carousel', THEME_SLUG),
                'base' => THEME_SLUG . '_clients',
                'icon' => 'icon-wpb-images-carousel',
                "category" => array( THEME_NAME . " " . __("Exclusive", THEME_SLUG), __('Social', THEME_SLUG) ),
                'description' => __('Animated carousel with images', THEME_SLUG),
                'params' => array(
                    array(
                        'type' => 'attach_images',
                        'heading' => __('Images', THEME_SLUG),
                        'param_name' => 'images',
                        'value' => '',
                        'description' => __('Select images from media library.', THEME_SLUG)
                    ),
                    array(
                        "type" => "checkbox",
                        "param_name" => "popup",
                        "holder" => "div",
                        "class" => "",
                        "heading" => __("Use popup?", THEME_SLUG),
                        "description" => __("Show carousel pictures in popup?", THEME_SLUG),
                        "value" => array("Yes" => true)
                    ),
                    array(
                        "type" => "checkbox",
                        "param_name" => "autoplay",
                        "holder" => "div",
                        "class" => "",
                        "heading" => __("Use autoscroll?", THEME_SLUG),
                        "description" => __("The carousel will scrolls automatically.", THEME_SLUG),
                        "value" => array("Yes" => true)
                    ),
                )
            )
        );
    }


    public function map_facts ()
    {
        vc_map(
            array(
                'name' => __('Interesting Facts', THEME_SLUG),
                'base' => THEME_SLUG . '_facts',
                // 'icon' => 'icon-wpb-images-carousel',
                "category" => array( THEME_NAME . " " . __("Exclusive", THEME_SLUG) ),
                'description' => __('Some interesting facts with icons', THEME_SLUG),
                'params' => array(
                    array(
                        'type' => 'dropdown',
                        'heading' => __('Icon', THEME_SLUG),
                        'param_name' => 'icon',
                        'value' => array(
                            __('mobile', THEME_SLUG) => "icon-mobile",
                            __('laptop', THEME_SLUG) => "icon-laptop",
                            __('desktop', THEME_SLUG) => "icon-desktop",
                            __('tablet', THEME_SLUG) => "icon-tablet",
                            __('Phone', THEME_SLUG) => "icon-phone",
                            __('Document', THEME_SLUG) => "icon-document",
                            __('documents', THEME_SLUG) => "icon-documents",
                            __('search', THEME_SLUG) => "icon-search",
                            __('clipboard', THEME_SLUG) => "icon-clipboard",
                            __('newspaper', THEME_SLUG) => "icon-newspaper",
                            __('notebook', THEME_SLUG) => "icon-notebook",
                            __('book-open', THEME_SLUG) => "icon-book-open",
                            __('browser', THEME_SLUG) => "icon-browser",
                            __('calendar', THEME_SLUG) => "icon-calendar",
                            __('presentation', THEME_SLUG) => "icon-presentation",
                            __('picture', THEME_SLUG) => "icon-picture",
                            __('pictures', THEME_SLUG) => "icon-pictures",
                            __('video', THEME_SLUG) => "icon-video",
                            __('camera', THEME_SLUG) => "icon-camera",
                            __('printer', THEME_SLUG) => "icon-printer",
                            __('toolbox', THEME_SLUG) => "icon-toolbox",
                            __('briefcase', THEME_SLUG) => "icon-briefcase",
                            __('wallet', THEME_SLUG) => "icon-wallet",
                            __('gift', THEME_SLUG) => "icon-gift",
                            __('bargraph', THEME_SLUG) => "icon-bargraph",
                            __('grid', THEME_SLUG) => "icon-grid",
                            __('expand', THEME_SLUG) => "icon-expand",
                            __('focus', THEME_SLUG) => "icon-focus",
                            __('adjustments', THEME_SLUG) => "icon-adjustments",
                            __('ribbon', THEME_SLUG) => "icon-ribbon",
                            __('hourglass', THEME_SLUG) => "icon-hourglass",
                            __('lock', THEME_SLUG) => "icon-lock",
                            __('megaphone', THEME_SLUG) => "icon-megaphone",
                            __('shield', THEME_SLUG) => "icon-shield",
                            __('trophy', THEME_SLUG) => "icon-trophy",
                            __('flag', THEME_SLUG) => "icon-flag",
                            __('map', THEME_SLUG) => "icon-map",
                            __('puzzle', THEME_SLUG) => "icon-puzzle",
                            __('basket', THEME_SLUG) => "icon-basket",
                            __('envelope', THEME_SLUG) => "icon-envelope",
                            __('streetsign', THEME_SLUG) => "icon-streetsign",
                            __('telescope', THEME_SLUG) => "icon-telescope",
                            __('gears', THEME_SLUG) => "icon-gears",
                            __('key', THEME_SLUG) => "icon-key",
                            __('paperclip', THEME_SLUG) => "icon-paperclip",
                            __('attachment', THEME_SLUG) => "icon-attachment",
                            __('pricetags', THEME_SLUG) => "icon-pricetags",
                            __('lightbulb', THEME_SLUG) => "icon-lightbulb",
                            __('layers', THEME_SLUG) => "icon-layers",
                            __('pencil', THEME_SLUG) => "icon-pencil",
                            __('tools', THEME_SLUG) => "icon-tools",
                            __('tools-2', THEME_SLUG) => "icon-tools-2",
                            __('scissors', THEME_SLUG) => "icon-scissors",
                            __('paintbrush', THEME_SLUG) => "icon-paintbrush",
                            __('magnifying-glass', THEME_SLUG) => "icon-magnifying-glass",
                            __('circle-compass', THEME_SLUG) => "icon-circle-compass",
                            __('linegraph', THEME_SLUG) => "icon-linegraph",
                            __('mic', THEME_SLUG) => "icon-mic",
                            __('strategy', THEME_SLUG) => "icon-strategy",
                            __('beaker', THEME_SLUG) => "icon-beaker",
                            __('caution', THEME_SLUG) => "icon-caution",
                            __('recycle', THEME_SLUG) => "icon-recycle",
                            __('anchor', THEME_SLUG) => "icon-anchor",
                            __('profile-male', THEME_SLUG) => "icon-profile-male",
                            __('profile-female', THEME_SLUG) => "icon-profile-female",
                            __('bike', THEME_SLUG) => "icon-bike",
                            __('wine', THEME_SLUG) => "icon-wine",
                            __('hotairballoon', THEME_SLUG) => "icon-hotairballoon",
                            __('globe', THEME_SLUG) => "icon-globe",
                            __('genius', THEME_SLUG) => "icon-genius",
                            __('map-pin', THEME_SLUG) => "icon-map-pin",
                            __('dial', THEME_SLUG) => "icon-dial",
                            __('chat', THEME_SLUG) => "icon-chat",
                            __('heart', THEME_SLUG) => "icon-heart",
                            __('cloud', THEME_SLUG) => "icon-cloud",
                            __('upload', THEME_SLUG) => "icon-upload",
                            __('download', THEME_SLUG) => "icon-download",
                            __('target', THEME_SLUG) => "icon-target",
                            __('hazardous', THEME_SLUG) => "icon-hazardous",
                            __('piechart', THEME_SLUG) => "icon-piechart",
                            __('speedometer', THEME_SLUG) => "icon-speedometer",
                            __('global', THEME_SLUG) => "icon-global",
                            __('compass', THEME_SLUG) => "icon-compass",
                            __('lifesaver', THEME_SLUG) => "icon-lifesaver",
                            __('clock', THEME_SLUG) => "icon-clock",
                            __('aperture', THEME_SLUG) => "icon-aperture",
                            __('quote', THEME_SLUG) => "icon-quote",
                            __('scope', THEME_SLUG) => "icon-scope",
                            __('alarmclock', THEME_SLUG) => "icon-alarmclock",
                            __('refresh', THEME_SLUG) => "icon-refresh",
                            __('happy', THEME_SLUG) => "icon-happy",
                            __('sad', THEME_SLUG) => "icon-sad",
                            __('facebook', THEME_SLUG) => "icon-facebook",
                            __('twitter', THEME_SLUG) => "icon-twitter",
                            __('googleplus', THEME_SLUG) => "icon-googleplus",
                            __('rss', THEME_SLUG) => "icon-rss",
                            __('tumblr', THEME_SLUG) => "icon-tumblr",
                            __('linkedin', THEME_SLUG) => "icon-linkedin",
                            __('dribbble', THEME_SLUG) => "icon-dribbble"
                        ),
                        'description' => __('Select icon.', THEME_SLUG),
                        'admin_label' => true
                    ),
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "class" => "",
                        'heading' => __('Data', THEME_SLUG),
                        'param_name' => 'data',
                        'value' => '',
                        'description' => ''
                    ),
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "class" => "",
                        'heading' => __('Description', THEME_SLUG),
                        'param_name' => 'name',
                        'value' => '',
                        'description' => ''
                    ),
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "class" => "",
                        'heading' => __('Link', THEME_SLUG),
                        'param_name' => 'link',
                        'value' => '',
                        'description' => ''
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => __('Where to put link?', THEME_SLUG),
                        'param_name' => 'link_place',
                        'value' => array(
                            __('To icon', THEME_SLUG) => "icon",
                            __('To data', THEME_SLUG) => "data",
                            __('To description', THEME_SLUG) => "text",
                        ),
                        'admin_label' => true
                    ),
                    array(
                        "type" => "checkbox",
                        "param_name" => "target",
                        "holder" => "div",
                        "class" => "",
                        "heading" => __("Open this link in another tab?", THEME_SLUG),
                        "description" => "",
                        "value" => array('Yes' => true),
                    ),
                    array(
                        'type' => 'css_editor',
                        'heading' => __('Css', THEME_SLUG),
                        'param_name' => 'css',
                        'group' => __('Design options', THEME_SLUG)
                    )
                )
            )
        );
    }


    public function map_service ()
    {
        $services = array(
            "post_type" => THEME_SLUG . '_services',
            "post_status" => "publish",
            "posts_per_page" => -1
        );

        $services = new WP_Query($services);
        wp_reset_postdata();

        $services = $services->posts;

        $services_list = array();

        foreach ($services as $serv) {
            $services_list[$serv->post_title] = $serv->ID;
        }

        if (count($services_list) == 0)
            $services_list["-- ".__('You sould create some services before you can use this widget', THEME_SLUG)." --"] = null;

        vc_map(
            array(
                "name" => __("Service", THEME_SLUG),
                "base" => THEME_SLUG . "_service",
                "class" => "",
                "category" => array( THEME_NAME . " " . __("Exclusive", THEME_SLUG), __('Content', THEME_SLUG) ),
                "params" => array(
                    array(
                        "type" => "textfield",
                        "holder" => "div",
                        "class" => "",
                        "heading" => __("Service Title", THEME_SLUG),
                        "param_name" => "title",
                        "description" => __("Leave it blank to use your predefined service title.", THEME_SLUG),
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __('Select Servise', THEME_SLUG),
                        "param_name" => "id",
                        "description" => __("You sould create some services before you can use this widget.", THEME_SLUG),
                        "value" => $services_list
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __('Servise Layout', THEME_SLUG),
                        "param_name" => "layout",
                        "value" => array(
                            __('Block', THEME_SLUG) => 'block',
                            __('List', THEME_SLUG) => 'list'
                        )
                    ),
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "class" => "",
                        'heading' => __('Link', THEME_SLUG),
                        'param_name' => 'link',
                        'value' => '',
                        'description' => ''
                    ),
                    array(
                        "type" => "checkbox",
                        "param_name" => "target",
                        "holder" => "div",
                        "class" => "",
                        "heading" => __("Open this link in another tab?", THEME_SLUG),
                        "description" => "",
                        "value" => array('Yes' => true),
                    ),
                    array(
                        'type' => 'css_editor',
                        'heading' => __('Css', THEME_SLUG),
                        'param_name' => 'css',
                        'group' => __('Design options', THEME_SLUG)
                    )
                )
            )
        );
    }


    public function map_team_member ()
    {
        $members = array(
            "post_type" => THEME_SLUG . '_team',
            "post_status" => "publish",
            "posts_per_page" => "-1"
        );

        $members = new WP_Query($members);
        wp_reset_postdata();

        $members = $members->posts;

        $members_list = array();

        foreach ($members as $member) {
            $members_list[$member->post_title] = $member->ID;
        }

        if (count($members_list) == 0)
            $members_list["-- ".__('You sould create some team members before you can use this widget', THEME_SLUG)." --"] = null;

        vc_map(
            array(
                "name" => __("Team Member", THEME_SLUG),
                "base" => THEME_SLUG . "_team",
                "class" => "",
                "category" => array( THEME_NAME . " " . __("Exclusive", THEME_SLUG), __('Content', THEME_SLUG) ),
                "params" => array(
                    array(
                        "type" => "textfield",
                        "holder" => "div",
                        "class" => "",
                        "heading" => __("Team Member name", THEME_SLUG),
                        "param_name" => "title",
                        "description" => __("Leave it blank to use your predefined name.", THEME_SLUG),
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __('Select Team Member', THEME_SLUG),
                        "param_name" => "id",
                        "description" => __('You sould create some team members before you can use this widget.', THEME_SLUG),
                        "value" => $members_list
                    ),
                    array(
                        'type' => 'css_editor',
                        'heading' => __('Css', THEME_SLUG),
                        'param_name' => 'css',
                        'group' => __('Design options', THEME_SLUG)
                    )
                )
            )
        );
    }


    public function map_widget_get_in_touch ()
    {
        vc_map(
            array(
                "name" => __("Get In Touch", THEME_SLUG),
                "base" => THEME_SLUG . "_get_in_touch",
                "class" => "",
                "category" => array( THEME_NAME . " " . __("Exclusive", THEME_SLUG), __('Content', THEME_SLUG) ),
                "params" => array(
                    array(
                        "type" => "textfield",
                        "holder" => "div",
                        "class" => "",
                        "heading" => __("Adress", THEME_SLUG),
                        "param_name" => "address",
                        // "value" => null,
                        "description" => __('Ex: "Address: 455 Martinson, Los Angeles"', THEME_SLUG),
                    ),
                    array(
                        "type" => "textfield",
                        "holder" => "div",
                        "class" => "",
                        "heading" => __("Phone", THEME_SLUG),
                        "param_name" => "phone",
                        // "value" => null,
                        "description" => __('Ex: "Phone: 8 (043) 567 - 89 - 30"', THEME_SLUG),
                    ),
                    array(
                        "type" => "textfield",
                        "holder" => "div",
                        "class" => "",
                        "heading" => __("Fax", THEME_SLUG),
                        "param_name" => "fax",
                        // "value" => null,
                        "description" => __('Ex: "Fax: 8 (057) 149 - 24 - 64"', THEME_SLUG),
                    ),
                    array(
                        "type" => "textfield",
                        "holder" => "div",
                        "class" => "",
                        "heading" => __("Skype", THEME_SLUG),
                        "param_name" => "skype",
                        // "value" => null,
                        "description" => __('Ex: "Skype: companyname"', THEME_SLUG),
                    ),
                    array(
                        "type" => "textfield",
                        "holder" => "div",
                        "class" => "",
                        "heading" => __("Email", THEME_SLUG),
                        "param_name" => "email",
                        // "value" => null,
                        "description" => __('Your e-mail will be published with "antispambot" protection.<br/>Ex: "E-mail: support@email.com"', THEME_SLUG),
                    ),
                    array(
                        "type" => "textfield",
                        "holder" => "div",
                        "class" => "",
                        "heading" => __("Weekend", THEME_SLUG),
                        "param_name" => "weekend",
                        // "value" => null,
                        "description" => __('Ex: "Weekend: from 9 am to 6 pm"', THEME_SLUG),
                    ),
                )
            )
        );
    }




  public function map_testimonials ()
    {
        $testimonials = array(
            "post_type" => THEME_SLUG . '_testimonials',
            "post_status" => "publish",
            "posts_per_page" => -1
        );

        $testimonials = new WP_Query($testimonials);
        wp_reset_postdata();

        $testimonials = $testimonials->posts;

        $testimonials_list = array();

        foreach ($testimonials as $testimon) {
            $testimonials_list[$testimon->post_title] = $testimon->ID;
        }

        if (count($testimonials_list) == 0)
            $testimonials_list["-- ".__('You sould create some services before you can use this widget', THEME_SLUG)." --"] = null;

        $params = array(
          "name" => __("Testimonials", THEME_SLUG),
          "base" => THEME_SLUG . '_testimonials',
          "class" => "",
          "category" => array( THEME_NAME . " " . __("Exclusive", THEME_SLUG), __('Content', THEME_SLUG) ),
          "params" => array(
            array(
              "type" => "dropdown",
              "heading" => __('Select Testimonials', THEME_SLUG),
              "param_name" => "id",
              "description" => __("You sould create some testimonials before you can use this widget.", THEME_SLUG),
              "value" => $testimonials_list
            ),
            array(
              'type' => 'css_editor',
              'heading' => __('Css', THEME_SLUG),
              'param_name' => 'css',
              'group' => __('Design options', THEME_SLUG)
            )
          )
        );

        vc_map($params);
    }
}
