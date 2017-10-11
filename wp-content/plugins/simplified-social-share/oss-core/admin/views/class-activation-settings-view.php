<?php
// Exit if called directly
if ( ! defined( 'ABSPATH' ) ) {
    exit();
}

/**
 * The activation settings class.
 */
if ( ! class_exists( 'OSS_Activation_Settings' ) ) {

    class OSS_Activation_Settings {

        public static function render_options_page() {
            global $oss_api_settings;
            $oss_api_settings = get_option( 'OpenSocialShare_API_settings' );
            ?>
            <!-- OSS-wrap -->
            <div id="overlay-back"></div>
            <div class="wrap oss-wrap cf">
             
                <header>
                    <h2 class="logo"><a href="//www.social9.com" target="_blank">OpenSocialShare</a><em>Activation</em></h2>
                </header>
                <?php settings_errors(); ?>
                <div id="oss_options_tabs" class="cf">
                    <div class="cf">
                        <ul class="oss-options-tab-btns">
                            <li class="nav-tab oss-active" data-tab="oss_options_tab-1"><?php _e( 'Activation', 'OpenSocialShare' ) ?></li>
                            <li class="nav-tab" data-tab="oss_options_tab-2"><?php _e( 'Advanced Settings', 'OpenSocialShare' ) ?></li>
                        </ul>
                        <form action="options.php" method="post">
                        <?php
                            settings_fields( 'opensocialshare_api_settings' );
                        ?>
                        <div id="oss_options_tab-1" class="oss-tab-frame oss-active">
                            <div class="oss_options_container">
                                <div class="oss-row">
                                    <?php if ( class_exists( 'OSS_Social_Login' ) ) { ?>
                                    <h6>To activate the OpenSocialShare Plugin, insert the OpenSocialShare API Key and Secret in the section below. If you don't have them, please follow these <a href="http://ish.re/INI1" target="_blank">instructions</a>.</h6>
                                    <label >
                                        <span class="oss_property_title"><?php _e( 'OpenSocialShare Site Name', 'OpenSocialShare' ); ?>
                                            <span class="oss-tooltip" data-title="You can find the Site Name into your OpenSocialShare user account">
                                                <span class="dashicons dashicons-editor-help"></span>
                                            </span>
                                        </span>
                                        <input type="text" class="oss-row-field" name="OpenSocialShare_API_settings[sitename]" value="<?php echo $oss_api_settings['sitename']; ?>" autofill='off' autocomplete='off' />
                                    </label>
                                    <?php } else { ?>
                                    <h6>API Key is optional for Social Sharing, insert the OpenSocialShare API Key. If you don't have one, please follow the <a href="http://ish.re/INI1" target="_blank">instructions</a>.</h6>
                                    <?php } ?>
                                    <label>
                                        <span class="oss_property_title"><?php _e( 'OpenSocialShare API Key', 'OpenSocialShare' ); ?>
                                            <span class="oss-tooltip" data-title="Your unique OpenSocialShare API Key">
                                                        <span class="dashicons dashicons-editor-help"></span>
                                            </span>
                                        </span>
                                        <input type="text" class="oss-row-field" name="OpenSocialShare_API_settings[OpenSocialShare_apikey]" value="<?php echo ( isset( $oss_api_settings['OpenSocialShare_apikey'] ) && !empty($oss_api_settings['OpenSocialShare_apikey']) ) ? $oss_api_settings['OpenSocialShare_apikey'] : ''; ?>" autofill='off' autocomplete='off' />
                                    </label>
                                    
                                    <?php if ( class_exists( 'OSS_Social_Login' ) ) { ?>
                                    <label >
                                        <span class="oss_property_title"><?php _e( 'OpenSocialShare API Secret', 'OpenSocialShare' ); ?>
                                            <span class="oss-tooltip" data-title="Your unique OpenSocialShare API Secret">
                                                <span class="dashicons dashicons-editor-help"></span>
                                            </span>
                                        </span>
                                        <input type="text" class="oss-row-field" name="OpenSocialShare_API_settings[OpenSocialShare_secret]" value="<?php echo $oss_api_settings['OpenSocialShare_secret']; ?>" autofill='off' autocomplete='off' />
                                    </label>
                                    <?php } ?>
                                </div>
                                <?php if( class_exists( 'OSS_Social9' ) ) { ?>
                                    <div class="oss-row">
                                        <h3><?php _e( 'Enable Sharing', 'OpenSocialShare' ); ?></h3>
                                        <div>
                                            <label for="oss-enable-sharing" class="oss-toggle">
                                                <input type="checkbox" class="oss-toggle" id="oss-enable-sharing" name="OpenSocialShare_API_settings[social9_enable]" value="1" <?php echo ( isset( $oss_api_settings['social9_enable'] ) && $oss_api_settings['social9_enable'] == '1' ) ? 'checked' : ''; ?> <?php _e( 'Yes', 'OpenSocialShare' ) ?> />
                                                <span class="oss-toggle-name"><?php _e('Enable Sharing', 'OpenSocialShare'); ?></span>
                                            </label>    
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <p class="submit">
                                <?php submit_button( 'Save Settings', 'primary', 'submit', false ); ?>
                            </p>
                        </div>
                        <div id="oss_options_tab-2" class="oss-tab-frame">
                            <div class="oss_options_container">
                                <div class="oss-row" style="display: none;">
                                    <h3><?php _e( 'JavaScript options', 'OpenSocialShare' ); ?></h3>
                                    <label class="oss-toggle">
                                        <input type="checkbox" class="oss-toggle" name="OpenSocialShare_API_settings[scripts_in_footer]" value="1" <?php echo ( isset($oss_api_settings['scripts_in_footer'] ) && $oss_api_settings['scripts_in_footer'] == '1' ) ? 'checked' : ''; ?> />
                                        <span class="oss-toggle-name">
                                            For faster loading, do you want to load javascripts in the footer?
                                            <span class="oss-tooltip" data-title="The JavaScript will load in the footer by default, please disable it if your theme doesn't support footers or has issues with the plugin">
                                                <span class="dashicons dashicons-editor-help"></span>
                                            </span>
                                        </span>
                                    </label>
                                </div><!-- oss-row -->
                                <div class="oss-row">
                                    <h3><?php _e( 'Plugin deletion options', 'OpenSocialShare' ); ?></h3>
                                    <div>
                                        <h4>
                                            <?php _e( 'Do you want to delete all plugin settings when removing this plugin?', 'OpenSocialShare' ); ?>
                                            <span class="oss-tooltip" data-title="If you choose Yes, then you will not be able to recover these plugin settings again">
                                                <span class="dashicons dashicons-editor-help"></span>
                                            </span>
                                        </h4>
                                        <label>
                                            <input type="radio" name="OpenSocialShare_API_settings[delete_options]" value='1' <?php echo ( !isset( $oss_api_settings['delete_options'] ) || $oss_api_settings['delete_options'] == '1' ) ? 'checked' : ''; ?> />
                                            <span><?php _e( 'Yes', 'OpenSocialShare' ) ?></span>
                                        </label>
                                        <label>
                                            <input type="radio" name="OpenSocialShare_API_settings[delete_options]" value="0" <?php echo ( isset( $oss_api_settings['delete_options'] ) && $oss_api_settings['delete_options'] == '0' ) ? 'checked' : ''; ?> />
                                            <span><?php _e( 'No', 'OpenSocialShare' ); ?></span>
                                        </label>
                                    </div>
                                </div>
                            <?php
                                if ( is_multisite() && is_main_site() ) {
                                    ?>
                                    <div class="oss-row">

                                        <h3><?php _e( 'Multisite', 'OpenSocialShare' ); ?></h3>
                                            <div>
                                                <h4>
                                                    <?php _e( 'Do you want to apply the same changes to all blogs when you update the plugin settings in the main blog of a multisite network?', 'OpenSocialShare' ); ?>
                                                    <span class="oss-tooltip" data-title="If enabled, it would apply plugin settings of your main site to all other sites under this multisite network.">
                                                        <span class="dashicons dashicons-editor-help"></span>
                                                    </span>
                                                </h4>
                                                <label>
                                                    <input type="radio" name="OpenSocialShare_API_settings[multisite_config]" value='1' <?php echo ( ( !isset( $oss_api_settings['multisite_config'] ) ) || ( isset( $oss_api_settings['multisite_config'] ) && $oss_api_settings['multisite_config'] == 1 ) ) ? 'checked' : '' ; ?>/>
                                                    <span><?php _e( 'Yes, apply the same changes to (plugin settings) each blog in the multisite network when I update plugin settings.', 'OpenSocialShare' ); ?></span>
                                                </label>
                                                <label>
                                                    <input type="radio" name="OpenSocialShare_API_settings[multisite_config]" value="0" <?php echo ( isset( $oss_api_settings['multisite_config'] ) && $oss_api_settings['multisite_config'] == 0 ) ? 'checked' : ''; ?>/>
                                                    <span><?php _e( 'No, do not apply the changes to other blogs when I update plugin settings.', 'OpenSocialShare' ); ?></span>
                                                </label>
                                            </div>
                                    </div>
                                    <?php
                                }
                            ?>
                            </div>
                            <p class="submit">
                                <?php submit_button( 'Save Settings', 'primary', 'submit', false ); ?>
                            </p>
                        </div>
                        </form>
                   </div>
                </div>        
            </div>
            <?php
            }
        }
}

