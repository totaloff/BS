<?php

new PhoenixTeam_Portfolio();

class PhoenixTeam_Portfolio {

    public function __construct ()
    {
        // Add our Portfolio Type
        add_action('init', array($this, 'create_portfolio'));
        add_action('init', array($this, 'create_taxonomy'));
        add_action('admin_head', array($this, 'remove_revolution_slider_metabox'));
    }
    
    function create_portfolio ()
    {        
        // Register Custom Post Type
        register_post_type(THEME_SLUG . '_portfolio',
            array(
                'labels' => array(
                    'name' => __('Portfolio', THEME_SLUG),
                    'singular_name' => __('Portfolio Item', THEME_SLUG),
                    'menu_name' => __('Portfolio', THEME_SLUG),
                    'add_new' => __('Add New', THEME_SLUG),
                    'add_new_item' => __('Add New Portfolio Item', THEME_SLUG),
                    'edit' => __('Edit', THEME_SLUG),
                    'edit_item' => __('Edit Portfolio Item', THEME_SLUG),
                    'new_item' => __('New Portfolio Item', THEME_SLUG),
                    'view' => __('View Portfolio', THEME_SLUG),
                    'view_item' => __('View Portfolio Item', THEME_SLUG),
                    'search_items' => __('Search Portfolio Items', THEME_SLUG),
                    'not_found' => __('No Portfolio Items found', THEME_SLUG),
                    'not_found_in_trash' => __('No Portfolio Items found in Trash', THEME_SLUG)
                ),
                // Visual Composer
                // 'public' => true,
                // Visual Composer
                'publicly_queryable' => true,
                'show_ui' => true,
                'show_in_nav_menus' => false,
                // 'show_in_nav_menus' => true,
                'show_in_menu' => true,
                'menu_position' => 5,
                'menu_icon' => 'dashicons-portfolio',
                'capability_type' => 'post',
                // Allows your posts to behave like Hierarchy Pages
                'hierarchical' => false,
                'rewrite' => array(
                    'slug'          => 'port-folio',
                    'with_front'    => true
                ),
                'has_archive' => false,
                'supports' => array(
                    'title',
                    'thumbnail'
                ),
                // Allows export in Tools > Export
                'can_export' => true,
                // Add Category and Post Tags support
                'taxonomies' => array(
                    THEME_SLUG . '_portfolio_category'
                )
            )
        );
    }

    public function create_taxonomy ()
    {
        // Register Taxonomy for Portfolio
        register_taxonomy( THEME_SLUG . '_portfolio_category', THEME_SLUG . '_portfolio',
            array(
                'labels' => array(
                        'name'              => _x( 'Categories', 'taxonomy general name', THEME_SLUG ),
                        'singular_name'     => _x( 'Category', 'taxonomy singular name', THEME_SLUG ),
                        'search_items'      => __( 'Search Categories', THEME_SLUG ),
                        'all_items'         => __( 'All Categories', THEME_SLUG ),
                        'parent_item'       => __( 'Parent Category', THEME_SLUG ),
                        'parent_item_colon' => __( 'Parent Category:', THEME_SLUG ),
                        'edit_item'         => __( 'Edit Category', THEME_SLUG ),
                        'update_item'       => __( 'Update Category', THEME_SLUG ),
                        'add_new_item'      => __( 'Add New Category', THEME_SLUG ),
                        'new_item_name'     => __( 'New Category Name', THEME_SLUG ),
                        'menu_name'         => __( 'Categories', THEME_SLUG ),
                    ),
                'hierarchical'      => true,
                'show_ui'           => true,
                'show_admin_column' => true,
                'query_var'         => false,
                'rewrite'           => array('slug' => 'category'),
                'sort'              => true
            )
        );
    }

    public function remove_revolution_slider_metabox ()
    {
        remove_meta_box('mymetabox_revslider_0', THEME_SLUG . '_portfolio', 'normal');
    }

}
