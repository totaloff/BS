<?php
// If this file is called directly, abort.
defined( 'ABSPATH' ) or die();

/**
 * This file is responsible for creating Social Share Horizontal widget.
 */
class OSS_Horizontal_Share_Widget extends WP_Widget {

    /**
     * Constructor
     * Sets up the widgets name etc
     */
    function __construct() {
        parent::__construct(
            'OssHorizontalShare', // Base ID
            __( 'OpenSocialShare - Horizontal Sharing', 'OpenSocialShare' ), // Name
            array( 'description' => __( 'Share content with Facebook, Twitter, Yahoo, Google and many more', 'OpenSocialShare' ), ) // Args
        );
    }

    /**
     * Outputs the content of the widget
     *
     * @param array $args
     * @param array $instance
     */
    function widget($args, $instance) {
        global $post, $oss_share_settings;


        if (is_object($post)) {
            $ossMeta = get_post_meta($post->ID, '_oss_meta', true);

            // If sharing disabled on this page/post, return content unaltered.
            if (isset($ossMeta['sharing']) && $ossMeta['sharing'] == 1 && !is_front_page()) {
                return;
            }
        }

        extract($args);

        if ($instance['hide_for_logged_in'] == 1 && is_user_logged_in()) {
            return;
        }
        echo $before_widget;

        if (!empty($instance['before_widget_content'])) {
            echo $instance['before_widget_content'];
        }
        OSS_Common_Sharing::horizontal_sharing();
        echo '<div class="oss_horizontal_share"></div>';

        if ( ! empty( $instance['after_widget_content'] ) ) {
            echo $instance['after_widget_content'];
        }
        echo $after_widget;
    }

    /**
     * Processing widget options on save
     *
     * @param array $new_instance The new options
     * @param array $old_instance The previous options
     */
    function update($new_instance, $instance) {
        $instance['before_widget_content'] = $new_instance['before_widget_content'];
        $instance['after_widget_content'] = $new_instance['after_widget_content'];
        $instance['hide_for_logged_in'] = $new_instance['hide_for_logged_in'];

        return $instance;
    }

    /**
     * Outputs the options form on admin
     *
     * @param array $instance The widget options
     */
    function form($instance) {
        // Set up default widget settings.
        $defaults = array('before_widget_content' => '', 'after_widget_content' => '', 'hide_for_logged_in' => '1');

        foreach ($instance as $key => $value) {
            $instance[$key] = esc_attr($value);
        }

        $instance = wp_parse_args((array) $instance, $defaults);
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('before_widget_content'); ?>"><?php _e('Before widget content:', 'OpenSocialShare'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('before_widget_content'); ?>" name="<?php echo $this->get_field_name('before_widget_content'); ?>" type="text" value="<?php echo $instance['before_widget_content']; ?>" />
            <label for="<?php echo $this->get_field_id('after_widget_content'); ?>"><?php _e('After widget content:', 'OpenSocialShare'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('after_widget_content'); ?>" name="<?php echo $this->get_field_name('after_widget_content'); ?>" type="text" value="<?php echo $instance['after_widget_content']; ?>" />
            <br /><br />
            <label for="<?php echo $this->get_field_id('hide_for_logged_in'); ?>"><?php _e('Hide for logged in users:', 'OpenSocialShare'); ?></label>
            <input type="checkbox" id="<?php echo $this->get_field_id('hide_for_logged_in'); ?>" name="<?php echo $this->get_field_name('hide_for_logged_in'); ?>" type="text" value='1' <?php if ($instance['hide_for_logged_in'] == 1) echo 'checked="checked"'; ?> />
        </p>
        <?php
    }

}

add_action( 'widgets_init', function(){
     register_widget( 'OSS_Horizontal_Share_Widget' );
});