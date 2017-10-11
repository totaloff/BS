<?php

new PhoenixTeam_Testimonials();

class PhoenixTeam_Testimonials {

    public function __construct ()
    {
        // Add our Testimonials Type
        add_action('init', array($this, 'create_testimonials'));
        add_action('admin_head', array($this, 'remove_revolution_slider_metabox'));
    }
    
    function create_testimonials ()
    {        
        // Register Custom Post Type
        register_post_type(THEME_SLUG . '_testimonials',
            array(
                'labels' => array(
                    'name' => __('Testimonials', THEME_SLUG),
                    'singular_name' => __('Testimonial', THEME_SLUG),
                    'menu_name' => __('Testimonials', THEME_SLUG),
                    'add_new' => __('Add New', THEME_SLUG),
                    'add_new_item' => __('Add New Testimonial', THEME_SLUG),
                    'edit' => __('Edit', THEME_SLUG),
                    'edit_item' => __('Edit Testimonial', THEME_SLUG),
                    'new_item' => __('New Testimonial', THEME_SLUG),
                    'view' => __('View Testimonials', THEME_SLUG),
                    'view_item' => __('View Testimonial', THEME_SLUG),
                    'search_items' => __('Search Testimonials', THEME_SLUG),
                    'not_found' => __('No Testimonials found', THEME_SLUG),
                    'not_found_in_trash' => __('No Testimonials found in Trash', THEME_SLUG)
                ),
                'publicly_queryable' => true,
                'show_ui' => true,
                'show_in_nav_menus' => false,
                'show_in_menu' => true,
                'menu_position' => 5,
                'menu_icon' => 'dashicons-megaphone',
                // Allows your posts to behave like Hierarchy Pages
                'hierarchical' => false,
                'has_archive' => false,
                'supports' => array(
                    'title'
                ),
                // Allows export in Tools > Export
                'can_export' => true,
            )
        );
    }

    public function remove_revolution_slider_metabox ()
    {
        remove_meta_box('mymetabox_revslider_0', THEME_SLUG . '_testimonials', 'normal');
    }

}
