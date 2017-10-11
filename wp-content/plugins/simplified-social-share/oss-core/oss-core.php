<?php

// Exit if called directly
if ( ! defined( 'ABSPATH' ) ) {
    exit();
}

if ( ! class_exists( 'OSS_Core' ) ) {

    /**
     * The main class and initialization point of the plugin.
     */
    class OSS_Core {

        /**
         * Constructor
         */
        public function __construct() {
            // Declare constants and register files.
            add_action('oss_reset_admin_action',array($this,'reset_settings_action'),10,2);
            add_action('wp_enqueue_scripts', array($this, 'register_scripts_styles'));
            add_action('admin_enqueue_scripts', array($this, 'register_admin_files'));
            add_action('login_enqueue_scripts', array($this, 'register_scripts_styles'));
            add_action('admin_menu', array($this, 'create_opensocialshare_menu'));
            add_filter('plugin_action_links', array($this, 'opensocialshare_login_setting_links'), 10, 2);
            add_action('oss_reset_admin_ui',array($this,'reset_settings'));
            $this->define_constants();
            $this->load_dependencies();
        }

        /**
         * Add a settings link to the Plugins page,
         * so people can go straight from the plugin page to the settings page.
         */
        function opensocialshare_login_setting_links($links, $file) {
            static $thisPlugin = '';
            if (empty($thisPlugin)) {
                $thisPlugin = OSS_ROOT_SETTING_LINK;
            }
            if ($file == $thisPlugin) {
                $settingsLink = '<a href="admin.php?page=';
                if ( ! class_exists( 'OSS_Social_Login' ) && ! class_exists( 'OSS_Social9_Install' ) ) {
                    $settingsLink .= 'social9_share';
                } else {
                    $settingsLink .= 'OpenSocialShare';
                }
                $settingsLink .= '">' . __( 'Settings', 'OpenSocialShare' ) . '</a>';

                array_unshift($links, $settingsLink);
            }
            return $links;
        }

        /**
         * Create menu.
         */
        function create_opensocialshare_menu() {
            // Create Menu.
            if ( class_exists( 'OSS_Social_Login' ) ) {		
                add_menu_page( 'OpenSocialShare', 'OpenSocialShare', 'manage_options', 'OpenSocialShare', array('OSS_Activation_Admin', 'options_page'), OSS_CORE_URL . 'assets/images/favicon.ico' );
                add_submenu_page( 'OpenSocialShare', 'Activation Settings', 'Activation', 'manage_options', 'OpenSocialShare', array('OSS_Activation_Admin', 'options_page'));
            }
            // Customize Menu based on do_action order
            do_action('oss_admin_page');
        }

        /**
         * Define constants needed across the plug-in.
         */
        public function define_constants() {
            define('OSS_MIN_WP_VERSION', '3.5');
            define('OSS_PLUGIN_VERSION', '4.2');
            // Type of Plugin ADV, SL, SS, S9
            define('OSS_PLUGIN_PKG', 'S9');

            define('OSS_CORE_DIR', plugin_dir_path(__FILE__));
            define('OSS_CORE_URL', plugin_dir_url(__FILE__));

            define('OSS_VALIDATION_API_URL', 'https://api.opensocialshare.com/api/v2/app/validate');
        }

        /**
         * Loads PHP files that required by the plug-in
         *
         * @global social9Settings, social9Object
         */
        private function load_dependencies() {
            require_once( OSS_CORE_DIR . 'admin/class-activation-admin.php' );
            require_once( OSS_CORE_DIR . 'admin/views/class-activation-settings-view.php' );
        }

        /**
         * Registers Scripts and Styles needed in all sections, is called from all sections
         *
         */
        public static function register_scripts_styles() {
            global $oss_js_in_footer;

            //OpenSocialShare Form Styling
            wp_register_style( 'oss-form-style', OSS_CORE_URL . 'assets/css/oss-form-style.css', array(), OSS_PLUGIN_VERSION );

        }

        /**
         * Registers Scripts and Styles needed throughout front end of plugin
         *
         */
        public function register_admin_files() {
            self::register_scripts_styles();

            wp_register_style('oss-admin-style', OSS_CORE_URL . 'assets/css/oss-admin-style.css', array(), OSS_PLUGIN_VERSION);
            wp_enqueue_style('oss-admin-style');
        }
        /**
         * 
         * @param type $option_name
         */
        public function reset_settings($option_name) {
            ?>
            <div class="oss_options_container">	
                <div class="oss-row oss-reset-body">
                    <h5><?php _e('Reset all the '.$option_name.' options to the default recommended settings.', 'OpenSocialShare'); ?>
                        <span class="oss-tooltip" data-title="<?php _e('This option will reset all the settings to the default '.$option_name.' plugin settings', 'OpenSocialShare'); ?>">
                            <span class="dashicons dashicons-editor-help"></span>
                        </span>
                    </h5>
                    <div>
                        <form method="post" action="" class="oss-reset">
                            <?php submit_button('Reset All Options', 'secondary', 'reset', false ); ?>
                        </form>
                    </div>
                </div>
            </div>
            <?php
        }
        
        /**
         * 
         * @global type $oss_api_settings
         * @param type $option
         * @param type $settings
         */
        public static function reset_settings_action($option, $settings){
            if (is_multisite() && is_main_site()) {
                global $oss_api_settings;
                if (isset($oss_api_settings['multisite_config']) && $oss_api_settings['multisite_config'] == '1') {
                    $blogs = wp_get_sites();
                    foreach ($blogs as $blog) {
                        update_blog_option($blog['blog_id'], $option, $settings);
                    }
                }
            }
            update_option($option, $settings);
        }

    }
new OSS_Core();
}

