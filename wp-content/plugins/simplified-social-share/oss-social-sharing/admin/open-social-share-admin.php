<?php
// Exit if called directly
if ( ! defined( 'ABSPATH' ) ) {
    exit();
}

/**
 * The main class and initialization point of the mailchimp plugin admin.
 */
if ( ! class_exists( 'OSS_Social_Share_Admin' ) ) {

    class OSS_Social_Share_Admin {

        /**
         * OSS_Social_Share_Admin class instance
         *
         * @var string
         */
        private static $instance;

        /**
         * Get singleton object for class OSS_Social_Share_Admin
         *
         * @return object OSS_Social_Share_Admin
         */
        public static function get_instance() {
            if ( ! isset( self::$instance ) && ! ( self::$instance instanceof OSS_Social_Share_Admin ) ) {
                self::$instance = new OSS_Social_Share_Admin();
            }
            return self::$instance;
        }

        /*
         * Constructor for class OSS_Social_Share_Admin
         */

        public function __construct() {
            // Registering hooks callback for admin section.
            $this->register_hook_callbacks();
        }

        /*
         * Register admin hook callbacks
         */

        public function register_hook_callbacks() {

            // Used for aia activation.
            add_action( 'wp_ajax_oss_save_apikey', array( $this, 'save_apikey' ) );

            // Add a meta box on all posts and pages to disable sharing.
            add_action( 'add_meta_boxes', array( $this, 'meta_box_setup' ) );

            // Add a callback public function to save any data a user enters in
            add_action( 'save_post', array( $this, 'save_meta' ) );

            add_action( 'admin_init', array( $this, 'admin_init') );
        }

        /**
         * Callback for admin_menu hook,
         * Register OpenSocialShare_settings and its sanitization callback. Add Social9 meta box to pages and posts.
         */
        public function admin_init() {

            register_setting('opensocialshare_share_settings', 'OpenSocialShare_share_settings');

            // Replicate Social Login configuration to the subblogs in the multisite network
            if ( is_multisite() && is_main_site() ) {
                add_action( 'wpmu_new_blog', array( $this, 'replicate_settings_to_new_blog' ) );
                add_action( 'update_option_OpenSocialShare_share_settings', array( $this, 'oss_update_old_blogs') );
            }
        }

        // Replicate the social login config to the new blog created in the multisite network
        public function replicate_settings_to_new_blog( $blogId ) {
            global $oss_share_settings;
            add_blog_option( $blogId, 'OpenSocialShare_share_settings', $oss_share_settings );
        }

        // Update the social login options in all the old blogs
        public function oss_update_old_blogs( $oldConfig ) {
            global $oss_api_settings;
            if ( isset( $oss_api_settings['multisite_config'] ) && $oss_api_settings['multisite_config'] == '1' ) {
                $settings = get_option('OpenSocialShare_share_settings');
                $blogs = wp_get_sites();
                foreach ( $blogs as $blog ) {
                    update_blog_option( $blog['blog_id'], 'OpenSocialShare_share_settings', $settings );
                }
            }
        }

        /*
         * adding OpenSocialShare meta box on each page and post
         */
        public function meta_box_setup() {
            add_meta_box('oss_meta', 'Social Sharing', array($this, 'meta_setup'));
        }

        /**
         * Display  metabox information on page and post
         */
        public function meta_setup() {
            global $post;
            $postType = $post->post_type;
            $ossMeta = get_post_meta($post->ID, '_oss_meta', true);
            if ( is_array( $ossMeta ) ) {
                $meta['sharing'] = isset($ossMeta['sharing']) ? $ossMeta['sharing'] : '';
            } else {
                $meta['sharing'] = isset($ossMeta) && $ossMeta == '1' || $ossMeta == '0' ? $ossMeta : '';
            }
            ?>
            <p>
                <label for="oss_sharing">
                    <input type="checkbox" name="_oss_meta[sharing]" id="oss_sharing" value='1' <?php checked('1', $meta['sharing']); ?> />
                    <?php _e('Disable Social Sharing on this ' . $postType, 'OpenSocialShare') ?>
                </label>
            </p>
            <?php
            // Custom nonce for verification later.
            echo '<input type="hidden" name="oss_meta_nonce" value="' . wp_create_nonce(__FILE__) . '" />';
        }

        /**
         * Save sharing enable/diable meta fields.
         */
        public function save_meta( $postId ) {
            // make sure data came from our meta box
            if ( ! isset( $_POST['oss_meta_nonce'] ) || ! wp_verify_nonce( $_POST['oss_meta_nonce'], __FILE__)) {
                return $postId;
            }
            // check user permissions
            if ($_POST['post_type'] == 'page') {
                if ( ! current_user_can('edit_page', $postId)) {
                    return $postId;
                }
            } else {
                if ( ! current_user_can('edit_post', $postId)) {
                    return $postId;
                }
            }
            if ( isset( $_POST['_oss_meta'] ) ) {
                $newData = $_POST['_oss_meta'];
            } else {
                $newData = 0;
            }
            update_post_meta( $postId, '_oss_meta', $newData );
            return $postId;
        }

        /**
         * Save OpenSocialShare API key in the database
         */
        public static function save_apikey() {
            if (isset($_POST['apikey']) && trim($_POST['apikey']) != '') {
                $options = get_option('OpenSocialShare_API_settings');
                $options['OpenSocialShare_apikey'] = trim($_POST['apikey']);
                if (update_option('OpenSocialShare_API_settings', $options)) {
                    die('success');
                }
            }
            die('error');
        }

        /*
         * Callback for add_menu_page,
         * This is the first function which is called while plugin admin page is requested
         */
        public static function options_page() {

            include_once OSS_SHARE_PLUGIN_DIR."admin/views/settings.php";
            OSS_Social_Share_Settings::render_options_page();
        }

    }

    new OSS_Social_Share_Admin();
}

