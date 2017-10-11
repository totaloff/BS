<?php

new PhoenixTeam_Services();

class PhoenixTeam_Services {

    public function __construct ()
    {
        // Add our Services Type
        add_action('init', array($this, 'create_services'));
        add_action('admin_head', array($this, 'remove_revolution_slider_metabox'));
    }
    
    function create_services ()
    {        
        // Register Custom Post Type
        register_post_type(THEME_SLUG . '_services',
            array(
                'labels' => array(
                    'name' => __('Services', THEME_SLUG),
                    'singular_name' => __('Service', THEME_SLUG),
                    'menu_name' => __('Services', THEME_SLUG),
                    'add_new' => __('Add New', THEME_SLUG),
                    'add_new_item' => __('Add New Service Item', THEME_SLUG),
                    'edit' => __('Edit', THEME_SLUG),
                    'edit_item' => __('Edit Service Item', THEME_SLUG),
                    'new_item' => __('New Service Item', THEME_SLUG),
                    'view' => __('View', THEME_SLUG),
                    'view_item' => __('View Service Item', THEME_SLUG),
                    'search_items' => __('Search Service Items', THEME_SLUG),
                    'not_found' => __('No Service Items found', THEME_SLUG),
                    'not_found_in_trash' => __('No Service Item found in Trash', THEME_SLUG)
                ),
                'publicly_queryable' => true,
                'show_ui' => true,
                'show_in_nav_menus' => false,
                'show_in_menu' => true,
                'menu_position' => 5,
                'menu_icon' => 'dashicons-marker',
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
        remove_meta_box('mymetabox_revslider_0', THEME_SLUG . '_services', 'normal');
    }

}
