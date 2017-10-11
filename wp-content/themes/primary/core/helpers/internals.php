<?php

class PhoenixTeam_Theme_Internals {

    public function __construct ()
    {
        global $PhoenixData;
        $admin_bar = isset($PhoenixData['show_adminbar']) ? $PhoenixData['show_adminbar'] : true;

        // Add title tag settings
        add_filter('wp_title', array($this, 'wp_title'), 10, 2);

        // Add '...' button instead of [...] for Excerpts
        add_filter('excerpt_more', array($this, 'setCustomExcerpt'));

        // Add slug to body class (Starkers build)
        add_filter('body_class', array($this, 'add_slug_to_body_class'));

        add_filter('get_search_form', array($this, 'filter_search_form'));

        add_filter('wp_list_categories', array($this, 'add_span_cat_count'));

        add_filter('get_avatar', array($this, 'change_avatar_css_class'));

        // Enable Threaded Comments
        add_action('get_header', array($this, 'enable_threaded_comments'));

        // Add Subtitles to pages & posts
        add_action('edit_form_after_title', array($this, 'add_subtitle_field'));

        // Add thumbnails to list of posts in admin area
        add_filter('manage_posts_columns', array($this, 'add_thumb_column'));
        add_action('manage_posts_custom_column', array($this, 'add_thumb_value'), 10, 2);

        // Add portfolio ajax loaders
        add_action('wp_ajax_' . THEME_SLUG . '_get_more_portfolio', array($this, 'more_portfolio'));
        add_action('wp_ajax_nopriv_' . THEME_SLUG . '_get_more_portfolio', array($this, 'more_portfolio'));
        add_action('wp_ajax_' . THEME_SLUG . '_get_inline_portfolio', array($this, 'inline_portfolio'));
        add_action('wp_ajax_nopriv_' . THEME_SLUG . '_get_inline_portfolio', array($this, 'inline_portfolio'));

        add_action('admin_bar_menu', array($this, 'adminbar_menu'), 1000);

        // Remove Admin bar
        if (!$admin_bar) {
            show_admin_bar( false );
        }
    }


    // Custom 'More' link to Post
    public function setCustomExcerpt ($more)
    {
        global $post;
        return '...';
    }


    // Add page slug to body class, love this - Credit: Starkers Wordpress Theme
    public function add_slug_to_body_class($classes)
    {
        global $post;
        if (is_home()) {
            $key = array_search('blog', $classes);
            if ($key > -1) {
                unset($classes[$key]);
            }
        } elseif (is_page()) {
            $classes[] = sanitize_html_class($post->post_name);
        } elseif (is_singular()) {
            $classes[] = sanitize_html_class($post->post_name);
        }

        return $classes;
    }


    public function filter_search_form ($form)
    {
        $form = null;
        $form .= '<form role="search" method="get" id="searchform" class="searchform" action="' . esc_url(home_url( '/' )) . '" >';
        $form .= '<input id="s-input" name="s" type="text" placeholder="'. __("Search...", THEME_SLUG) .'" value="'. esc_attr(get_search_query()) .'" />';
        $form .= '</form>';

        return $form;
    }


    public function change_avatar_css_class ($class)
    {
        $class = str_replace("class='avatar", "class='avatar img_comm", $class) ;
        return $class;
    }


    public function enable_threaded_comments ()
    {
        global $PhoenixData;
        $page_comments = isset($PhoenixData['page_display_comments']) ?$PhoenixData['page_display_comments'] : 0;

        if (!is_admin()) {
            if (is_singular() && comments_open() && (get_option('thread_comments') == 1)) {
                wp_enqueue_script('comment-reply');
            }
            if ($page_comments && is_page() && comments_open() && (get_option('thread_comments') == 1)) {
                wp_enqueue_script('comment-reply');
            }
        }
    }


    public function add_subtitle_field ()
    {
        $screen = get_current_screen();

        if (
            $screen->post_type == 'page'
            || $screen->post_type == 'post'
            || $screen->post_type == THEME_SLUG . '_portfolio'
            || $screen->post_type == 'product'
           )
        {
            $sub = rwmb_meta(THEME_SLUG . '_subtitle');
            $margin_top = ($screen->post_type == THEME_SLUG . '_portfolio') ? '11' : '5';

            // echo script, related to the inputfield.
            echo "<script>
                jQuery(function($) {
                    'use strict';\n
                    var ". THEME_SLUG . "AwesomeSubtitle = $('<input />', {
                        type: 'text',
                        id: '". THEME_SLUG . "_subtitle_hooked "."',
                        name: '". THEME_SLUG . "_subtitle_hooked "."',
                        'class': 'widefat',
                        value: '". esc_js($sub) ."',
                        placeholder: '". __("Subtitle", THEME_SLUG) ."',
                        style: 'margin-top: ". esc_js($margin_top) ."px; line-height: 19px; margin-bottom: 0;',
                        tabindex: '1'
                    }).insertAfter($('#titlediv .inside'));\n" .

                    "setTimeout(function() {\n
                        var vcSwitch = $('.composer-switch');\n
                        if (vcSwitch.length == 1) {
                            ". THEME_SLUG . "AwesomeSubtitle.css('margin-bottom', '20px');
                        }
                    }, 1000);\n" .

                    "var hidden = $('[name = " . THEME_SLUG . "_subtitle]');\n" .
                    THEME_SLUG ."AwesomeSubtitle.change(function() {
                        hidden.val(". THEME_SLUG ."AwesomeSubtitle.val());
                    });
                });" .
            "</script>";
        }
        return false;
    }

    public function add_thumb_column ($cols)
    {
        $cols['thumbnail'] = __('Thumbnail', THEME_SLUG);
        return $cols;
    }


    public function add_thumb_value ($column_name, $post_id)
    {
        $width = (int) 60;
        $height = (int) 60;

        if ( 'thumbnail' == $column_name ) {
            $thumbnail_id = get_post_meta( $post_id, '_thumbnail_id', true );

            $children = array(
                'post_parent' => $post_id,
                'post_type' => 'attachment',
                'post_mime_type' => 'image'
            );

            $attachments = get_children($children);

            if ($thumbnail_id) {
                $thumb = wp_get_attachment_image( $thumbnail_id, array($width, $height), true );
            } elseif ($attachments) {
                foreach ( $attachments as $attachment_id => $attachment ) {
                    $thumb = wp_get_attachment_image( $attachment_id, array($width, $height), true );
                }
            }
            if ( isset($thumb) && $thumb ) {
                echo wp_kses(
                    $thumb,
                    array('img' => array(
                            'src' => array(),
                            'alt' => array()
                        )
                    ),
                    array('http', 'https')
                );
            } else {
                _e('None', THEME_SLUG);
            }
        }
    }


    public function more_portfolio ()
    {
        $args = unserialize(stripslashes($_POST['query']));
        $args['paged'] = $_POST['page'] + 1; // next page

        $query = new WP_Query($args);

        while($query->have_posts()) {
            $query->the_post();

            $ID = get_the_id();

            $the_cat = get_the_terms( $ID , THEME_SLUG . '_portfolio_category');
            $categories = '';
            if (is_array($the_cat)) {
                foreach($the_cat as $cur_term) {
                    $categories .= $cur_term->slug . ' ';
                }
            }

            $thumb_params = array('width' => 800,'height' => 600, 'crop' => true);
            $thumb = null;

            $title = get_the_title();
            $author = rwmb_meta(THEME_SLUG . '_portfolio_author');
            $link = get_permalink();

            if (has_post_thumbnail()) {
                $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($ID), 'full', true );
                $thumb = $thumb[0];
            } else {
                $thumb = THEME_URI . "/assets/images/nopicture.png";
            }
?>
            <li class="cbp-item <?php echo esc_attr($categories); ?>">
                <div class="cbp-item-wrapper">
                    <div class="portfolio-phoenixteam"><div class="portfolio-image"><?php if ($thumb) echo '<img src="'. bfi_thumb( $thumb, $thumb_params ) .'" alt="'. esc_attr($title) .'" />'; ?>
                        <figcaption>
                            <p class="icon-links">
                                <a href="<?php echo site_url() . "/wp-admin/admin-ajax.php?p=".esc_attr($ID); ?>" class="cbp-singlePageInline"><i class="icon-attachment"></i></a>
                                <a href="<?php echo esc_url($thumb); ?>" class="cbp-lightbox" data-title="<?php echo esc_attr($title); ?>"><i class="icon-magnifying-glass"></i></a>
                            </p>
                        </figcaption>
                    </div>
                    <h2><?php echo esc_html($title); ?></h2>
                    <p><?php _e('by', THEME_SLUG); ?> <?php echo esc_html($author); ?></p>
                    </div>
                </div>
            </li>
<?php
        }
        wp_reset_postdata();
        die;
    }


    public function inline_portfolio ()
    {
        check_ajax_referer(THEME_SLUG . "-port-security", 'security');

        global $PhoenixData;

        $id = parse_url($_GET['url']);
        $args = "post_type=".THEME_SLUG."_portfolio&{$id['query']}&showposts=1";

        $query = new WP_Query($args);

        while($query->have_posts()) {
            $query->the_post();

            $ID = get_the_id();

            $thumb_params = array('width' => 800,'height' => 600);
            $thumb = null;

            $title = get_the_title();
            $author = rwmb_meta(THEME_SLUG . '_portfolio_author');
            $description = rwmb_meta(THEME_SLUG . '_portfolio_description');
            $link = get_permalink();

            $use_gallery = isset($PhoenixData['port_inline_gallery']) ? $PhoenixData['port_inline_gallery'] : false;

            if (has_post_thumbnail()) {
                $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($ID), 'full', true );
                $thumb = array('full_url' => $thumb[0]);
            } else {
                $thumb = false;
            }

            if ($use_gallery) {
                $gallery = rwmb_meta(THEME_SLUG . "_portfolio_gallery", array('type' => 'image_advanced'));

                if ($thumb)
                    array_unshift($gallery, $thumb);

            } else {
                if (!$thumb)
                    $thumb = array('full_url' => THEME_URI . "/assets/images/nopicture.png");

                $gallery = array($thumb);
            }
?>
            <div class="cbp-l-inline">
                <div class="cbp-l-inline-left">

<?php
                    if (count($gallery)) :
?>
                        <ul id="bxslider-<?php echo $ID; ?>" class="bxslider">
<?php
                            foreach ($gallery as $item) {
                              echo '<li><img src="'. bfi_thumb($item['full_url'], $thumb_params) .'" alt="" class="cbp-l-project-img"></li>';
                            }
?>
                        </ul>
<?php
                    endif;
?>

                    <?php // if ($thumb) echo '<img src="'. esc_url(bfi_thumb($thumb, $thumb_params)) .'" alt="'. esc_attr( $title ) .'" class="cbp-l-project-img" />'; ?>
                </div>
                <div class="cbp-l-inline-right">
                    <div class="cbp-l-inline-title"><?php echo esc_html($title); ?></div>
                    <div class="cbp-l-inline-subtitle"><?php if ($author) { echo __('by', THEME_SLUG) ." ". esc_html( $author );} ?></div>
                    <div class="cbp-l-inline-desc"><?php echo wp_kses_post( $description ); ?></div>
                    <a href="<?php echo esc_url($link); ?>" target="_blank" class="btn-simple"><?php _e('View Project', THEME_SLUG); ?></a>
                </div>
            </div>

            <?php if (count($gallery) && $use_gallery) : ?>
                <!-- bxslider init -->
                <script type="text/javascript">
                    jQuery(function() {
                        jQuery('#bxslider-<?php echo $ID; ?>').bxSlider({
                            adaptiveHeight: true,
                            mode: 'fade',
                            slideMargin: 0,
                            pager: false,
                            controls: true
                        });
                    });
              </script>
            <?php endif; ?>
<?php
        }
        wp_reset_postdata();
        die;
    }

    public function adminbar_menu ()
    {
        if (!is_super_admin() || !is_admin_bar_showing())
            return;

        global $wp_admin_bar;

        $wp_admin_bar->add_menu(
            array(
                'id' => THEME_SLUG . '_support',
                'meta' => array('title' => __('Support', THEME_SLUG), 'target' => '_blank'),
                'title' => THEME_NAME . " ". __('Support', THEME_SLUG),
                'href' => 'http://themeforest.net/user/PhoenixTeam'
            )
        );
    }


    public function add_span_cat_count ($links)
    {
        $links = str_replace('</a> (', '</a> <span class="oi_cat_count">', $links);
        $links = str_replace(')', '</span>', $links);

        return $links;
    }


    public function wp_title ($title, $sep)
    {
        global $paged, $page;

        $title = str_replace('&raquo;', '' , $title);

        if ( is_feed() )
            return $title;

        // Add the site name.
        $title = get_bloginfo( 'name' ) . ' : ' . $title;

        // Add the site description for the home/front page.
        $site_description = get_bloginfo( 'description', 'display' );
        if ( $site_description && ( is_home() || is_front_page() ) )
            $title = $title .' : '. $site_description;

        // Add a page number if necessary.
        if ( $paged >= 2 || $page >= 2 )
            $title = $title .' : ' . sprintf( __( 'Page %s', THEME_SLUG ), max( $paged, $page ) );

        return $title;
    }


}

new PhoenixTeam_Theme_Internals();