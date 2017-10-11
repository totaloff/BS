<?php
/**
 * Configuring meta boxes
 *
 * All the definitions of meta boxes are listed below with comments.
 * Please read them CAREFULLY.
 *
 * For more information, please visit:
 * @link http://www.deluxeblogtips.com/meta-box/
 */

class PhoenixTeam_Metaboxes {

    private $data;

    public function __construct ()
    {
        $this->set_theme_options();
        add_filter( 'rwmb_meta_boxes', array($this, 'register_meta_boxes') );
    }

    /**
     * Register meta boxes
     *
     * @return void
     */
    public function register_meta_boxes( $meta_boxes )
    {
        require THEME_DIR . '/core/metaboxes/settings/page.php';
        require THEME_DIR . '/core/metaboxes/settings/post.php';
        require THEME_DIR . '/core/metaboxes/settings/portfolio.php';
        require THEME_DIR . '/core/metaboxes/settings/testimonials.php';
        require THEME_DIR . '/core/metaboxes/settings/team.php';
        require THEME_DIR . '/core/metaboxes/settings/services.php';

        // Check if WooCommerce is active
        if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
            require THEME_DIR . '/core/metaboxes/settings/woo-products.php';
        }

        return $meta_boxes;
    }

    // makes theme options visible for metaboxes configs
    public function set_theme_options ()
    {
        global $PhoenixData;
        $this->data = $PhoenixData;
    }

}

new PhoenixTeam_Metaboxes();
