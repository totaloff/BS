<?php
/*
 * Class Name: WooCommerce Menu Cart
 * Version: 2.5.5
 * License: GPL2
 */

$wpMenuCart = new WpMenuCart();

class WpMenuCart {

	public static $plugin_slug;
	public static $plugin_basename;

	/**
	 * Construct.
	 */
	public function __construct ()
	{
		self::$plugin_slug = basename(dirname(__FILE__));
		self::$plugin_basename = plugin_basename(__FILE__);

		$menu_locs = get_nav_menu_locations();
		$menu_locs = (isset($menu_locs['header-menu']) && $menu_locs['header-menu']) ? get_term_by('id', $menu_locs['header-menu'], 'nav_menu')->slug : false;

		$this->options = array(
			"menu_slugs" => $menu_locs,
		);

		// load the localisation & classes
		add_action('plugins_loaded', array(&$this, 'languages'), 0); // or use init?
		add_action('init', array(&$this, 'wpml'), 0);
		add_action('init', array($this, 'load_classes'));

		// enqueue scripts & ajax
		add_filter('add_to_cart_fragments', array(&$this, 'woocommerce_ajax_fragments'));

		// add filters to selected menus to add cart item <li>
		add_action('init', array($this, 'filter_nav_menus'));
	}

	/**
	 * Load classes
	 * @return void
	 */
	public function load_classes ()
	{
		if ($this->good_to_go()) {
			include_once('includes/wpmenucart-woocommerce.php');
			$this->shop = new WPMenuCart_WooCommerce();
		}
	}

	/**
	 * Check if a shop is active or if conflicting old versions of the plugin are active
	 * @return boolean
	 */
	public function good_to_go ()
	{
		$wpmenucart_shop_check = get_option('wpmenucart_shop_check');
		$active_plugins = $this->get_active_plugins();

		// check for shop plugins
		if (!$this->is_shop_active() && $wpmenucart_shop_check != 'hide') {
			add_action('admin_notices', array ($this, 'need_shop'));
			return false;
		}

		// check for old versions
		if (count($this->get_active_old_versions()) > 0) {
			add_action('admin_notices', array ($this, 'woocommerce_version_active'));
			return false;
		}

		// we made it! good to go :o)
		return true;
	}

	/**
	 * Return true if one ore more shops are activated.
	 * @return boolean
	 */
	public function is_shop_active ()
	{
		if (count($this->get_active_shops()) > 0) {
			return true;
		} else {
			return false;
		}

	}

	/**
	 * Get an array of all active plugins, including multisite
	 * @return array active plugin paths
	 */
	public static function get_active_plugins ()
	{
		$active_plugins = (array) apply_filters('active_plugins', get_option('active_plugins'));
		if (is_multisite()) {
			// get_site_option( 'active_sitewide_plugins', array() ) returns a 'reversed list'
			// like [hello-dolly/hello.php] => 1369572703 so we do array_keys to make the array
			// compatible with $active_plugins
			$active_sitewide_plugins = (array) array_keys(get_site_option('active_sitewide_plugins', array()));
			// merge arrays and remove doubles
			$active_plugins = (array) array_unique(array_merge($active_plugins, $active_sitewide_plugins ) );
		}

		return $active_plugins;
	}

	/**
	 * Get array of active shop plugins
	 *
	 * @return array plugin name => plugin path
	 */
	public static function get_active_shops()
	{
		$active_plugins = self::get_active_plugins();

		$shop_plugins = array (
			'WooCommerce'	=> 'woocommerce/woocommerce.php',
		);

		// filter shop plugins & add shop names as keys
		$active_shop_plugins = array_intersect( $shop_plugins, $active_plugins );

		return $active_shop_plugins;
	}

	/**
	 * Get array of active old WooCommerce Menu Cart plugins
	 *
	 * @return array plugin paths
	 */
	public function get_active_old_versions ()
	{
		$active_plugins = $this->get_active_plugins();

		$old_versions = array (
			'woocommerce-menu-bar-cart/wc_cart_nav.php',				//first version
			'woocommerce-menu-bar-cart/woocommerce-menu-cart.php',		//last free version
			'woocommerce-menu-cart/woocommerce-menu-cart.php',			//never actually released? just in case...
			'woocommerce-menu-cart-pro/woocommerce-menu-cart-pro.php',	//old pro version
		);

		$active_old_plugins = array_intersect($old_versions, $active_plugins);

		return $active_old_plugins;
	}

	/**
	 * Fallback admin notices
	 *
	 * @return string Fallack notice.
	 */
	public function need_shop ()
	{
		$error = __('WP Menu Cart Pro could not detect an active shop plugin. Make sure you have activated at least one of the supported plugins.' , 'wpmenucart');
		$message = sprintf('<div class="error"><p>%1$s <a href="%2$s">%3$s</a></p></div>', $error, add_query_arg( 'hide_wpmenucart_shop_check', 'true'), __('Hide this notice', 'wpmenucart'));

		echo wp_kses_post($message);
	}

	public function woocommerce_version_active ()
	{
		$error = __( 'An old version of WooCommerce Menu Cart is currently activated, you need to disable or uninstall it for WP Menu Cart to function properly' , 'wpmenucart' );
		$message = '<div class="error"><p>' . $error . '</p></div>';

		echo wp_kses_post($message);
	}

	/**
	 * Load translations.
	 */
	public function languages ()
	{
		load_plugin_textdomain('wpmenucart', false, dirname(plugin_basename( __FILE__ )) . '/languages/');
	}


	/**
	* Register strings for WPML String Translation
	*/
	public function wpml ()
	{
		if (isset($this->options['wpml_string_translation']) && function_exists('icl_register_string')) {
			icl_register_string('WP Menu Cart', 'item text', 'item');
			icl_register_string('WP Menu Cart', 'items text', 'items');
			icl_register_string('WP Menu Cart', 'empty cart text', 'your cart is currently empty');
			icl_register_string('WP Menu Cart', 'hover text', 'View your shopping cart');
			icl_register_string('WP Menu Cart', 'empty hover text', 'Start shopping');
		}
	}


	/**
	 * Add filters to selected menus to add cart item <li>
	 */
	public function filter_nav_menus ()
	{
		// exit if no shop class is active
		if (!isset($this->shop))
			return;

		// exit if no menus set
		if (!isset($this->options['menu_slugs']) || empty($this->options['menu_slugs']))
			return;

		if ($this->options['menu_slugs']) {
			add_filter('wp_nav_menu_' . $this->options['menu_slugs'] . '_items', array($this, 'add_itemcart_to_menu') , 10, 2);
		}
	}

	/**
	 * Add Menu Cart to menu
	 *
	 * @return menu items + Menu Cart item
	 */
	public function add_itemcart_to_menu ($items)
	{
		$classes = 'wpmenucartli wpmenucart-display-standard';

		if ($this->get_common_li_classes($items) != '') {
			$classes .= ' ' . $this->get_common_li_classes($items);
		}

		$active_plugins = apply_filters('active_plugins', get_option('active_plugins'));

		$classes = apply_filters('wpmenucart_menu_item_classes', $classes);
		$this->menu_items['menu']['menu_item_li_classes'] = $classes;

		// DEPRECATED: These filters are now deprecated in favour of the more precise filters in the functions!
		$wpmenucart_menu_item = apply_filters('wpmenucart_menu_item_filter', $this->wpmenucart_menu_item());

		$item_data = $this->shop->menu_item();

		$menu_item_li = '<li class="wpmenucartli wpmenucart-display-standard" id="wpmenucartli">' . $wpmenucart_menu_item . '</li>';

		if (apply_filters('wpmenucart_prepend_menu_item', false)) {
			$items = apply_filters('wpmenucart_menu_item_wrapper', $menu_item_li) . $items;
		} else {
			$items .= apply_filters('wpmenucart_menu_item_wrapper', $menu_item_li);
		}

		return $items;
	}

	/**
	 * Get a flat list of common classes from all menu items in a menu
	 * @param  string $items nav_menu HTML containing all <li> menu items
	 * @return string flat (imploded) list of common classes
	 */
	public function get_common_li_classes ($items)
	{
		if (empty($items)) return;

		$libxml_previous_state = libxml_use_internal_errors(true); // enable user error handling

		$dom_items = new DOMDocument;
		$dom_items->loadHTML( $items );
		$lis = $dom_items->getElementsByTagName('li');

		if (empty($lis)) {
			libxml_clear_errors();
			libxml_use_internal_errors($libxml_previous_state);
			return;
		}

		foreach($lis as $li) {
			if ($li->parentNode->tagName != 'ul')
				$li_classes[] = explode( ' ', $li->getAttribute('class') );
		}

		// Uncomment to dump DOM errors / warnings
		//$errors = libxml_get_errors();
		//print_r ($errors);

		// clear errors and reset to previous error handling state
		libxml_clear_errors();
		libxml_use_internal_errors($libxml_previous_state);

		if (!empty($li_classes)) {
			$common_li_classes = array_shift($li_classes);
			foreach ($li_classes as $li_class) {
				$common_li_classes = array_intersect($li_class, $common_li_classes);
			}
			$common_li_classes_flat = implode(' ', $common_li_classes);
		}
		return $common_li_classes_flat;
	}

	/**
	 * Ajaxify Menu Cart
	 */
	public function woocommerce_ajax_fragments ($fragments)
	{
		$fragments['a.wpmenucart-contents'] = $this->wpmenucart_menu_item();
		return $fragments;
	}

	/**
	 * Create HTML for Menu Cart item
	 */
	public function wpmenucart_menu_item () {
		$item_data = $this->shop->menu_item();

		if (isset($this->options['wpml_string_translation']) && function_exists('icl_t')) {
			//use WPML
			$viewing_cart = icl_t('WP Menu Cart', 'hover text', 'View your shopping cart');
			$start_shopping = icl_t('WP Menu Cart', 'empty hover text', 'Start shopping');
			$cart_contents = $item_data['cart_contents_count'];
		} else {
			//use regular WP i18n
			$viewing_cart = __('View your shopping cart', 'wpmenucart');
			$start_shopping = __('Start shopping', 'wpmenucart');
			$cart_contents = $item_data['cart_contents_count'];
		}

		$this->menu_items['menu']['cart_contents'] = $cart_contents;

		if ($item_data['cart_contents_count'] == 0) {
			$menu_item_href = apply_filters ('wpmenucart_emptyurl', $item_data['shop_page_url'] );
			$menu_item_title = apply_filters ('wpmenucart_emptytitle', $start_shopping );
			$menu_item_classes = 'wpmenucart-contents empty-wpmenucart-visible';
		} else {
			$menu_item_href = apply_filters ('wpmenucart_fullurl', $item_data['cart_url'] );
			$menu_item_title = apply_filters ('wpmenucart_fulltitle', $viewing_cart );
			$menu_item_classes = 'wpmenucart-contents';
		}

		$this->menu_items['menu']['menu_item_href'] = $menu_item_href;
		$this->menu_items['menu']['menu_item_title'] = $menu_item_title;

		if(defined('UBERMENU_VERSION') && (version_compare(UBERMENU_VERSION, '3.0.0') >= 0)){
			$menu_item_classes .= ' ubermenu-target';
		}

		$menu_item = '<a class="'.$menu_item_classes.'" href="'.$menu_item_href.'" title="'.$menu_item_title.'">';

		$menu_item_a_content = '';

		$menu_item_icon = '<i class="icon-basket"></i>';
		$menu_item_a_content .= $menu_item_icon;

		$menu_item_a_content .= '<span class="cartcontents">'.$cart_contents.'</span>';

		$menu_item_a_content = apply_filters ('wpmenucart_menu_item_a_content', $menu_item_a_content, $menu_item_icon, $cart_contents, $item_data );

		$this->menu_items['menu']['menu_item_a_content'] = $menu_item_a_content;

		$menu_item .= $menu_item_a_content . '</a>';

		$menu_item = apply_filters ('wpmenucart_menu_item_a', $menu_item,  $item_data, $this->options, $menu_item_a_content, $viewing_cart, $start_shopping, $cart_contents);

		if ( !empty( $menu_item ) ) return $menu_item;
	}

}

/**
 * Hide notifications
 */
if (! empty( $_GET['hide_wpmenucart_shop_check'])) {
	update_option('wpmenucart_shop_check', 'hide');
}
