<?php

class PhoenixTeam_Admin_Scripts {

    public function __construct ()
    {
        // add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts')); // Add Custom Scripts to wp_head
        add_action('admin_print_scripts', array($this, 'conditional_scripts')); // Add Conditional Page Scripts
    }

    // Enqueue scripts
    public function enqueue_scripts ()
    {

    }

    // Load conditional scripts
    public function conditional_scripts ()
    {
        global $reduxConfig;
        wp_register_script(THEME_SLUG . '-page', THEME_ADMIN_URI . '/assets/js/page.js', array('jquery'), '1.0.0', true);
        wp_register_script(THEME_SLUG . '-post-formats', THEME_ADMIN_URI . '/assets/js/post-formats.js', array('jquery'), '1.0.0', true);
        wp_register_script(THEME_SLUG . '-post-type-team', THEME_ADMIN_URI . '/assets/js/team.js', array('jquery'), '1.0.0', true);
        wp_register_script(THEME_SLUG . '-post-type-services', THEME_ADMIN_URI . '/assets/js/services.js', array('jquery'), '1.0.0', true);
        wp_register_script('woo-products', THEME_ADMIN_URI . '/assets/js/woo-products.js', array('jquery'), '1.0.0', true);
        wp_register_script('options-devmode', THEME_ADMIN_URI . '/assets/js/options-devmode.js', array('jquery'), '1.0.0', true);

        $adminData = array(
            'THEME_SLUG' => THEME_SLUG,
            'teamFieldsMatchErr' => __("Number of \"Social Networks\" fields and\n\"Social URLs\" fields must match!", THEME_SLUG),
            'teamFieldaFilledErr' => __("All fields of \"Social Networks\" group\nmust be filled!", THEME_SLUG),
            'serviceIconDescription' => __('Select an icon for your service item. Icons belong to <a href="http://fortawesome.github.io/Font-Awesome/" target="_blank">FontAwesome</a>, the iconic font designed for Bootstrap.', THEME_SLUG)
        );
        wp_localize_script('jquery', THEME_TEAM, $adminData);

        $screen = get_current_screen();
        switch ($screen->id) {
            case 'post':
                wp_enqueue_script(THEME_SLUG . '-post-formats');
                break;
            case 'page':
                wp_enqueue_script(THEME_SLUG . '-page');
                break;
            case  THEME_SLUG . '_portfolio':
                wp_enqueue_style(THEME_SLUG . '-portfolio');
                break;
            case THEME_SLUG . '_team':
                wp_enqueue_script(THEME_SLUG . '-post-type-team');
                break;
            case THEME_SLUG . '_services':
                wp_enqueue_script(THEME_SLUG . '-post-type-services');
                break;
            case THEME_SLUG . '_testimonials':
                // nothing yet
                break;
            case 'product':
                wp_enqueue_script('woo-products');
                break;
            case 'toplevel_page_'. THEME_SLUG .'_options':
                if ($reduxConfig->args['dev_mode']) {
                    wp_enqueue_script('options-devmode');
                }
                break;
        }
    }

}

new PhoenixTeam_Admin_Scripts();
