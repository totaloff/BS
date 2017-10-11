<?php
// If this file is called directly, abort.
defined('ABSPATH') or die();

/**
 * The horizontal sharing class.
 */
if (!class_exists('OSS_Vertical_Sharing')) {

    class OSS_Vertical_Sharing {

        static $params;
        static $position;

        /**
         * Constructor
         * 
         * @global type $oss_js_in_footer
         */
        public function __construct() {
            global $oss_js_in_footer;
            // Enqueue main scripts in footer
            if ($oss_js_in_footer) {
                add_action('wp_footer', array($this, 'vertical_page_content'), 1);
            } else {
                add_action('wp_enqueue_scripts', array($this, 'vertical_page_content'), 2);
            }
        }

        /**
         * Get OpenSocialShare Vertical div container.
         * 
         * @param type $class
         * @param type $style
         * @return type
         */
        static function get_vertical_sharing($class, $style = '') {
            global $post;
            return '<div class="oss_title_replace oss-share-vertical-fix ' . $class . '" ' . $style . ' data-share-titles="'.get_the_title($post->ID).'" data-share-description="'.substr(wp_strip_all_tags($post->post_content), '0', 100).'" data-share-imageurl="'.wp_get_attachment_url( get_post_thumbnail_id() ).'"  data-share-url="' . get_permalink($post->ID) . '"></div>';
        }

        /**
         * 
         * @global type $oss_share_settings
         * @param type $page
         * @param type $position
         * @return boolean
         */
        private static function get_vertical_position_option($page, $position) {
          
            global $oss_share_settings;
            $verticalposition =array('Top Left'=>'top_left','Top Right'=>'top_right','Middle Right'=>'middle_right','Middle Left'=>'middle_left','Bottom Left'=>'bottom_left','Bottom Right'=>'bottom_right');
            
            foreach ($verticalposition as $key => $value) {
                if ( isset($oss_share_settings['vertical_position'][$page]) && $oss_share_settings['vertical_position'][$page] == $key ) {
                $position[$value] = true;
                }
            }
            return $position;
        }

        /**
         * 
         * @global type $oss_share_settings
         * @return type
         */
        public static function get_vertical_position() {
            global $post, $oss_share_settings;

                $position['top_left'] = $position['top_right'] = $position['middle_right'] = $position['middle_left'] = $position['bottom_left'] = $position['bottom_right'] = false;
            	
                // Show on static Pages.
                if ( is_page() && !is_front_page() && ( isset($oss_share_settings['oss-clicker-vr-static']) && $oss_share_settings['oss-clicker-vr-static'] == '1' )) {
                	$position = self::get_vertical_position_option('Static', $position);
                }
    	        // Show on Front home Page.
    	        if ( is_front_page() && ( isset($oss_share_settings['oss-clicker-vr-home']) && $oss_share_settings['oss-clicker-vr-home'] == '1' )) {
    	        	$position = self::get_vertical_position_option('Home', $position);
    	     	}
                // Show on Posts.
                
                if ( is_single() && $post->post_type == 'post' && ( isset($oss_share_settings['oss-clicker-vr-post']) && $oss_share_settings['oss-clicker-vr-post'] == '1' ) ) {
                    $position = self::get_vertical_position_option('Post', $position);
                    
                }

                // Show on Custom Post Types
                if ( is_single() && $post->post_type != 'post' && ( isset($oss_share_settings['oss-clicker-vr-custom']) && $oss_share_settings['oss-clicker-vr-custom'] == '1' ) ) {
                    $position = self::get_vertical_position_option('Custom', $position);
                }
                return $position;
        }

        /**
         * Output Sharing for the content.
         * 
         * @global type $post
         * @param type $content
         * @return type
         */
        function vertical_page_content($content) {
            global $post;
            if (is_object($post)) {
                $ossMeta = get_post_meta($post->ID, '_oss_meta', true);

                // if sharing disabled on this page/post, return content unaltered.
                if (isset($ossMeta['sharing']) && $ossMeta['sharing'] == 1 && !is_front_page()) {
                    return $content;
                }
            }
            OSS_Common_Sharing::vertical_sharing();
            $position = self::get_vertical_position();

            if ($position['top_left']) {
                $class = uniqid('oss_');
                self::$params['top_left']['class'] = $class;
                $style = 'style="position: fixed;top: 0px;left: 0;"';
                $content .= self::get_vertical_sharing($class, $style);
            }
            if ($position['top_right']) {
                $class = uniqid('oss_');
                self::$params['top_right']['class'] = $class;
                $style = 'style="position: fixed;top: 0px;right: 0;"';
                $content .= self::get_vertical_sharing($class, $style);
            }
            if ($position['middle_right']) {
                $class = uniqid('oss_');
                self::$params['middle_right']['class'] = $class;
                $style = 'style="position: fixed;top: 200px;right: 0;"';
                $content .= self::get_vertical_sharing($class, $style);
            }
            if ($position['middle_left']) {
                $class = uniqid('oss_');
                self::$params['middle_left']['class'] = $class;
                $style = 'style="position: fixed;top: 200px;left: 0;"';
                $content .= self::get_vertical_sharing($class, $style);
            }
            if ($position['bottom_left']) {
                $class = uniqid('oss_');
                self::$params['bottom_left']['class'] = $class;
                $style = 'style="position: fixed;bottom: 0px;left: 0;"';
                $content .= self::get_vertical_sharing($class, $style);
            }
            if ($position['bottom_right']) {
                $class = uniqid('oss_');
                self::$params['bottom_right']['class'] = $class;
                $style = 'style="position: fixed;bottom: 0px;right: 0;"';
                $content .= self::get_vertical_sharing($class, $style);
            }

            echo $content;
        }

    }

    new OSS_Vertical_Sharing();
}