<?php

new PhoenixTeam_Team();

class PhoenixTeam_Team {

    public function __construct ()
    {
        // Add our Testimonials Type
        add_action('init', array($this, 'create_team'));
        add_action('admin_head', array($this, 'remove_revolution_slider_metabox'));
    }
    
    function create_team ()
    {        
        // Register Custom Post Type
        register_post_type(THEME_SLUG . '_team',
            array(
                'labels' => array(
                    'name' => __('Team Members', THEME_SLUG),
                    'singular_name' => __('Team Member', THEME_SLUG),
                    'menu_name' => __('Team', THEME_SLUG),
                    'add_new' => __('Add New', THEME_SLUG),
                    'add_new_item' => __('Add New Team Member', THEME_SLUG),
                    'edit' => __('Edit', THEME_SLUG),
                    'edit_item' => __('Edit Team Member', THEME_SLUG),
                    'new_item' => __('New Team Member', THEME_SLUG),
                    'view' => __('View ', THEME_SLUG),
                    'view_item' => __('View Team Member', THEME_SLUG),
                    'search_items' => __('Search Team Members', THEME_SLUG),
                    'not_found' => __('No Team Members found', THEME_SLUG),
                    'not_found_in_trash' => __('No Team Members found in Trash', THEME_SLUG)
                ),
                'publicly_queryable' => true,
                'show_ui' => true,
                'show_in_nav_menus' => false,
                'show_in_menu' => true,
                'menu_position' => 5,
                'menu_icon' => 'dashicons-businessman',
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
        remove_meta_box('mymetabox_revslider_0', THEME_SLUG . '_team', 'normal');
    }

}
