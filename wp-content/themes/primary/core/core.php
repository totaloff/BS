<?php

class PhoenixTeam_Core {

    private $config = array(
        'team' => 'PhoenixTeam',
        'name' => 'Primary',
        'slug' => 'primary'
    );

    protected static $instance = null;

    private static $debug;

    private function __construct ()
    {
        $this->defineConstants();
        $this->setContentWidth();
        $this->addOptionsFramework();
        $this->loadHelpers(self::$debug);
        $this->registerSidebars();
        $this->registerCustomPosts();
        $this->includeMetaboxes();
        $this->loadAdminFiles();
        $this->includeEnqueues();
        $this->registerNavMenus();
        $this->addShortcodes();
        $this->includeDependencies(self::$debug);

        add_action('after_setup_theme', array($this, 'setTextDomain'));
        add_action('after_setup_theme', array($this, 'addThemeSupports'));
        add_action('widgets_init', array($this, 'initializeWidgets'));
    }

    private function __clone ()  {}
    private function __wakeup () {}

    public static function initInstance ($debug = false)
    {
        self::$debug = $debug;

        if (empty(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /*
     Defines the constant paths for use within the theme.
    */
    private function defineConstants ()
    {
        define('THEME_TEAM', $this->config['team']);
        define('THEME_NAME', $this->config['name']);
        define('THEME_SLUG', $this->config['slug']);
        define('THEME_DIR', get_template_directory());
        define('THEME_URI', get_template_directory_uri());
        define('THEME_ADMIN', THEME_DIR . '/core/admin');
        define('THEME_ADMIN_URI', THEME_URI . '/core/admin');

        // WP_CONTENT_DIR
        // WP_CONTENT_URL

        // Re-define meta box path and URL
        define('RWMB_DIR', trailingslashit(THEME_DIR . '/core/metaboxes/core'));
        define('RWMB_URL', trailingslashit(THEME_URI . '/core/metaboxes/core'));

        // Contact Form
        define('IS_AJAX',
            isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
        );

        define('BSF_6892199_NOTICES', false);
    }

    public function setTextDomain ()
    {
        load_theme_textdomain(THEME_SLUG, THEME_DIR . '/lang');
    }

    private function setContentWidth ()
    {
        if (!isset($content_width)) {
            $content_width = 1140;
            return true;
        }
        return false;
    }

    private function addOptionsFramework ()
    {
        if ( !class_exists( 'ReduxFramework' ) &&
             file_exists( THEME_DIR . '/core/options/redux-framework/ReduxCore/framework.php' ) )
        {
            require_once THEME_DIR . '/core/options/redux-framework/ReduxCore/framework.php';
        }

        require_once THEME_DIR  . '/core/options/config.php';
    }

    public function addThemeSupports ()
    {
        if (function_exists('add_theme_support')) {

            // Enables post and comment RSS feed links to head
            add_theme_support('automatic-feed-links');

            // Add Menu Support
            add_theme_support('menus');

            // Add post formats
            add_theme_support( 'post-formats',
                array(
                    'image',
                    'video',
                    'audio',
                    'gallery',
                    'link',
                    'quote'
                )
            );

            // Add thumbnails
            add_theme_support('post-thumbnails', array( 'post', THEME_SLUG . '_portfolio' ));
            // HTML5 Form
            add_theme_support('html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption'));
            // WooCommerce support declaration
            add_theme_support('woocommerce');
        }
    }

    private function registerSidebars ()
    {
        require_once THEME_DIR . '/core/widgets/sidebars.php';
    }

    private function registerCustomPosts ()
    {
        require_once THEME_DIR . '/core/custom_posts/portfolio.php';
        require_once THEME_DIR . '/core/custom_posts/team.php';
        require_once THEME_DIR . '/core/custom_posts/services.php';
        require_once THEME_DIR . '/core/custom_posts/testimonials.php';
    }

    /*
     Loads the core theme functions.
    */
    private function loadHelpers ($debug = false)
    {
        require_once THEME_DIR . '/core/helpers/utils.php';
        require_once THEME_DIR . '/core/helpers/internals.php';
        require_once THEME_DIR . '/core/helpers/BFI_Thumb.php';

        if ($debug)
            require_once THEME_DIR . '/core/helpers/debug.php';
    }


    public function initializeWidgets ()
    {
        require_once THEME_DIR . '/core/widgets/widget-socials.php';
        require_once THEME_DIR . '/core/widgets/widget-get-in-touch.php';
        require_once THEME_DIR . '/core/widgets/widget-flickr.php';

        register_widget('PhoenixTeam_Widget_Socials');
        register_widget('PhoenixTeam_Widget_GetInTouch');
        register_widget('PhoenixTeam_Widget_Flickr');
    }


    private function includeEnqueues ()
    {
        require_once THEME_DIR . '/core/enqueues/styles.php';
        require_once THEME_DIR . '/core/enqueues/scripts.php';
    }


    /*
     Register theme's shortcodes.
    */
    private function addShortcodes ()
    {
        if (class_exists('WPBakeryVisualComposerAbstract')) {
            require_once THEME_DIR . '/core/shortcodes/shortcodes-class.php';
            require_once THEME_DIR . '/core/shortcodes/shortcodes-mapper.php';
        }
    }


    /*
     Load admin files.
    */
    private function loadAdminFiles ()
    {
        if (is_admin()) {
            require_once THEME_ADMIN . '/admin.php';
        }
    }


    private function includeMetaboxes ()
    {
        // Include the meta box script
        require_once RWMB_DIR . 'meta-box.php';
        // Include the meta box definition (the file where you define meta boxes, see `demo/demo.php`)
        require_once THEME_DIR . '/core/metaboxes/config.php';
    }


    private function registerNavMenus ()
    {
        register_nav_menus(
            array (
                'header-menu' => __('Main Menu', THEME_SLUG),
                'footer-menu' => __('Footer Menu', THEME_SLUG),
                'top-menu' => __('Top Menu', THEME_SLUG)
            )
        );
    }


    private function includeDependencies ($debug = false)
    {
        require_once THEME_DIR . '/core/deps/config.php';
    }

}
