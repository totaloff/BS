<?php
// OSS_Social_Sharing_Settings
// Exit if called directly
if ( ! defined('ABSPATH') ) {
    exit();
}

/**
 * The main class and initialization point of the plugin settings page.
 */
if ( ! class_exists('OSS_Social_Share_Settings') ) {

    class OSS_Social_Share_Settings {

        private static function share_provider() {
            return array('Delicious', 'Digg', 'Email', 'Facebook', 'GooglePlus', 'Google', 'LinkedIn', 'MySpace', 'Pinterest', 'Print', 'Reddit', 'Tumblr', 'Twitter', 'Vkontakte');
        }

        private static function counter_provider() {
            return array('Facebook Like', 'Twitter Tweet', 'StumbleUpon Badge', 'Google+ Share', 'Facebook Recommend', 'Pinterest Pin it', 'Reddit', 'Facebook Send', 'LinkedIn Share', 'Google+ +1','Hybridshare');
        }

        private static function vertical_share_interface_position($page, $settings) {
            echo '<div class="oss-show-options">';
            $interface_location = array('Top Left', 'Top Right', 'Middle Left', 'Middle Right', 'Bottom Left', 'Bottom Right');
            foreach ($interface_location as $location) {
                ?>
                <label>
                    <input type="radio" class="oss-clicker-vr-<?php echo strtolower($page); ?>-options default" name="OpenSocialShare_share_settings[vertical_position][<?php echo $page; ?>]" value="<?php echo $location; ?>" <?php echo ( isset($settings['vertical_position'][$page]) && $settings['vertical_position'][$page] == $location ) ? 'checked' : ''; ?> />
                    <span class="oss-text"><?php _e(str_replace(' ', '-', $location) , 'OpenSocialShare'); ?></span>
                </label>
            <?php
            }
            echo '</div>';
        }

        private static function horizontal_share_interface_position($page, $settings) {
            echo '<div class="oss-show-options">';
            $interface_location = array('Top', 'Bottom');
            foreach ($interface_location as $location) {
                ?>
                <label>
                    <input type="checkbox" class="oss-clicker-hr-<?php echo strtolower($page); ?>-options default" name="OpenSocialShare_share_settings[horizontal_position][<?php echo $page; ?>][<?php echo $location; ?>]" value="<?php echo $location; ?>" <?php echo ( isset($settings['horizontal_position'][$page][$location]) && $settings['horizontal_position'][$page][$location] == $location ) ? 'checked' : ''; ?> />
                    <span class="oss-text"><?php _e($location . ' of the content', 'OpenSocialShare'); ?></span>
                </label>
            <?php
            }
            echo '</div>';
        }

        private static function vertical_settings( $settings ) {
            ?>
            <!-- Vertical Sharing -->
            <div id="oss_options_tab-2" class="oss-tab-frame">
                <!-- Vertical Options -->
                <div class="oss_options_container">

                    <!-- Vertical Switch -->
                    <div class="oss_enable_switch oss-row">
                        <label for="oss-enable-vertical" class="oss-toggle">
                            <input type="checkbox" class="oss-toggle" id="oss-enable-vertical" name="OpenSocialShare_share_settings[vertical_enable]" value="1" <?php echo ( isset($settings['vertical_enable']) && $settings['vertical_enable'] == '1') ? 'checked' : ''; ?> <?php _e('Yes', 'OpenSocialShare') ?> />
                            <span class="oss-toggle-name"><?php _e('Enable Vertical Widget', 'OpenSocialShare'); ?></span>
                        </label>
                    </div>

                    <div class="oss-option-disabled-vr"></div>
                    <div class="oss_vertical_interface oss-row cf">
                        <h3><?php _e('Select the sharing theme', 'OpenSocialShare'); ?></h3>
                        <div>
                            <input type="radio" id="oss-vertical-32-v" name="OpenSocialShare_share_settings[vertical_share_interface]" value="32-v" <?php echo (!isset($settings['vertical_share_interface']) || $settings['vertical_share_interface'] == '32-v' ) ? 'checked' : ''; ?> />
                            <label class="oss_vertical_interface_img" for="oss-vertical-32-v"><img src="<?php echo OSS_SHARE_PLUGIN_URL . "/assets/images/sharing/32-v.png" ?>" /></label>
                        </div>
                        <div>
                            <input type="radio" id="oss-vertical-16-v" name="OpenSocialShare_share_settings[vertical_share_interface]" value="16-v" <?php echo ( $settings['vertical_share_interface'] == '16-v' ) ? 'checked' : ''; ?> />
                            <label class="oss_vertical_interface_img" for="oss-vertical-16-v"><img src="<?php echo OSS_SHARE_PLUGIN_URL . "/assets/images/sharing/16-v.png" ?>" /></label>
                        </div>
                        <div>
                            <input type="radio" id="oss-vertical-hybrid-v-v" name="OpenSocialShare_share_settings[vertical_share_interface]" value="hybrid-v-v" <?php echo ( $settings['vertical_share_interface'] == 'hybrid-v-v' ) ? 'checked' : ''; ?> />
                            <label class="oss_vertical_interface_img" for="oss-vertical-hybrid-v-v"><img src="<?php echo OSS_SHARE_PLUGIN_URL . "/assets/images/sharing/hybrid-v-v.png" ?>" /></label>
                        </div>
                        <div>
                            <input type="radio"  id="oss-vertical-hybrid-v-h" name="OpenSocialShare_share_settings[vertical_share_interface]" value="hybrid-v-h" <?php echo ( $settings['vertical_share_interface'] == 'hybrid-v-h' ) ? 'checked' : ''; ?> />
                            <label class="oss_vertical_interface_img" for="oss-vertical-hybrid-v-h"><img src="<?php echo OSS_SHARE_PLUGIN_URL . "/assets/images/sharing/hybrid-v-h.png" ?>" /></label>
                        </div>
                    </div>

                    <div id="oss_ve_theme_options" class="oss-row cf">
                        <h3><?php _e('Select the sharing networks', 'OpenSocialShare'); ?>
                            <span class="oss-tooltip" data-title="<?php _e('Selected sharing networks will be displayed in the widget', 'OpenSocialShare'); ?>">
                                <span class="dashicons dashicons-editor-help"></span>
                            </span>
                        </h3>
                        <div id="oss_ve_hz_theme_options" class="cf" style="display:block;">
                            <?php
                            $share_providers = self::share_provider();
                            
                            foreach ($share_providers as $provider) {
                                
                                ?>
                                <label class="-oss-share-networks-list">
                                    <input type="checkbox" class="Oss_ve_share_providers" name="OpenSocialShare_share_settings[vertical_sharing_providers][Default][<?php echo $provider; ?>]" value="<?php echo $provider; ?>" <?php if(isset( $settings['vertical_rearrange_providers'])){ echo in_array($provider, $settings['vertical_rearrange_providers'])  ? 'checked' : '';} ?> />
                                    <span class="oss-text oss-icon-<?php echo strtolower($provider); ?>"><?php echo $provider; ?></span>
                                </label>
                            <?php } 
                            
                            ?>
                            <div id="ossVerticalSharingLimit" class="oss-alert-box" style="display:none; margin-bottom: 5px;"><?php _e('You can select only eight providers', 'OpenSocialShare') ?>.</div>
                            <p class="oss-footnote">*<?php _e('All other icons will be included in the pop-up', 'OpenSocialShare'); ?></p>
                        </div>

                        <!-- Other than square sharing -->
                        <div id="oss_ve_ve_theme_options" style="display:none;">
                                <?php
                                $counter_providers = self::counter_provider();
                                foreach ($counter_providers as $provider) {
                                    ?>
                                <label>
                                    <input type="checkbox" class="Oss_ve_ve_share_providers" name="OpenSocialShare_share_settings[vertical_sharing_providers][Hybrid][<?php echo $provider; ?>]" value="<?php echo $provider; ?>" <?php echo ( isset($settings['vertical_sharing_providers']['Hybrid'][$provider]) && $settings['vertical_sharing_providers']['Hybrid'][$provider] == $provider ) ? 'checked' : ''; ?> />
                                    <span class="oss-text"><?php echo $provider; ?></span>
                                </label>
                            <?php } ?>
                            <div id="ossVerticalVerticalSharingLimit" class="oss-alert-box" style="display:none; margin-bottom: 5px;">
                                <?php _e('You can select only eight providers', 'OpenSocialShare') ?>.
                            </div>
                            <p class="oss-footnote"></p>
                        </div>
                    </div>

                    <div class="oss-row cf" id="oss_vertical_rearrange_container">
                        <h3 class="oss-column2">
                                <?php _e('Select the sharing networks order', 'OpenSocialShare') ?>
                            <span class="oss-tooltip" data-title="<?php _e('Drag the icons around to set the order', 'OpenSocialShare'); ?>">
                                <span class="dashicons dashicons-editor-help"></span>
                            </span>
                        </h3>
                        <div class="oss-column2 oss-vr-sortable">
                            <ul id="ossVerticalSortable" class="cf">
                                <?php
                                if (isset($settings['vertical_rearrange_providers']) && count($settings['vertical_rearrange_providers']) > 0) {
                                    foreach ($settings['vertical_rearrange_providers'] as $provider) {
                                        ?>
                                        <li title="<?php echo $provider ?>" id="ossVerticalLI<?php echo $provider ?>" class="osshare_iconsprite32 oss-icon-<?php echo strtolower($provider) ?>">
                                            <input type="hidden" name="OpenSocialShare_share_settings[vertical_rearrange_providers][]" value="<?php echo $provider ?>" />
                                        </li>
                                    <?php
                                }
                            }
                            ?>
                            </ul>
                            <ul class="oss-static">
                                <li title="More" id="ossHorizontalLImore" class="oss-pin oss-icon-more osshare_evenmore">
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="oss-row">
                        <h3>
                            <?php _e('Choose the location(s) to display the widget', 'OpenSocialShare') ?>
                            <span class="oss-tooltip" data-title="<?php _e('Sharing widget will be displayed at the selected location(s)', 'OpenSocialShare'); ?>">
                                <span class="dashicons dashicons-editor-help"></span>
                            </span>
                        </h3>
                        <div>
                            <input type="checkbox" class="oss-toggle" id="oss-clicker-vr-home" name="OpenSocialShare_share_settings[oss-clicker-vr-home]" value="1" <?php echo ( isset($settings['oss-clicker-vr-home']) && $settings['oss-clicker-vr-home'] == '1') ? 'checked' : ''; ?> />
                            <label class="oss-show-toggle" for="oss-clicker-vr-home">
                                <?php _e('Home Page', 'OpenSocialShare'); ?>
                                <span class="oss-tooltip" data-title="<?php _e('Home page of your blog', 'OpenSocialShare'); ?>">
                                    <span class="dashicons dashicons-editor-help"></span>
                                </span>
                            </label>
                            <?php self::vertical_share_interface_position('Home', $settings); ?>
                        </div>
                        <div>
                            <input type="checkbox" class="oss-toggle" id="oss-clicker-vr-post" name="OpenSocialShare_share_settings[oss-clicker-vr-post]" value="1" <?php echo ( isset($settings['oss-clicker-vr-post']) && $settings['oss-clicker-vr-post'] == '1' ) ? 'checked' : ''; ?> />
                            <label class="oss-show-toggle" for="oss-clicker-vr-post">
                                <?php _e('Blog Posts','OpenSocialShare');?>
                                <span class="oss-tooltip" data-title="<?php _e('Each post of your blog', 'OpenSocialShare'); ?>">
                                    <span class="dashicons dashicons-editor-help"></span>
                                </span>
                            </label>
                            <?php self::vertical_share_interface_position('Post', $settings); ?>
                        </div>
                        <div>
                            <input type="checkbox" class="oss-toggle" id="oss-clicker-vr-static" name="OpenSocialShare_share_settings[oss-clicker-vr-static]" value="1" <?php echo ( isset($settings['oss-clicker-vr-static']) && $settings['oss-clicker-vr-static'] == '1' ) ? 'checked' : ''; ?> />
                            <label class="oss-show-toggle" for="oss-clicker-vr-static">
                                <?php _e('Static Pages', 'OpenSocialShare'); ?>
                                <span class="oss-tooltip" data-title="<?php _e('Static pages of your blog (e.g &ndash; about, contact, etc.)', 'OpenSocialShare'); ?>">
                                    <span class="dashicons dashicons-editor-help"></span>
                                </span>
                            </label>
                            <?php self::vertical_share_interface_position('Static', $settings); ?>
                        </div><!-- unnamed div -->
                        <div>
                            <input type="checkbox" class="oss-toggle" id="oss-clicker-vr-custom" name="OpenSocialShare_share_settings[oss-clicker-vr-custom]" value="1" <?php echo ( isset($settings['oss-clicker-vr-custom']) && $settings['oss-clicker-vr-custom'] == '1' ) ? 'checked' : ''; ?> />
                            <label class="oss-show-toggle" for="oss-clicker-vr-custom">
                                <?php _e('Custom Post Types', 'OpenSocialShare'); ?>
                                <span class="oss-tooltip" data-title="<?php _e('Custom Post Types', 'OpenSocialShare'); ?>">
                                    <span class="dashicons dashicons-editor-help"></span>
                                </span>
                            </label>
                            <?php self::vertical_share_interface_position('Custom', $settings); ?>
                        </div><!-- unnamed div -->
                    </div>
                    
                </div><!-- Container -->
                <!-- End Vertical Sharing -->
            </div><?php
        }

        private static function horizontal_settings($settings) {
           
            ?>
            <!-- Horizontal Sharing -->
            <div id="oss_options_tab-1" class="oss-tab-frame oss-active">

                <!-- Horizontal Options -->
                <div class="oss_options_container">

                    <!-- Horizontal Switch -->
                    <div class="oss_enable_switch oss-row">
                        <label for="oss-enable-horizontal" class="oss-toggle">
                            <input type="checkbox" class="oss-toggle" id="oss-enable-horizontal" name="OpenSocialShare_share_settings[horizontal_enable]" value="1" <?php echo ( isset($settings['horizontal_enable']) && $settings['horizontal_enable'] == '1') ? 'checked' : ''; ?> />
                            <span class="oss-toggle-name"><?php _e('Enable Horizontal Widget', 'OpenSocialShare'); ?></span>
                        </label>
                    </div>
                    <div class="oss-option-disabled-hr"></div>
                    <div class="oss_horizontal_interface oss-row">
                        <h3><?php _e('Select the sharing theme', 'OpenSocialShare'); ?></h3>
                        <div>
                            <input type="radio" id="oss-horizontal-responsive" name="OpenSocialShare_share_settings[horizontal_share_interface]" value="responsive" <?php echo ( ! isset( $settings['horizontal_share_interface'] ) || $settings['horizontal_share_interface'] == 'responsive' ) ? 'checked' : ''; ?> />
                            <label class="oss_horizontal_interface_img" for="oss-horizontal-responsive"><img src="<?php echo OSS_SHARE_PLUGIN_URL . "/assets/images/sharing/responsive.png" ?>" /></label>
                        </div>
                        <div>
                            <input type="radio" id="oss-horizontal-lrg" name="OpenSocialShare_share_settings[horizontal_share_interface]" value="32-h" <?php echo ( $settings['horizontal_share_interface'] == '32-h' ) ? 'checked' : ''; ?> />
                            <label class="oss_horizontal_interface_img" for="oss-horizontal-lrg"><img src="<?php echo OSS_SHARE_PLUGIN_URL . "/assets/images/sharing/32-h.png" ?>" /></label>
                        </div>
                        <div>
                            <input type="radio" id="oss-horizontal-responce" name="OpenSocialShare_share_settings[horizontal_share_interface]" value="16-h" <?php echo ( $settings['horizontal_share_interface'] == '16-h' ) ? 'checked' : ''; ?> />
                            <label class="oss_horizontal_interface_img" for="oss-horizontal-sml"><img src="<?php echo OSS_SHARE_PLUGIN_URL . "/assets/images/sharing/16-h.png" ?>" /></label>
                        </div>
                        <div>
                            <input type="radio" id="oss-single-lg-h" name="OpenSocialShare_share_settings[horizontal_share_interface]" value="single-lg-h" <?php echo ( $settings['horizontal_share_interface'] == 'single-lg-h' ) ? 'checked' : ''; ?> />
                            <label class="oss_horizontal_interface_img" for="oss-single-lg-h"><img src="<?php echo OSS_SHARE_PLUGIN_URL . "/assets/images/sharing/single-lg-h.png" ?>" /></label>
                        </div>
                        <div>
                            <input type="radio" id="oss-single-sm-h" name="OpenSocialShare_share_settings[horizontal_share_interface]" value="single-sm-h" <?php echo ( $settings['horizontal_share_interface'] == 'single-sm-h' ) ? 'checked' : ''; ?> />
                            <label class="oss_horizontal_interface_img" for="oss-single-sm-h"><img src="<?php echo OSS_SHARE_PLUGIN_URL . "/assets/images/sharing/single-sm-h.png" ?>" /></label>
                        </div>
                        <div>
                            <input type="radio"  id="oss-sharing/hybrid-h-h" name="OpenSocialShare_share_settings[horizontal_share_interface]" value="hybrid-h-h" <?php echo ( $settings['horizontal_share_interface'] == 'hybrid-h-h' ) ? 'checked' : ''; ?> />
                            <label class="oss_horizontal_interface_img" for="oss-sharing/hybrid-h-h"><img src="<?php echo OSS_SHARE_PLUGIN_URL . "/assets/images/sharing/hybrid-h-h.png" ?>" /></label>
                        </div>
                        <div>
                            <input type="radio"  id="oss-hybrid-h-v" name="OpenSocialShare_share_settings[horizontal_share_interface]" value="hybrid-h-v" <?php echo ( $settings['horizontal_share_interface'] == 'hybrid-h-v' ) ? 'checked' : ''; ?> />
                            <label class="oss_horizontal_interface_img" for="oss-hybrid-h-v"><img src="<?php echo OSS_SHARE_PLUGIN_URL . "/assets/images/sharing/hybrid-h-v.png" ?>" /></label>
                        </div>
                    </div>
                    <div id="oss_hz_theme_options" class="oss-row cf">
                        <h3><?php _e('Select the sharing networks', 'OpenSocialShare'); ?>
                            <span class="oss-tooltip" data-title="<?php _e('Selected sharing networks will be displayed in the widget', 'OpenSocialShare'); ?>">
                                <span class="dashicons dashicons-editor-help"></span>
                            </span>
                        </h3>
                        <div id="oss_hz_hz_theme_options" style="display:block;">
                            <?php
                            $share_providers = self::share_provider();
                           
                            foreach ($share_providers as $provider) {
                                
                                ?>
                                <label class="oss-sharing-cb">
                                    <input type="checkbox" class="OpenSocialShare_hz_share_providers" name="OpenSocialShare_share_settings[horizontal_sharing_providers][Default][<?php echo $provider; ?>]" value="<?php echo $provider; ?>"  <?php if(isset($settings['horizontal_rearrange_providers'])){echo in_array($provider, $settings['horizontal_rearrange_providers'])  ? 'checked' : '';} ?> />
                                    <span class="oss-text oss-icon-<?php echo strtolower($provider); ?>"><?php echo $provider; ?></span>
                                </label>
                            <?php } ?>
                            <div id="ossHorizontalSharingLimit" class="oss-alert-box" style="display:none; margin-bottom: 5px;"><?php _e('You can select only eight providers', 'OpenSocialShare') ?>.</div>
                            <p class="oss-footnote">*<?php _e('All other icons will be included in the pop-up', 'OpenSocialShare'); ?></p>
                        </div>
                        <div id="oss_hz_ve_theme_options" style="display:none;">
                            <?php
                            $counter_providers = self::counter_provider();
                            foreach ($counter_providers as $provider) {
                                ?>
                                <label class="oss-sharing-cb">
                                    <input type="checkbox" class="OpenSocialShare_hz_ve_share_providers" name="OpenSocialShare_share_settings[horizontal_sharing_providers][Hybrid][<?php echo $provider; ?>]" value="<?php echo $provider; ?>" <?php echo ( isset($settings['horizontal_sharing_providers']['Hybrid'][$provider]) && $settings['horizontal_sharing_providers']['Hybrid'][$provider] == $provider ) ? 'checked' : ''; ?> />
                                    <span class="oss-text"><?php echo $provider; ?></span>
                                </label>
                            <?php } ?>
                            <div id="ossHorizontalVerticalSharingLimit" class="oss-alert-box" style="display:none; margin-bottom: 5px;">
                            <?php _e('You can select only eight providers', 'OpenSocialShare') ?>.
                            </div>
                            <p class="oss-footnote"></p>
                        </div>
                    </div>
                    <div class="oss-row" id="oss_horizontal_rearrange_container">
                        <h3>
                        <?php _e('Select the sharing networks order', 'OpenSocialShare') ?>
                            <span class="oss-tooltip" data-title="Drag the icons around to set the order">
                                <span class="dashicons dashicons-editor-help"></span>
                            </span>
                        </h3>

                        <ul id="ossHorizontalSortable" class="cf">
                            <?php
                            
                            if (isset($settings['horizontal_rearrange_providers']) && count($settings['horizontal_rearrange_providers']) > 0) {
                                foreach ($settings['horizontal_rearrange_providers'] as $provider) {
                                    ?>
                                    <li title="<?php echo $provider ?>" id="OpenSocialShareHorizontalLI<?php echo $provider; ?>" class="osshare_iconsprite32 oss-icon-<?php echo strtolower($provider); ?>">
                                        <input type="hidden" name="OpenSocialShare_share_settings[horizontal_rearrange_providers][]" value="<?php echo $provider ?>" />
                                    </li>
                                <?php
                            }
                        }
                        ?>
                        </ul>
                        <ul class="oss-static">
                            <li title="More" id="ossHorizontalLImore" class="oss-pin oss-icon-more osshare_evenmore"></li>
                            <li title="Counter" id="ossHorizontalLIcounter" class="oss-pin oss-counter">1.2m</li>
                        </ul>
                    </div>
                    <div class="oss-row cf">
                        <h3><?php _e('Choose the location(s) to display the widget', 'OpenSocialShare'); ?>
                            <span class="oss-tooltip" data-title="Sharing widget will be displayed at the selected location(s)">
                                <span class="dashicons dashicons-editor-help"></span>
                            </span>
                        </h3>
                        <div>
                            <input type="checkbox" class="oss-toggle" id="oss-clicker-hr-home" name="OpenSocialShare_share_settings[oss-clicker-hr-home]" value="1" <?php echo ( isset($settings['oss-clicker-hr-home']) && $settings['oss-clicker-hr-home'] == '1') ? 'checked' : ''; ?> />
                            <label class="oss-show-toggle" for="oss-clicker-hr-home">
                                <?php _e('Home Page', 'OpenSocialShare'); ?>
                                <span class="oss-tooltip" data-title="<?php _e('Home page of your blog', 'OpenSocialShare'); ?>">
                                    <span class="dashicons dashicons-editor-help"></span>
                                </span>
                            </label>
                            <?php self::horizontal_share_interface_position('Home', $settings); ?>
                        </div>
                        <div>
                            <input type="checkbox" class="oss-toggle" id="oss-clicker-hr-post" name="OpenSocialShare_share_settings[oss-clicker-hr-post]" value="1" <?php echo ( isset($settings['oss-clicker-hr-post']) && $settings['oss-clicker-hr-post'] == '1') ? 'checked' : ''; ?> />
                            <label class="oss-show-toggle" for="oss-clicker-hr-post">
                                <?php _e('Blog Post', 'OpenSocialShare'); ?>
                                <span class="oss-tooltip" data-title="<?php _e('Each post of your blog', 'OpenSocialShare'); ?>">
                                    <span class="dashicons dashicons-editor-help"></span>
                                </span>
                            </label>
                            <?php self::horizontal_share_interface_position('Posts', $settings); ?>
                        </div>
                        <div>
                            <input type="checkbox" class="oss-toggle" id="oss-clicker-hr-static" name="OpenSocialShare_share_settings[oss-clicker-hr-static]" value="1" <?php echo ( isset($settings['oss-clicker-hr-static']) && $settings['oss-clicker-hr-static'] == '1') ? 'checked' : ''; ?> />
                            <label class="oss-show-toggle" for="oss-clicker-hr-static">
                                <?php _e('Static Pages', 'OpenSocialShare'); ?>
                                <span class="oss-tooltip" data-title="<?php _e('Static pages of your blog (e.g &ndash; about, contact, etc.)', 'OpenSocialShare'); ?>">
                                    <span class="dashicons dashicons-editor-help"></span>
                                </span>
                            </label>
                            <?php self::horizontal_share_interface_position('Pages', $settings); ?>
                        </div>
                        <div>
                            <input type="checkbox" class="oss-toggle" id="oss-clicker-hr-excerpts" name="OpenSocialShare_share_settings[oss-clicker-hr-excerpts]" value="1" <?php echo ( isset($settings['oss-clicker-hr-excerpts']) && $settings['oss-clicker-hr-excerpts'] == '1') ? 'checked' : ''; ?> />
                            <label class="oss-show-toggle" for="oss-clicker-hr-excerpts">
                                <?php _e('Post Excerpts', 'OpenSocialShare'); ?>
                                <span class="oss-tooltip" data-title="<?php _e('Post excerpts page', 'OpenSocialShare'); ?>">
                                    <span class="dashicons dashicons-editor-help"></span>
                                </span>
                            </label>
                            <?php self::horizontal_share_interface_position('Excerpts', $settings); ?>
                        </div>
                        <div>
                            <input type="checkbox" class="oss-toggle" id="oss-clicker-hr-custom" name="OpenSocialShare_share_settings[oss-clicker-hr-custom]" value="1" <?php echo ( isset($settings['oss-clicker-hr-custom']) && $settings['oss-clicker-hr-custom'] == '1') ? 'checked' : ''; ?> />
                            <label class="oss-show-toggle" for="oss-clicker-hr-custom">
                                <?php _e('Custom Post Types', 'OpenSocialShare'); ?>
                                <span class="oss-tooltip" data-title="<?php _e('Custom Post Types', 'OpenSocialShare'); ?>">
                                    <span class="dashicons dashicons-editor-help"></span>
                                </span>
                            </label>
                            <?php self::horizontal_share_interface_position('Custom', $settings); ?>
                        </div>
                         
                       
                           
                        
                       
                        
                    </div>
                   
                </div><!-- Container -->
                <!-- End Horizontal Sharing -->
            </div>
            <?php
        }

        private static function advance_settings($settings) {
            ?>
            <!-- Advanced Settings -->
            <div id="oss_options_tab-3" class="oss-tab-frame">
                <div class="oss_options_container">
                    <div class="oss-row">
                        <h3><?php _e('Short Code for Sharing widget', 'OpenSocialShare'); ?>
                            <span class="oss-tooltip tip-bottom" data-title="<?php _e('Copy and paste the following shortcode into a page or post to display a horizontal sharing widget', 'OpenSocialShare'); ?>">
                                <span class="dashicons dashicons-editor-help"></span>
                            </span>
                        </h3>
                        <div>
                            <textarea rows="1" onclick="this.select()" spellcheck="false" class="oss-shortcode" readonly="readonly">[Social9_Share]</textarea>
                        </div>
                        <span><?php _e('Additional shortcode examples can be found <a target="_blank" href="http://www.social9.com/docs/wordpress-social-share#!shortcode" >Here</a>', 'OpenSocialShare'); ?></span>
                    </div><!-- oss-row -->
                     <div class="oss-row">
                         
                        <h4 class="advanceOptionFontSize"><?php _e('Mobile Friendly', 'OpenSocialShare'); ?>
                            <span class="oss-tooltip tip-bottom" data-title="<?php _e('Enable this option to show a mobile sharing interface to mobile users', 'OpenSocialShare'); ?>">
                                <span class="dashicons dashicons-editor-help"></span>
                            </span>
                        </h4>
                       
                            <label>
                                <input type="radio" class="mobile_enable" id="oss-enable-mobile-friendly" name="OpenSocialShare_share_settings[mobile_enable]" value="true" <?php echo ( !isset($settings['mobile_enable']) || $settings['mobile_enable'] == 'true') ? 'checked' : ''; ?> />
                                <span class="advanceOptionFontSize"><?php _e('True', 'oss-plugin-slug'); ?></span>
                            </label>
                            <label>
                                <input type="radio" class="mobile_enable" name="OpenSocialShare_share_settings[mobile_enable]" value="false" <?php echo ( ! isset( $settings['mobile_enable'] ) || $settings['mobile_enable'] == 'false' ) ? 'checked' : ''; ?>/> 
                            <span class="advanceOptionFontSize"><?php _e('False', 'oss-plugin-slug'); ?></span>
                            </label>
                    
                        
                        <label>
                            <span class="advanceOptionSpan advanceOptionFontSize oss_property_title"><?php _e( 'Please enter your desired email message', 'OpenSocialShare' ); ?></span>
                           
                            <input type="text" class="advanceOptionTextBox oss-row-field advanceOptionFontSize" name="OpenSocialShare_share_settings[emailMessage]" value="<?php echo (isset ($settings['emailMessage']) && !empty($settings['emailMessage']) ? $settings['emailMessage'] : '') ?>" />
                        </label>
                        <label>
                            <span class="advanceOptionSpan advanceOptionFontSize oss_property_title"><?php _e( 'Please enter your desired email subject', 'OpenSocialShare' ); ?></span>
                            <input type="text" class="advanceOptionTextBox advanceOptionFontSize oss-row-field" name="OpenSocialShare_share_settings[emailSubject]" value="<?php echo (isset ($settings['emailSubject']) && !empty($settings['emailSubject']) ? $settings['emailSubject'] : '') ?>"/>
                        </label>
                        
                         
                        <h4 class="advanceOptionFontSize"><?php _e('Do you want to make the email content read only? ', 'OpenSocialShare'); ?>
                        <span class="oss-tooltip tip-bottom" data-title="<?php _e(' Your readers wont be able to change the Email Content if its read only', 'OpenSocialShare'); ?>">
                                <span class="dashicons dashicons-editor-help"></span>
                            </span>
                        </h4> 
                        <label>
                            <input type="radio" class="email_content" name="OpenSocialShare_share_settings[emailcontent]" value="true" <?php echo ( ! isset( $settings['emailcontent'] ) || $settings['emailcontent'] == 'true' ) ? 'checked' : ''; ?> /> 
                            <span class="advanceOptionFontSize"><?php _e('True', 'oss-plugin-slug'); ?></span>
                        </label>
                        <label>
                            <input type="radio" class="email_content" name="OpenSocialShare_share_settings[emailcontent]" value="false" <?php echo ( ! isset( $settings['emailcontent'] ) || $settings['emailcontent'] == 'false' ) ? 'checked' : ''; ?>/> 
                            <span class="advanceOptionFontSize"><?php _e('False', 'oss-plugin-slug'); ?></span>
                        </label>
                        
                        
                     
                        <label>
                        <h4 class="advanceOptionFontSize"><?php _e('Do you want to use short URL during sharing? ', 'OpenSocialShare'); ?>
                        <span class="oss-tooltip tip-bottom" data-title="<?php _e(' Enable this if you want the URL to be shortened using Ish.re', 'OpenSocialShare'); ?>">
                                <span class="dashicons dashicons-editor-help"></span>
                            </span>
                        </h4> 
                        <label>
                            <input type="radio" class="shorten_url" name="OpenSocialShare_share_settings[shortenUrl]" value="true"  <?php echo ( ! isset( $settings['shortenUrl'] ) || $settings['shortenUrl'] == 'true' ) ? 'checked' : ''; ?>/> 
                            <span class="advanceOptionFontSize"><?php _e('True', 'oss-plugin-slug'); ?></span>
                        </label>
                        <label>
                            <input type="radio" class="shorten_url" name="OpenSocialShare_share_settings[shortenUrl]" value="false" <?php echo ( ! isset( $settings['shortenUrl'] ) || $settings['shortenUrl'] == 'false' ) ? 'checked' : ''; ?>/> 
                            <span class="advanceOptionFontSize"><?php _e('False', 'oss-plugin-slug'); ?></span>
                        </label>
                        </label>
                        
                        <label>
                            <span class="advanceOptionSpan advanceOptionFontSize oss_property_title"><?php _e( 'Enter your Facebook App ID', 'OpenSocialShare' ); ?>
                            <span class="oss-tooltip tip-bottom" data-title="<?php _e(' Enter the Facebook App Id if you want to track social sharing on your Facebook app', 'OpenSocialShare'); ?>">
                                <span class="dashicons dashicons-editor-help"></span>
                            </span>
                            </span>
                            <input type="text" class="advanceOptionTextBox oss-row-field" name="OpenSocialShare_share_settings[facebookAppId]" value="<?php echo (isset ($settings['facebookAppId']) && !empty($settings['facebookAppId']) ? $settings['facebookAppId'] : '') ?>" />
                        </label>    
                        
                                        
                        <h4 class="advanceOptionFontSize"><?php _e('Do you want to enable Total Share to display the total share count on your website?', 'OpenSocialShare'); ?>
                        <span class="oss-tooltip tip-bottom" data-title="<?php _e(' Display the total shares URL got from all social providers', 'OpenSocialShare'); ?>">
                                <span class="dashicons dashicons-editor-help"></span>
                            </span>
                        </h4> 
                        <label>
                            <input type="radio" class="shorten_url" name="OpenSocialShare_share_settings[isTotalShare]" value="true"  <?php echo ( ! isset( $settings['isTotalShare'] ) || $settings['isTotalShare'] == 'true' ) ? 'checked' : ''; ?>/> 
                            <span class="advanceOptionFontSize"><?php _e('True', 'oss-plugin-slug'); ?></span>
                        </label>
                        <label>
                            <input type="radio" class="shorten_url" name="OpenSocialShare_share_settings[isTotalShare]" value="false" <?php echo ( ! isset( $settings['isTotalShare'] ) || $settings['isTotalShare'] == 'false' ) ? 'checked' : ''; ?>/> 
                            <span class="advanceOptionFontSize"><?php _e('False', 'oss-plugin-slug'); ?></span>
                        </label>
                        
                        <h4 class="advanceOptionFontSize"><?php _e('Do you want to open all providers in a single window? ', 'OpenSocialShare'); ?>
                        <span class="oss-tooltip tip-bottom" data-title="<?php _e(' Disabling this opens all sharing providers in a new Popup', 'OpenSocialShare'); ?>">
                                <span class="dashicons dashicons-editor-help"></span>
                            </span>
                        </h4> 
                        <label>
                            <input type="radio" class="shorten_url" name="OpenSocialShare_share_settings[isOpenSingleWindow]" value="true"  <?php echo ( ! isset( $settings['isOpenSingleWindow'] ) || $settings['isOpenSingleWindow'] == 'true' ) ? 'checked' : ''; ?>/> 
                            <span class="advanceOptionFontSize"><?php _e('True', 'oss-plugin-slug'); ?></span>
                        </label>
                        <label>
                            <input type="radio" class="shorten_url" name="OpenSocialShare_share_settings[isOpenSingleWindow]" value="false" <?php echo ( ! isset( $settings['isOpenSingleWindow'] ) || $settings['isOpenSingleWindow'] == 'false' ) ? 'checked' : ''; ?>/> 
                            <span class="advanceOptionFontSize"><?php _e('False', 'oss-plugin-slug'); ?></span>
                        </label>
                        
                       <label id="customPopUpLabel">
                            <input type="checkbox" class="popupHeightWidth shorten_url" name="OpenSocialShare_share_settings[popupHeightWidth]" value="1" <?php echo ( isset( $settings['popupHeightWidth'] ) && $settings['popupHeightWidth'] == '1' ) ? 'checked' : ''; ?>/> 
                            <span class="advanceOptionFontSize"><?php _e('Use Custom Popup Window Size', 'oss-plugin-slug'); ?>
                             <span class="oss-tooltip tip-bottom" data-title="<?php _e('Check this if you want to change default Popup Window Size. [Default Size 530*530 Px]', 'OpenSocialShare'); ?>">
                                <span class="dashicons dashicons-editor-help"></span>
                            </span>
                            </span>
                        </label>
                        <div id="popupArea" style="display: none;">
                         <label>
                            <span class="advanceOptionSpan oss_property_title advanceOptionFontSize"><?php _e( 'Enter Height', 'OpenSocialShare' ); ?></span>
                             <input type="number" placeholder="530px" class="advanceOptionTextBox oss-row-field" name="OpenSocialShare_share_settings[popupWindowHeight]" value="<?php echo (isset ($settings['popupWindowHeight']) && !empty($settings['popupWindowHeight']) ? $settings['popupWindowHeight'] : '') ?>" />
                            <span class="errorMessageHeight" style="display: none;">Please Enter Height</span>
                        </label>  
                         <label>
                            <span class="advanceOptionSpan advanceOptionFontSize oss_property_title"><?php _e( 'Enter Width', 'OpenSocialShare' ); ?>
                            
                            </span>
                            <input type="number" placeholder="530px" class="advanceOptionTextBox oss-row-field" name="OpenSocialShare_share_settings[popupWindowWidth]" value="<?php echo (isset ($settings['popupWindowWidth']) && !empty($settings['popupWindowWidth']) ? $settings['popupWindowWidth'] : '') ?>" />
                             <span class="errorMessageWidth" style="display: none;">Please Enter Width</span>
                        </label>
                        </div>
                        <label style="margin-top:20px;">
                            <span class="advanceOptionSpan advanceOptionFontSize oss_property_title"><?php _e( 'Enter your desired Twitter handle to mention during a Twitter share.', 'OpenSocialShare' ); ?>
                            <span class="oss-tooltip tip-bottom" data-title="<?php _e('Handle will be mentioned as suffix as &OpenCurlyDoubleQuote;via @twitterhandle&CloseCurlyDoubleQuote;', 'OpenSocialShare'); ?>">
                                
                                <span class="dashicons dashicons-editor-help"></span>
                            </span>
                            </span>
                            <input type="text" class="advanceOptionTextBox oss-row-field" name="OpenSocialShare_share_settings[twittermention]" value="<?php echo (isset ($settings['twittermention']) && !empty($settings['twittermention']) ? $settings['twittermention'] : '') ?>" />
                        </label>  
                        
                        <label>
                            <span class="advanceOptionSpan advanceOptionFontSize oss_property_title"><?php _e( 'Enter your desired Twitter hash tags to be used during a Twitter share', 'OpenSocialShare' ); ?>
                            <span class="oss-tooltip tip-bottom" data-title="<?php _e('Hashtag will be added to all tweets', 'OpenSocialShare'); ?>">
                                <span class="dashicons dashicons-editor-help"></span>
                            </span>
                            </span>
                            <input type="text" class="advanceOptionTextBox oss-row-field" name="OpenSocialShare_share_settings[twitterhashtags]" value="<?php echo (isset ($settings['twitterhashtags']) && !empty($settings['twitterhashtags']) ? $settings['twitterhashtags'] : '') ?>" />
                        </label>
                        
                        <label class="customOptionLabel">
                            <span class="advanceOptionSpan advanceOptionFontSize oss_property_title"><?php _e( 'Please enter custom options for sharing interface', 'OpenSocialShare' ); ?>

                            </span>
                            <textarea name="OpenSocialShare_share_settings[customOptions]" id="customOptions" class="advanceOptionTextBox customOptionsCss"><?php echo (isset ($settings['customOptions']) && !empty($settings['customOptions']) ? $settings['customOptions'] : '') ?></textarea>
                        <span class="customOptionText">Choose form the list of options you want to customize from the <a target='_blank' href='http://www.social9.com/docs/custom-option-list'>link</a></span>
                        </label>
                        
                        <label style="display:none;" id="facebookPage">
                            <span class="advanceOptionSpan advanceOptionFontSize oss_property_title"><?php _e( 'Enter Facebook Page Url', 'OpenSocialShare' ); ?>
                            <span class="oss-tooltip tip-bottom" data-title="<?php _e('Enter your Facebook page URL if you want to increase page likes, This add your Facebook page like button to all the web page on your site', 'OpenSocialShare'); ?>">
                                <span class="dashicons dashicons-editor-help"></span>
                            </span>
                            </span>
                            <input type="text" class="advanceOptionTextBox oss-row-field" name="OpenSocialShare_share_settings[facebookPage]" value="<?php echo (isset ($settings['facebookPage']) && !empty($settings['facebookPage']) ? $settings['facebookPage'] : '') ?>" />
                        </label>  

                    </div>
                </div>
            </div>
            <?php
        }

        /**
         * Render social sharing settings page.
         */
        public static function render_options_page() {
            global $oss_share_settings;
            
            $oss_share_settings = get_option('OpenSocialShare_share_settings');
            
            if ( isset( $_POST['reset'] ) ) {
                OSS_Sharing_Install::reset_share_options();
                echo '<p style="display:none;" class="oss-alert-box oss-notif">Sharing settings have been reset and default values have been applied to the plug-in</p>';
                echo '<script type="text/javascript">jQuery(function(){jQuery(".oss-notif").slideDown().delay(3000).slideUp();});</script>';
            }
            
            ?>
            <!-- OSS-wrap -->
            
            <div class="wrap oss-wrap cf">
                
                <header>
                    <h2 class="logo"><a href="//www.social9.com?utm_source=WordPress&utm_medium=Refferal&utm_campaign=Plugin" target="_blank">social9</a><em>Simplified Social Share</em></h2>
                    <div class="subscribeMessage"></div>
                    <div class="showPluginHomePopUp"></div>
                </header>
               
                    <ul class="oss-options-tab-btns">
                        <li class="nav-tab oss-active" data-tab="oss_options_tab-1"><?php _e( 'Horizontal Sharing', 'OpenSocialShare' ) ?></li>
                        <li class="nav-tab" data-tab="oss_options_tab-2"><?php _e( 'Vertical Sharing', 'OpenSocialShare' ) ?></li>
                        <li class="nav-tab" data-tab="oss_options_tab-3"><?php _e( 'Advanced Settings', 'OpenSocialShare' ) ?></li>
                    </ul>
                     <div id="oss_options_tabs" class="cf">
                    <!-- Settings -->
                    <form id="oSSAdvanceSetting" method="post" action="options.php">
                        <?php
                        settings_fields('opensocialshare_share_settings');
                        settings_errors();
                        self::horizontal_settings( $oss_share_settings );
                        self::vertical_settings( $oss_share_settings );
                        self::advance_settings( $oss_share_settings );
                        submit_button('Save changes');
                        ?>
                    </form>
                    <?php do_action( 'oss_reset_admin_ui','Social Sharing' );?>
                </div>
                <!-- Settings -->
                <div class="oss-sidebar">
                    <div class="oss-frame">
                        <h4><?php _e('Help', 'OpenSocialShare'); ?></h4>
                        <div>
                            <a target="_blank" href="http://www.social9.com/docs/wordpress-social-share?utm_source=WordPress&utm_medium=Refferal&utm_campaign=Plugin"><?php _e('Plugin Installation, Configuration and Troubleshooting', 'OpenSocialShare') ?></a>
                            <a target="_blank" href="http://www.social9.com/features?utm_source=WordPress&utm_medium=Refferal&utm_campaign=Plugin"><?php _e('Social9 Features', 'OpenSocialShare') ?></a>

                        </div>
                    </div><!-- oss-frame -->
                    <iframe src="//www.facebook.com/plugins/likebox.php?href=https://www.facebook.com/social9dotcom&width=360&height=200&colorscheme=dark&show_faces=true&header=false&stream=false&show_border=true" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100%; height:161px;" allowtransparency="true"></iframe>
                </div>
            </div><!-- End OSS-wrap -->

            <?php
        }

    }

    new OSS_Social_Share_Settings();
}