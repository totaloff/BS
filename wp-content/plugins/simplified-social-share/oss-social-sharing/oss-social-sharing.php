<?php

// Exit if called directly
if (!defined('ABSPATH')) {
    exit();
}

if ( ! class_exists( 'OSS_Social_Sharing' ) ) {

    /**
     * The main class and initialization point of the plugin.
     */
    class OSS_Social_Sharing {

        /**
         * Constructor
         */
        public function __construct() {

            // Register Activation hook callback.
            $this->install();

            // Declare constants and load dependencies.
            $this->define_constants();
            $this->load_dependencies();

            add_action('wp_enqueue_scripts', array($this, 'enqueue_front_scripts'), 5);
            add_action('wp_enqueue_scripts', array($this, 'enqueue_widget_scripts'), 5);
            add_action('oss_admin_page', array($this, 'create_opensocialshare_menu'), 3);
            
        }

        function create_opensocialshare_menu() {

            if ( ! class_exists( 'OSS_Social_Login' ) ) {
                // Create Menu.		
                add_menu_page('OpenSocialShare', 'Social Sharing', 'manage_options', 'social9_share', array('OSS_Social_Share_Admin', 'options_page'), OSS_CORE_URL . 'assets/images/favicon.ico' );
            } else {
                // Add Social Sharing menu.
                add_submenu_page('OpenSocialShare', 'Social Sharing Settings', 'Social Sharing', 'manage_options', 'social9_share', array('OSS_Social_Share_Admin', 'options_page'));
            }
        }

        /**
         * Function for setting default options while plgin is activating.
         */
        public static function install() {
            global $wpdb;
            require_once ( dirname(__FILE__) . '/install.php' );
            if (function_exists('is_multisite') && is_multisite()) {
                // check if it is a network activation - if so, run the activation function for each blog id
                $old_blog = $wpdb->blogid;
                // Get all blog ids
                $blogids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
                foreach ($blogids as $blog_id) {
                    switch_to_blog($blog_id);
                    OSS_Sharing_Install::set_default_options();
                }
                switch_to_blog($old_blog);
                return;
            } else {
                OSS_Sharing_Install::set_default_options();
            }
        }

        /**
         * Define constants needed across the plug-in.
         */
        private function define_constants() {
            define('OSS_SHARE_PLUGIN_DIR', plugin_dir_path(__FILE__));
            define('OSS_SHARE_PLUGIN_URL', plugin_dir_url(__FILE__));
        }

        public static function enqueue_front_scripts() {
            wp_enqueue_style('oss-social-sharing-front', OSS_SHARE_PLUGIN_URL . 'assets/css/oss-social-sharing-front.css', array());
        }
        public static function enqueue_widget_scripts() {
            wp_enqueue_style('oss-share-widget-style', 'https://sharecdn.social9.com/v2/css/os-share-widget-style.css');
        }

        /**
         * Loads PHP files that required by the plug-in
         *
         * @global opensocialshare_commenting_settings
         */
        private function load_dependencies() {
            global $oss_share_settings;

            $oss_share_settings = get_option( 'OpenSocialShare_share_settings' );
            // Load OpenSocialShare files.
            require_once( OSS_SHARE_PLUGIN_DIR . 'admin/open-social-share-admin.php' );
            require_once( OSS_SHARE_PLUGIN_DIR . 'admin/open-social-share-advance-settings.php' );
            if ((isset($oss_share_settings['horizontal_enable']) && $oss_share_settings['horizontal_enable'] == 1)||(isset($oss_share_settings['vertical_enable']) && $oss_share_settings['vertical_enable'] == 1)) {
                require_once( OSS_SHARE_PLUGIN_DIR . 'includes/common/sharing.php' );
                require_once( OSS_SHARE_PLUGIN_DIR . 'includes/shortcode/shortcode.php' );
            }else {
                require_once( OSS_SHARE_PLUGIN_DIR . 'includes/shortcode/shortcode.php' );
                  echo do_shortcode('[emptyCode]');
                
            }
            if(isset($oss_share_settings['horizontal_enable']) && $oss_share_settings['horizontal_enable'] == 1){
                require_once( OSS_SHARE_PLUGIN_DIR . 'includes/horizontal/oss-simplified-social-share-horizontal.php' );
                require_once( OSS_SHARE_PLUGIN_DIR . 'includes/widgets/oss-horizontal-share-widget.php' );
            }
            if(isset($oss_share_settings['vertical_enable']) && $oss_share_settings['vertical_enable'] == 1) {
                require_once( OSS_SHARE_PLUGIN_DIR . 'includes/vertical/oss-simplified-social-share-vertical.php' );
                require_once( OSS_SHARE_PLUGIN_DIR . 'includes/widgets/oss-vertical-share-widget.php' );
            }
            
        }

    }

    new OSS_Social_Sharing();
}
