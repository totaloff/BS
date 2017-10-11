<?php

// Exit if called directly
if ( ! defined( 'ABSPATH' ) ) {
    exit();
}
if ( ! class_exists( 'OSS_Sharing_Install' ) ) {

    /**
     * class responsible for setting default settings for social invite.
     */
    class OSS_Sharing_Install {

        private static $options = array(
            'horizontal_enable' => '1',
            'vertical_enable' => '',
            'horizontal_share_interface' => 'responsive',
            'vertical_share_interface' => '32-v',
            'mobile_enable' => 'true',
            'horizontal_sharing_providers' => array(
                'Default' => array(
                    'Facebook' => 'Facebook',
                    'Email' => 'Email',
                    'Print' => 'Print',
                    'GooglePlus' => 'GooglePlus',
                    'LinkedIn' => 'LinkedIn',
                    'Twitter' => 'Twitter',
                    'Pinterest' => 'Pinterest'
                ),
                'Hybrid' => array(
                    'Facebook Like' => 'Facebook Like',
                    'Twitter Tweet' => 'Twitter Tweet',
                    'Google+ Share' => 'Google+ Share',
                    'Pinterest Pin it' => 'Pinterest Pin it',
                    'LinkedIn Share' => 'LinkedIn Share'
                )
            ),
            'vertical_sharing_providers' => array(
                'Default' => array(
                    'Facebook' => 'Facebook',
                    'Email' => 'Email',
                    'Print' => 'Print',
                    'GooglePlus' => 'GooglePlus',
                    'LinkedIn' => 'LinkedIn',
                    'Twitter' => 'Twitter',
                    'Pinterest' => 'Pinterest'
                ),
                'Hybrid' => array(
                    'Facebook Like' => 'Facebook Like',
                    'Twitter Tweet' => 'Twitter Tweet',
                    'Google+ Share' => 'Google+ Share',
                    'Pinterest Pin it' => 'Pinterest Pin it',
                    'LinkedIn Share' => 'LinkedIn Share'
                )
            ),
            'oss-clicker-hr-home' => '1',
            'oss-clicker-hr-post' => '1',
            'oss-clicker-hr-static' => '1',
            'oss-clicker-hr-excerpts' => '1',
            'oss-clicker-hr-custom' => '',
            'horizontal_position' => array(
                'Home' => array(
                    'Top' => 'Top'
                ),
                'Posts' => array(
                    'Top' => 'Top',
                    'Bottom' => 'Bottom'
                ),
                'Pages' => array(
                    'Top' => 'Top'
                ),
                'Excerpts' => array(
                    'Top' => 'Top'
                )
            ),
            'horizontal_rearrange_providers' => array(
                'Facebook',
                'Twitter',
                'LinkedIn',
                'GooglePlus',
                'Pinterest',
                'Email',
                'Print'
            ),
            'vertical_rearrange_providers' => array(
                'Facebook',
                'Twitter',
                'LinkedIn',
                'GooglePlus',
                'Pinterest',
                'Email',
                'Print'
            ),
           
            
            'isTotalShare'=>'true',
            'isOpenSingleWindow'=>'false',
            
            'shortenUrl'=>'true',
            'emailcontent'=>'false',
            'popupHeightWidth'=>''
            
        );

        /**
         * Constructor
         */
        public function __construct() {
            global $oss_js_in_footer;
            $this->set_default_options();

            add_action( 'admin_enqueue_scripts', array( $this, 'share_add_stylesheet' ) );
            if ($oss_js_in_footer) {
                add_action('wp_footer', array($this, 'enqueue_share_scripts'), 1);
                add_action('wp_footer', array($this, 'enqueue_Openshare_scripts'), 1);
                add_action('admin_enqueue_scripts', array($this,'oss_plugin_notice'), 20);
                add_action('wp_footer', array($this, 'enqueue_Open_Social_Share_Script'), 1);
                                
            } else {
                add_action('wp_enqueue_scripts', array($this, 'enqueue_share_scripts'), 20);
                add_action('wp_enqueue_scripts', array($this, 'enqueue_Openshare_scripts'), 20);
                  add_action('admin_enqueue_scripts', array($this,'oss_plugin_notice'), 20);
                add_action('wp_enqueue_scripts', array($this, 'enqueue_Open_Social_Share_Script'), 20);
                
            }
        }

        /**
         * Function for adding default social_profile_data settings at activation.
         */
        public static function set_default_options() {
            global $oss_share_settings;
            if ( ! get_option( 'OpenSocialShare_share_settings' ) ) {
                // Adding OpenSocialShare plugin options if not available.
                update_option('OpenSocialShare_share_settings', self::$options);
            }

            // Get OpenSocialShare plugin settings.
            $oss_share_settings = get_option('OpenSocialShare_share_settings');
        }

        /**
         * Add stylesheet and JavaScript to admin section.
         */
        public function share_add_stylesheet($hook) {
            global $oss_js_in_footer;
            if ( $hook != 'opensocialshare_page_social9_share' && $hook != 'toplevel_page_social9_share' ) {
                return;
            }
            wp_enqueue_style('opensocialshare_sharing_style', plugins_url('/assets/css/oss-social-sharing-admin.css', __FILE__));
            wp_enqueue_script('opensocialshare_share_admin_javascript', plugins_url('/assets/js/oss_share_admin.js', __FILE__), array('jquery', 'jquery-ui-sortable', 'jquery-ui-mouse', 'jquery-touch-punch'), false, $oss_js_in_footer);
        }

        /**
         * Add stylesheet and JavaScript to client sections
         */
        public function enqueue_share_scripts() {
            wp_enqueue_script('opensocialshare_javascript_init', plugins_url('/assets/js/oss_share.js', __FILE__), array('jquery'));
            wp_enqueue_script('oss-social-sharing');
        }
        public function enqueue_Openshare_scripts() {
            wp_enqueue_script('open_share', 'https://sharecdn.social9.com/v2/js/opensocialsharedefaulttheme.js');
            wp_enqueue_script('oss-social-sharing');
        }
        public function enqueue_Open_Social_Share_Script() {
            wp_enqueue_script('open_shares', 'https://sharecdn.social9.com/v2/js/opensocialshare.js');
            wp_enqueue_script('oss-social-sharing');
        }
        public function oss_plugin_notice() {
         
	wp_enqueue_script('plugin_notice', plugins_url('/assets/js/oss_plugin_notice.js', __FILE__), array('jquery'));
        wp_enqueue_script('oss-social-sharing');
        }
       
        /**
         * Reset Sharing Settings.
         */
        public static function reset_share_options() {
            global $oss_share_settings;
            // Load reset options.
            update_option('OpenSocialShare_share_settings', self::$options);

            // Get OpenSocialShare plugin settings.
            $oss_share_settings = get_option('OpenSocialShare_share_settings');
        }

    }

    new OSS_Sharing_Install();
}
