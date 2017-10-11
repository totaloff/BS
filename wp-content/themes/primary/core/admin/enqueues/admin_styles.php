<?php

class PhoenixTeam_Admin_Styles {

    public function __construct ()
    {
        add_action('admin_enqueue_styles', array($this, 'enqueue_styles')); // Add CSS to wp_head
        add_action('admin_print_styles', array($this, 'conditional_styles')); // Add Conditional Page CSS
    }

    // Enqueue styles
    public function enqueue_styles ()
    {

    }

    // Load conditional styles
    public function conditional_styles ()
    {
        wp_register_style(THEME_SLUG . '-options', THEME_ADMIN_URI . '/assets/css/options.css', array(), '1.0', 'all');
        wp_register_style(THEME_SLUG . '-post', THEME_ADMIN_URI . '/assets/css/post.css', array(), '1.0', 'all');
        wp_register_style(THEME_SLUG . '-page', THEME_ADMIN_URI . '/assets/css/page.css', array(), '1.0', 'all');
        wp_register_style(THEME_SLUG . '-services', THEME_ADMIN_URI . '/assets/css/services.css', array(), '1.0', 'all');
        wp_register_style(THEME_SLUG . '-fontawesome', THEME_URI . '/assets/css/font-awesome.min.css', array(), '4.1.0', 'all');
        wp_register_style(THEME_SLUG . '-et-line', THEME_URI . '/assets/css/et-line.css', array(), '1.0.0', 'all');
        wp_register_style(THEME_SLUG . '-portfolio', THEME_ADMIN_URI . '/assets/css/portfolio.css', array(), '1.0', 'all');
        wp_register_style(THEME_SLUG . '-team', THEME_ADMIN_URI . '/assets/css/team.css', array(), '1.0', 'all');
        wp_register_style(THEME_SLUG . '-testimonials', THEME_ADMIN_URI . '/assets/css/testimonials.css', array(), '1.0', 'all');

        $screen = get_current_screen();

        switch ($screen->id) {
            case 'toplevel_page_' . THEME_SLUG . '_options':
                wp_enqueue_style(THEME_SLUG . '-options');
                break;
            case 'post':
                wp_enqueue_style(THEME_SLUG . '-post');
                break;
            case 'page':
                wp_enqueue_style(THEME_SLUG . '-page');
                break;
            case  THEME_SLUG . '_portfolio':
                wp_enqueue_style(THEME_SLUG . '-portfolio');
                break;
            case THEME_SLUG . '_team':
                wp_enqueue_style(THEME_SLUG . '-team');
                break;
            case THEME_SLUG . '_services':
                wp_enqueue_style(THEME_SLUG . '-fontawesome');
                wp_enqueue_style(THEME_SLUG . '-et-line');
                wp_enqueue_style(THEME_SLUG . '-services');
                break;
            case THEME_SLUG . '_testimonials':
                wp_enqueue_style(THEME_SLUG . '-testimonials');
                break;
        }
    }

}

new PhoenixTeam_Admin_Styles();
