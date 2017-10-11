<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://codeboxr.com
 * @since      1.0.0
 *
 * @package    Wpfixedverticalfeedbackbutton
 * @subpackage Wpfixedverticalfeedbackbutton/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Wpfixedverticalfeedbackbutton
 * @subpackage Wpfixedverticalfeedbackbutton/includes
 * @author     Codeboxr <info@codeboxr.com>
 */
class Wpfixedverticalfeedbackbutton {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Wpfixedverticalfeedbackbutton_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The base name of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_base_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_base_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct($plugin) {

		$this->plugin_name = 'wpfixedverticalfeedbackbutton';
		$this->version = '1.0.0';
		$this->plugin_base_name = $plugin;

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Wpfixedverticalfeedbackbutton_Loader. Orchestrates the hooks of the plugin.
	 * - Wpfixedverticalfeedbackbutton_i18n. Defines internationalization functionality.
	 * - Wpfixedverticalfeedbackbutton_Admin. Defines all hooks for the admin area.
	 * - Wpfixedverticalfeedbackbutton_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wpfixedverticalfeedbackbutton-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wpfixedverticalfeedbackbutton-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wpfixedverticalfeedbackbutton-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wpfixedverticalfeedbackbutton-public.php';

		$this->loader = new Wpfixedverticalfeedbackbutton_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Wpfixedverticalfeedbackbutton_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Wpfixedverticalfeedbackbutton_i18n();
		$plugin_i18n->set_domain( $this->get_plugin_name() );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Wpfixedverticalfeedbackbutton_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

        //add new post type cbxtour
        $this->loader->add_action('init', $plugin_admin, 'create_feedbackbutton', 0);

        //add metabox for custom post type cbxfeedbacbtn
        $this->loader->add_action('add_meta_boxes', $plugin_admin, 'add_meta_boxes_feedbackbtn');

        //add metabox for feedback button
        $this->loader->add_action('save_post', $plugin_admin, 'save_post_feedbackbtn', 10, 2);


        //hide view post link on hover of post listing, as this custom post type doesn't have any frontend view
        $this->loader->add_filter( 'post_row_actions', $plugin_admin, 'post_row_actions_on_cbxfeedbackbtn', 10, 2);
        $this->loader->add_filter( 'manage_cbxfeedbackbtn_posts_columns', $plugin_admin, 'cbxfeedbackbtn_columns', 10);

		//add_filter('cbxfixedvbtn_add_form_params', array($this, 'cbx_add_custom_forms'));
		//$plugin = plugin_basename(__FILE__);


		$this->loader->add_filter("plugin_action_links_$this->plugin_base_name", $plugin_admin, 'add_wpfixedverticalfeedbackbutton_settings_link');

		//remove admin menu add new feedback button
		$this->loader->add_action('admin_menu', $plugin_admin, 'remove_menus' );
		//actual menu remove from core
		$this->loader->add_action('cbxfeedbackbtn_remove', $plugin_admin, 'cbxfeedbackbtn_remove_core', 10 );

		$this->loader->add_action('admin_init', $plugin_admin, 'cbxfeedbackbtn_notice' );

		$this->loader->add_filter('plugin_row_meta', $plugin_admin, 'support_link', 10, 2);


	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Wpfixedverticalfeedbackbutton_Public( $this->get_plugin_name(), $this->get_version() );

		//from the core plugin no frontend css or js files are injected
		//$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		//$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		//$this->loader->add_action('wp_head', $plugin_public, 'add_button_style');
		$this->loader->add_action('wp_footer', $plugin_public, 'add_button_html');

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Wpfixedverticalfeedbackbutton_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
