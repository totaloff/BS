<?php

// Exit if called directly
if ( ! defined( 'ABSPATH' ) ) {
    exit();
}

/**
 * The main class and initialization point of the plugin admin.
 */
if ( ! class_exists( 'OSS_Activation_Admin' ) ) {

    class OSS_Activation_Admin {

        /**
         * OSS_Activation_Admin class instance
         *
         * @var string
         */
        private static $instance;

        /**
         * Get singleton object for class OSS_Activation_Admin
         *
         * @return object OSS_Activation_Admin
         */
        public static function get_instance() {
            if ( ! isset(self::$instance) && ! ( self::$instance instanceof OSS_Activation_Admin ) ) {
                self::$instance = new OSS_Activation_Admin();
            }
            return self::$instance;
        }

        /*
         * Constructor for class OSS_Social_Login_Admin
         */

        public function __construct() {
            $this->install();
            $this->js_in_footer();
            // Registering hooks callback for admin section.
            $this->register_hook_callbacks();
        }

        // Create Api Options if not already created.
        public function install() {
            global $oss_api_settings;
            if ( ! get_option( 'OpenSocialShare_API_settings' ) ) {
                $api_options = array(
                    'OpenSocialShare_apikey' => '',
                    'OpenSocialShare_secret' => '',
                    'scripts_in_footer' => '1',
                    'delete_options' => '0',
                    'sitename' => '',
                    'multisite_config' => '1',
                    'social9_enable' => ''
                );
                update_option('OpenSocialShare_API_settings', $api_options);
            }
            $oss_api_settings = get_option( 'OpenSocialShare_API_settings' );    
        }

        public static function js_in_footer() {
            global $oss_api_settings, $oss_js_in_footer;

            // Set js in footer bool.
            $oss_js_in_footer = isset($oss_api_settings['scripts_in_footer']) && $oss_api_settings['scripts_in_footer'] == '1' ? true : false;
        }

        /*
         * Register admin hook callbacks
         */

        public function register_hook_callbacks() {
            add_action( 'admin_init', array($this, 'admin_init') );
            add_action( 'admin_enqueue_scripts', array($this, 'load_scripts'), 5 );
        }

        /**
         * Callback for admin_menu hook,
         * Register OpenSocialShare_settings and its sanitization callback. Add Open Social Share meta box to pages and posts.
         */
        public function admin_init() {

            register_setting('opensocialshare_api_settings', 'OpenSocialShare_API_settings', array($this, 'validate_options'));

            // Replicate Social Login configuration to the subblogs in the multisite network
            if (is_multisite() && is_main_site()) {
                add_action('wpmu_new_blog', array($this, 'replicate_settings_to_new_blog'));
                add_action('update_option_OpenSocialShare_API_settings', array($this, 'oss_update_old_blogs'));
            }
        }

        /*
         * Adding Javascript/Jquery for admin settings page
         */

        public function load_scripts($hook) {
            global $oss_js_in_footer;

            if ($hook != 'toplevel_page_OpenSocialShare') {
                return;
            }
           // wp_enqueue_script('oss_activation_options', OSS_CORE_URL . 'assets/js/oss-activation.js', array('jquery'), OSS_PLUGIN_VERSION, $oss_js_in_footer);
        }

        /**
         * Get response from OpenSocialShare api
         */
        public static function api_validation_response($apiKey, $apiSecret, $string) {
            global $currentErrorCode, $currentErrorResponse;

            $url = OSS_VALIDATION_API_URL . '?apikey=' . rawurlencode($apiKey) . '&apisecret=' . rawurlencode($apiSecret);
            $response = wp_remote_post($url, array(
                'method' => 'POST',
                'timeout' => 15,
                'headers' => array('Content-Type' => 'application/x-www-form-urlencoded'),
                'body' => array('addon' => 'WordPress', 'version' => OSS_PLUGIN_VERSION, 'agentstring' => $_SERVER['HTTP_USER_AGENT'], 'clientip' => $_SERVER['REMOTE_ADDR'], 'configuration' => $string),
                'cookies' => array(),
                    )
            );

            if (is_wp_error($response)) {
                $currentErrorCode = '0';
                $currentErrorResponse = "Something went wrong: " . $response->get_error_message();
                return false;
            } else {
                if (json_decode($response['body'])->Status) {
                    return true;
                } else {
                    $currentErrorCode = json_decode($response['body'])->Messages;
                    return false;
                }
            }
        }

        public static function validate_options($settings) {
            global $oss_api_settings;

            $settings['sitename'] = sanitize_text_field($settings['sitename']);
            $settings['OpenSocialShare_apikey'] = sanitize_text_field($settings['OpenSocialShare_apikey']);
            $settings['OpenSocialShare_secret'] = sanitize_text_field($settings['OpenSocialShare_secret']);

            if (empty($settings['sitename'])) {
                $message = 'OpenSocialShare Site Name is blank. Get your OpenSocialShare Site Name from <a href="http://www.social9.com" target="_blank">OpenSocialShare</a>';
                add_settings_error('OpenSocialShare_API_settings', esc_attr('settings_updated'), $message, 'error');
            }

            if (empty($settings['OpenSocialShare_apikey']) && empty($settings['OpenSocialShare_secret'])) {
                $message = 'OpenSocialShare API Key and API Secret are blank. Get your OpenSocialShare API Key and API Secret from <a href="http://www.social9.com" target="_blank">OpenSocialShare</a>';
                add_settings_error('OpenSocialShare_API_settings', esc_attr('settings_updated'), $message, 'error');
                return $settings;
            }

            if (empty($settings['OpenSocialShare_apikey'])) {
                $message = 'OpenSocialShare API Key is blank. Get your OpenSocialShare API Key from <a href="http://www.social9.com" target="_blank">OpenSocialShare</a>';
                add_settings_error('OpenSocialShare_API_settings', esc_attr('settings_updated'), $message, 'error');
                return $settings;
            }

            if (empty($settings['OpenSocialShare_secret'])) {
                $message = 'OpenSocialShare API Secret is blank. Get your OpenSocialShare API Secret from <a href="http://www.social9.com" target="_blank">OpenSocialShare</a>';
                add_settings_error('OpenSocialShare_API_settings', esc_attr('settings_updated'), $message, 'error');
                return $settings;
            }

            if (isset($settings['OpenSocialShare_apikey']) && isset($settings['OpenSocialShare_secret'])) {

                $encodeString = 'settings';

                if (self::api_validation_response($settings['OpenSocialShare_apikey'], $settings['OpenSocialShare_secret'], $encodeString)) {
                    return $settings;
                } else {
                    // Api or Secret is not valid or something wrong happened while getting response from OpenSocialShare api
                    $message = 'please check your php.ini settings to enable CURL or FSOCKOPEN';
                    global $currentErrorCode, $currentErrorResponse;

                    $errorMessage = array(
                        "API_KEY_NOT_VALID" => 'OpenSocialShare API key is invalid. Get your OpenSocialShare API Key from <a href="http://www.social9.com" target="_blank">OpenSocialShare</a>',
                        'API_SECRET_NOT_VALID' => 'OpenSocialShare API Secret is invalid. Get your OpenSocialShare API Secret from <a href="http://www.social9.com" target="_blank">OpenSocialShare</a>',
                        'API_KEY_NOT_FORMATED' => 'OpenSocialShare API Key is not formatted correctly.',
                        'API_SECRET_NOT_FORMATED' => 'OpenSocialShare API Secret is not formatted correctly.',
                    );

                    if ($currentErrorCode[0] == '0') {
                        $message = $currentErrorResponse;
                    } else {
                        if (count($currentErrorCode) > 1) {
                            add_settings_error('OpenSocialShare_API_settings', esc_attr('settings_updated'), $errorMessage[$currentErrorCode[0]], 'error');
                            add_settings_error('OpenSocialShare_API_settings', esc_attr('settings_updated'), $errorMessage[$currentErrorCode[1]], 'error');
                            return $settings;
                        } else {
                            $message = $errorMessage[$currentErrorCode[0]];
                        }
                    }
                    add_settings_error('OpenSocialShare_API_settings', esc_attr('settings_updated'), $message, 'error');

                    return $settings;
                }
            } else {
                add_settings_error('OpenSocialShare_API_settings', esc_attr('settings_updated'), 'Settings Updated', 'updated');
                return $settings;
            }
        }

        // Replicate the social login config to the new blog created in the multisite network
        public function replicate_settings_to_new_blog($blogId) {
            global $oss_api_settings;
            add_blog_option($blogId, 'OpenSocialShare_API_settings', $oss_api_settings);
        }

        // Update the social login options in all the old blogs
        public function oss_update_old_blogs($oldConfig) {
            global $oss_api_settings;
            if (isset($oss_api_settings['multisite_config']) && $oss_api_settings['multisite_config'] == '1') {
                $settings = get_option('OpenSocialShare_API_settings');
                $blogs = wp_get_sites();
                foreach ($blogs as $blog) {
                    update_blog_option($blog['blog_id'], 'OpenSocialShare_API_settings', $settings);
                }
            }
        }

        /*
         * Callback for add_menu_page,
         * This is the first function which is called while plugin admin page is requested
         */

        public static function options_page() {
            include_once OSS_CORE_DIR . "admin/views/class-activation-settings-view.php";
            OSS_Activation_Settings::render_options_page();
        }
    }

}

OSS_Activation_Admin::get_instance();
