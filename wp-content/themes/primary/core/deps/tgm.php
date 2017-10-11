<?php

require_once get_template_directory() . '/core/helpers/class-tgm-plugin-activation.php';
add_action( 'tgmpa_register', 'primary_register_required_plugins' );
function primary_register_required_plugins() {

  $plugins = array(

     array(
      'name'            => 'Visual Composer', // The plugin name
      'slug'            => 'js_composer', // The plugin slug (typically the folder name)
      'source'          => esc_url('http://wordpress.dankov-theme.com/primary/wp-content/plugins/js_composer.zip'), // The plugin source
      'required'        => false, // If false, the plugin is only 'recommended' instead of required
      'version'         => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
      'force_activation'    => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
      'force_deactivation'  => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
      'external_url'      => '', // If set, overrides default API URL and points to an external URL
    ),

    array(
      'name'            => 'Revolution Slider', // The plugin name
      'slug'            => 'revslider', // The plugin slug (typically the folder name)
      'source'          => esc_url('http://wordpress.dankov-theme.com/primary/wp-content/plugins/revslider.zip'), // The plugin source
      'required'        => false, // If false, the plugin is only 'recommended' instead of required
      'version'         => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
      'force_activation'    => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
      'force_deactivation'  => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
      'external_url'      => '', // If set, overrides default API URL and points to an external URL
    ),

    array(
      'name'            => 'Ultimate Addons for Visual Composer', // The plugin name
      'slug'            => 'ultimate_vc_addons', // The plugin slug (typically the folder name)
      'source'          => esc_url('http://wordpress.dankov-theme.com/primary/wp-content/plugins/ultimate_vc_addons.zip'), // The plugin source
      'required'        => false, // If false, the plugin is only 'recommended' instead of required
      'version'         => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
      'force_activation'    => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
      'force_deactivation'  => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
      'external_url'      => '', // If set, overrides default API URL and points to an external URL
    ),

    array(
      'name'            => 'Contact Form 7', // The plugin name
      'slug'            => 'contact-form-7', // The plugin slug (typically the folder name)
      'required'        => false, // If false, the plugin is only 'recommended' instead of required
      'version'         => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
      'force_activation'    => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
      'force_deactivation'  => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
      'external_url'      => '', // If set, overrides default API URL and points to an external URL
    ),

    array(
      'name'            => 'Envato Market', // The plugin name
      'slug'            => 'envato-market', // The plugin slug (typically the folder name)
      'source'          => esc_url('http://wordpress.dankov-theme.com/primary/wp-content/plugins/envato-market.zip'), // The plugin source
      'required'        => false, // If false, the plugin is only 'recommended' instead of required
      'version'         => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
      'force_activation'    => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
      'force_deactivation'  => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
      'external_url'      => '', // If set, overrides default API URL and points to an external URL
    ),

  );

  $config = array(
    'id'           => 'primary',                 // Unique ID for hashing notices for multiple instances of TGMPA.
    'default_path' => '',                      // Default absolute path to bundled plugins.
    'menu'         => 'tgmpa-install-plugins', // Menu slug.
    'has_notices'  => true,                    // Show admin notices or not.
    'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
    'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
    'is_automatic' => false,                   // Automatically activate plugins after installation or not.
    'message'      => '',                      // Message to output right before the plugins table.
  );

  tgmpa( $plugins, $config );
}
