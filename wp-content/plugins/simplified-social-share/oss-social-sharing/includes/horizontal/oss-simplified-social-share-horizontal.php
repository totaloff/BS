<?php

// If this file is called directly, abort.
defined( 'ABSPATH' ) or die();

/**
 * The horizontal sharing class.
 */
if ( ! class_exists( 'OSS_Horizontal_Sharing' ) ) {

    class OSS_Horizontal_Sharing {

        /**
         * Constructor
         */
        public function __construct() {
            add_filter('the_content', array($this, 'opensocialshare_share_horizontal_content'));
            add_filter('get_the_excerpt', array($this, 'opensocialshare_share_horizontal_content'));
        }

        /**
         * Output Sharing <div> for the content.
         * 
         * @global type $post
         * @global type $oss_share_settings
         * @param type $content
         * @return string
         */
        function opensocialshare_share_horizontal_content( $content ) {
            global $post, $oss_share_settings;

            $return = '';
            $top = false;
            $bottom = false;

            if (is_object($post)) {
                $ossMeta = get_post_meta($post->ID, '_oss_meta', true);

                // if sharing disabled on this page/post, return content unaltered.
                if (isset($ossMeta['sharing']) && $ossMeta['sharing'] == '1' && !is_front_page()) {
                    return $content;
                }
            }
            OSS_Common_Sharing::horizontal_sharing();
            if (current_filter() == 'the_content') {
                // Show on Post.
                if ( is_single() && $post->post_type == 'post' && ( isset($oss_share_settings['oss-clicker-hr-post']) && $oss_share_settings['oss-clicker-hr-post'] == '1' )) {
                    if (isset($oss_share_settings['horizontal_position']['Posts']['Top']))
                        $top = true;
                    if (isset($oss_share_settings['horizontal_position']['Posts']['Bottom']))
                        $bottom = true;
                }

                // Show on Custom Post Types
                if ( is_single() && $post->post_type != 'post' && ( isset($oss_share_settings['oss-clicker-hr-custom']) && $oss_share_settings['oss-clicker-hr-custom'] == '1' )) {
                    if (isset($oss_share_settings['horizontal_position']['Custom']['Top']))
                        $top = true;
                    if (isset($oss_share_settings['horizontal_position']['Custom']['Bottom']))
                        $bottom = true;
                }

                // Show on home Page.
                if ( is_front_page() && ( isset($oss_share_settings['oss-clicker-hr-home']) && $oss_share_settings['oss-clicker-hr-home'] == '1' )) {
                    if (isset($oss_share_settings['horizontal_position']['Home']['Top']))
                        $top = true;
                    if (isset($oss_share_settings['horizontal_position']['Home']['Bottom']))
                        $bottom = true;
                }

                // Show on Static Page.
                if ( is_page() && (isset($oss_share_settings['oss-clicker-hr-static']) && $oss_share_settings['oss-clicker-hr-static'] == '1' )) {
                    if (isset($oss_share_settings['horizontal_position']['Pages']['Top']))
                        $top = true;
                    if (isset($oss_share_settings['horizontal_position']['Pages']['Bottom']))
                        $bottom = true;
                }

                // Show on Posts Page when a static page is the front.
                if ( is_home() && ! is_front_page() && (isset($oss_share_settings['oss-clicker-hr-excerpts']) && $oss_share_settings['oss-clicker-hr-excerpts'] == '1' )) {
                    if (isset($oss_share_settings['horizontal_position']['Excerpts']['Top']))
                        $top = true;
                    if (isset($oss_share_settings['horizontal_position']['Excerpts']['Bottom']))
                        $bottom = true;
                }

                // Show on Excerpts Page.
                if ( has_excerpt($post->ID) && (isset($oss_share_settings['oss-clicker-hr-excerpts']) && $oss_share_settings['oss-clicker-hr-excerpts'] == '1' )) {
                    if (isset($oss_share_settings['horizontal_position']['Excerpts']['Top']))
                        $top = true;
                    if (isset($oss_share_settings['horizontal_position']['Excerpts']['Bottom']))
                        $bottom = true;
                }
            }

            if ( current_filter() == 'get_the_excerpt' && isset($oss_share_settings['oss-clicker-hr-excerpts']) && $oss_share_settings['oss-clicker-hr-excerpts'] == '1' ) {
                if ( isset($oss_share_settings['horizontal_position']['Excerpts']['Top'])) {
                    $top = true;
                }
                if ( isset($oss_share_settings['horizontal_position']['Excerpts']['Bottom'])) {
                    $bottom = true;
                }
            }

            if ($top) {

                $return = '<div  class="oss_horizontal_share oss_title_replace" data-share-titles="'.get_the_title($post->ID).'" data-share-description="'.substr(wp_strip_all_tags($post->post_content), '0', 100).'" data-share-imageurl="'.wp_get_attachment_url( get_post_thumbnail_id() ).'"  data-share-url="' . get_permalink($post->ID) . '"></div>';
            }

            $return .= $content;

            if ($bottom) {
               
                $return .= '<div  class="oss_horizontal_share oss_title_replace" data-share-titles="'.get_the_title($post->ID).'" data-share-description="'.substr(wp_strip_all_tags($post->post_content), '0', 100).'" data-share-imageurl="'.wp_get_attachment_url( get_post_thumbnail_id() ).'" data-share-url="' . get_permalink($post->ID) . '" ></div>';
            }
            return $return;
        }
    }

    new OSS_Horizontal_Sharing();
}
