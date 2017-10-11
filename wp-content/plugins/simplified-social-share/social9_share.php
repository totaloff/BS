<?php

/**
 * Plugin Name: Simplified Social Share
 * Plugin URI: http://www.social9.com
 * Description: Go viral with Free,Light Weight and Mobile Ready Social Sharing plugin by Social9. Customize it as per requirements!
 * Version: 4.2
 * Author: Social9 Team
 * Author URI: http://www.social9.com
 * License: GPL2+
 */

// If this file is called directly, abort.
defined( 'ABSPATH' ) or die();

define( 'OSS_ROOT_DIR', plugin_dir_path(__FILE__) );
define( 'OSS_ROOT_URL', plugin_dir_url(__FILE__) );
define( 'OSS_ROOT_SETTING_LINK', plugin_basename(__FILE__) );
define('OSS_PLUGIN_FILE',__FILE__);
// Initialize Modules in specific order
include_once OSS_ROOT_DIR.'module-loader.php';
new OSS_Modules_Loader();


