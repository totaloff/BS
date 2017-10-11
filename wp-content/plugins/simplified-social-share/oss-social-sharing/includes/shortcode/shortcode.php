<?php

// Exit if called directly
if ( ! defined( 'ABSPATH' ) ) {
    exit();
}

/**
 * The front function class of OpenSocialShare.
 */
if ( ! class_exists( 'OSS_Social_Share_Shortcode' ) ) {

    class OSS_Social_Share_Shortcode {

        /**
         * Constructor
         * Shortcode for social sharing.
         */
        public function __construct() {
	   add_shortcode('Social9_Share', array($this, 'sharing_shortcode'));
	   add_shortcode('emptyCode', array($this, 'emptyShortcode'));
          

        }
        public static function emptyShortcode() {
    return '';
}
        /**
         * This function will be used to insert content where shortcode is used.
         * Shortcode [Social9_Share]
	 * Shortcode [Oss_Share]
         * 
         * @global type $post
         * @global type $oss_share_settings
         * @param type $params
         * @return type
         */
        public static function sharing_shortcode($params) {
            global $post, $oss_share_settings;
            
            if (is_object($post)) {
                $ossMeta = get_post_meta($post->ID, '_oss_meta', true);

                // if sharing disabled on this page/post, return content unaltered.
                if (isset($ossMeta['sharing']) && $ossMeta['sharing'] == 1 && !is_front_page()) {
                    return;
                }
            }

            // Default parameters for shortcode.
            $default = array(
                'style' => '',
                'type' => 'horizontal',
            );

            // Extracting parameters.
            extract( shortcode_atts($default, $params) );
           
                if ( $style != '' ) {
                    $style = 'style="' . $style . '"';
                }
               

                if ($type == 'vertical' && isset($oss_share_settings['vertical_enable']) && $oss_share_settings['vertical_enable'] == '1') {
                $styleVerticalLayout = '';
                $position = isset($params['position']) ? $params['position'] : 'top_left';
                
                if ($position == 'top_left') {
                    $styleVerticalLayout = 'style=top:10px;position:fixed!important;left:0px';
                } else if ($position == 'top_right') {
                    $styleVerticalLayout = 'style=top:10px;position:fixed!important;right:0px';
                } else if ($position == 'bottom_left') {
                    $styleVerticalLayout = 'style=bottom:0px;position:fixed!important;left:0px';
                } else if ($position == 'bottom_right') {
                    $styleVerticalLayout = 'style=bottom:0px;position:fixed!important;right:0px';
               
                } else if ($position == 'middle_right') {
                    $styleVerticalLayout = 'style=position:fixed!important;right:0px;top:200px;';
                } else if ($position == 'middle_left') {
                    $styleVerticalLayout = 'style=position:fixed!important;left:0px;top:200px;';
                }
                OSS_Common_Sharing::vertical_sharing();
                $unique_id = uniqid();
                OSS_Vertical_Sharing::$position['class'][] = $unique_id;
                $share = OSS_Vertical_Sharing::get_vertical_sharing('oss_ver_share_shortcode ' . $unique_id, $styleVerticalLayout);
            }
            if ($type == 'horizontal' && isset($oss_share_settings['horizontal_enable']) && $oss_share_settings['horizontal_enable'] == '1') {
                    OSS_Common_Sharing::horizontal_sharing();
                    $share = '<div class="oss_title_replace oss_horizontal_share" ' . $style . ' data-share-titles="'.get_the_title($post->ID).'" data-share-description="'.substr(wp_strip_all_tags($post->post_content), '0', 100).'" data-share-imageurl="'.wp_get_attachment_url( get_post_thumbnail_id() ).'" data-share-url="' . get_permalink($post->ID) . '"></div>';
                } 

                return isset($share) ? $share : '';
        }

    }

    new OSS_Social_Share_Shortcode();
}
