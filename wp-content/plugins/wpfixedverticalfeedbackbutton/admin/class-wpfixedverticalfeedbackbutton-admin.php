<?php

    /**
     * The admin-specific functionality of the plugin.
     *
     * @link       http://codeboxr.com
     * @since      1.0.0
     *
     * @package    Wpfixedverticalfeedbackbutton
     * @subpackage Wpfixedverticalfeedbackbutton/admin
     */

    /**
     * The admin-specific functionality of the plugin.
     *
     * Defines the plugin name, version, and two examples hooks for how to
     * enqueue the admin-specific stylesheet and JavaScript.
     *
     * @package    Wpfixedverticalfeedbackbutton
     * @subpackage Wpfixedverticalfeedbackbutton/admin
     * @author     Codeboxr <info@codeboxr.com>
     */
    class Wpfixedverticalfeedbackbutton_Admin {

        /**
         * The ID of this plugin.
         *
         * @since    1.0.0
         * @access   private
         * @var      string $plugin_name The ID of this plugin.
         */
        private $plugin_name;

        /**
         * The plugin basename of the plugin.
         *
         * @since    1.0.0
         * @access   protected
         * @var      string $plugin_basename The plugin basename of the plugin.
         */
        protected $plugin_basename;

        /**
         * The version of this plugin.
         *
         * @since    1.0.0
         * @access   private
         * @var      string $version The current version of this plugin.
         */
        private $version;

        /**
         * Initialize the class and set its properties.
         *
         * @since    1.0.0
         *
         * @param      string $plugin_name The name of this plugin.
         * @param      string $version     The version of this plugin.
         */
        public function __construct($plugin_name, $version) {

            $this->plugin_name = $plugin_name;
            $this->version     = $version;

            $this->plugin_basename = plugin_basename(plugin_dir_path(__DIR__) . $plugin_name . '.php');

        }


        public function post_row_actions_on_cbxfeedbackbtn($actions, $post) {

            if ($post->post_type == "cbxfeedbackbtn") {
                unset($actions['inline hide-if-no-js']);
                unset($actions['view']);
            }

            return $actions;

        }


        /**
         * Manipular columns in cbxfeedbackbtn post type listing
         *
         * @param $columns
         *
         * @since 3.7.0
         *
         * @return mixed
         *
         */
        public function cbxfeedbackbtn_columns($columns) {


            unset($columns['date']);

            return $columns;
        }

        /**
         * Add metabox for custom post type cbxfeedbackbtn
         *
         * @since    1.0.0
         */
        public function add_meta_boxes_feedbackbtn() {


            add_meta_box(
                'cbxfeedbackbtnmetabox', __('Feedback Button Parameters', $this->plugin_name), array($this, 'cbxfeedbackbtnmetabox_display'), 'cbxfeedbackbtn', 'normal', 'high'
            );
        }

        /**
         * Register the stylesheets for the admin area.
         *
         * @since    1.0.0
         */
        public function enqueue_styles($hook) {



            /**
             * This function is provided for demonstration purposes only.
             *
             * An instance of this class should be passed to the run() function
             * defined in Wpfixedverticalfeedbackbutton_Loader as all of the hooks are defined
             * in that particular class.
             *
             * The Wpfixedverticalfeedbackbutton_Loader will then create the relationship
             * between the defined hooks and the functions defined in this
             * class.
             */
            global $post_type;

            if ($hook == 'post.php' || $hook == 'post-new.php' || $hook == 'edit.php') {
                if ('cbxfeedbackbtn' == $post_type) {
                    wp_register_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/wpfixedverticalfeedbackbutton-admin.css', array(), $this->version, 'all');
                    wp_enqueue_style($this->plugin_name);
                }

            }


        }

        /**
         * Register the JavaScript for the admin area.
         *
         * @since    1.0.0
         */
        public function enqueue_scripts($hook) {

            global $post_type;

            /**
             * This function is provided for demonstration purposes only.
             *
             * An instance of this class should be passed to the run() function
             * defined in Wpfixedverticalfeedbackbutton_Loader as all of the hooks are defined
             * in that particular class.
             *
             * The Wpfixedverticalfeedbackbutton_Loader will then create the relationship
             * between the defined hooks and the functions defined in this
             * class.
             */

            //adding js to post edit or add screen
            if ($hook == 'post.php' || $hook == 'post-new.php') {
                //adding js script to cbxfeedbackbtn custom post type edit or add screen
                if ('cbxfeedbackbtn' == $post_type) {

                    wp_enqueue_style('wp-color-picker');

                    wp_register_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/wpfixedverticalfeedbackbutton-admin-btn.js', array('jquery', 'wp-color-picker'), $this->version, false);

                    $translation_array = array(
                        'uploadtext' => __('Upload Image', 'wpfixedverticalfeedbackbutton')
                    );
                    wp_localize_script($this->plugin_name, 'wpfixedverticalfeedbackbutton', $translation_array);


                    wp_enqueue_script($this->plugin_name);
                }

            }


        }


        /**
         * Register Custom Post Type cbxfeedbackbtn
         *
         * @since    3.7.0
         */
        public function create_feedbackbutton() {

            $labels = array(
                'name'               => _x('Feedback Button', 'Post Type General Name', $this->plugin_name),
                'singular_name'      => _x('Feedback Button', 'Post Type Singular Name', $this->plugin_name),
                'menu_name'          => __('CBX Feedback', $this->plugin_name),
                'parent_item_colon'  => __('Parent Item:', $this->plugin_name),
                'all_items'          => __('All Buttons', $this->plugin_name),
                'view_item'          => __('View Button', $this->plugin_name),
                'add_new_item'       => __('Add New Feedback Button', $this->plugin_name),
                'add_new'            => __('Add New', $this->plugin_name),
                'edit_item'          => __('Edit Button', $this->plugin_name),
                'update_item'        => __('Update Button', $this->plugin_name),
                'search_items'       => __('Search Feedback Button', $this->plugin_name),
                'not_found'          => __('Not found', $this->plugin_name),
                'not_found_in_trash' => __('Not found in Trash', $this->plugin_name),
            );
            $args   = array(
                'label'               => __('Feedback Button', $this->plugin_name),
                'description'         => __('Feedback Buttons', $this->plugin_name),
                'labels'              => $labels,
                'supports'            => array('title', 'editor'),
                'hierarchical'        => false,
                'public'              => false,
                'show_ui'             => true,
                'show_in_menu'        => true,
                'show_in_nav_menus'   => true,
                'show_in_admin_bar'   => true,
                //'menu_position'       => 5,
                'menu_icon'           => 'dashicons-email',  //<span class="dashicons dashicons-email"></span>
                'can_export'          => true,
                'has_archive'         => false,
                'exclude_from_search' => true,
                'publicly_queryable'  => false,
                'capability_type'     => 'post',
            );
            register_post_type('cbxfeedbackbtn', $args);

        }


        /**
         * Render Metabox under custom post type cbxfeedbackbtn
         *
         * @param $post
         *
         * @since 3.7
         *
         */
        public function cbxfeedbackbtnmetabox_display($post) {

            $fieldValues = get_post_meta($post->ID, '_cbxfeedbackbtnmeta', true);

            /* echo '<pre>';
             print_r($fieldValues);
             echo '</pre>';*/


            wp_nonce_field('cbxfeedbackbtnmetabox', 'cbxfeedbackbtnmetabox[nonce]');
            //<input type="hidden" id="name_of_nonce_field" name="name_of_nonce_field" value="a62a76f53d">

            //echo '<h2>'.__('Shortcode Usages:', $this->plugin_name).'</h2>';
            //echo '<code>[cbxdynamicsidebar id="'.$post->ID.'" float="auto" wid="" wclass="" /]</code>';

            echo '<div id="cbxfeedbackbtnmetabox_wrapper">';


            $showtype = isset($fieldValues['showtype']) ? intval($fieldValues['showtype']) : 1; //show type
            $postlist = isset($fieldValues['postlist']) ? esc_attr($fieldValues['postlist']) : '';


            $vertical   = isset($fieldValues['vertical']) ? intval($fieldValues['vertical']) : 50; //vertical alignment
            $horizontal = isset($fieldValues['horizontal']) ? intval($fieldValues['horizontal']) : 0; //horizontal alignment

            $bcolor = isset($fieldValues['bcolor']) ? esc_attr($fieldValues['bcolor']) : '#0066CC'; //button backend color
            $hcolor = isset($fieldValues['hcolor']) ? esc_attr($fieldValues['hcolor']) : '#FF8B00'; //button hover color

            $btext             = isset($fieldValues['btext']) ? esc_attr($fieldValues['btext']) : 'contact_small.png'; //button text can be image or custom image or custom text
            $btext_cust_img    = isset($fieldValues['btext_img']) ? esc_attr($fieldValues['btext_img']) : ''; //button custom image
            $btext_cust_height = isset($fieldValues['btext_height']) ? esc_attr($fieldValues['btext_height']) : ''; //button custom image height in px
            $btext_cust_text   = isset($fieldValues['btext_text']) ? esc_attr($fieldValues['btext_text']) : ''; //custom text as button text


            //post id is used to get permalink for button if used
            $postid      = isset($fieldValues['postid']) ? intval($fieldValues['postid']) : 0; //post id (post, page or any post type in wordpress)
            $custom_link = isset($fieldValues['custom_link']) ? esc_attr($fieldValues['custom_link']) : ''; //custom link for button
            $link_title  = isset($fieldValues['link_title']) ? esc_attr($fieldValues['link_title']) : ''; //custom link title
            $link_target = isset($fieldValues['link_target']) ? esc_attr($fieldValues['link_target']) : '_blank'; //link target


            $bcolor = WpfixedverticalfeedbackbuttonHelper::maybe_hash_hex_color($bcolor);
            $hcolor = WpfixedverticalfeedbackbuttonHelper::maybe_hash_hex_color($hcolor);
            $postid = ($postid == 0) ? '' : $postid;  //just for showing purpose


            ?>


            <table class="form-table">
                <tbody>
                <?php
                    do_action('wpfvfbtn_button_setting_before_start', $fieldValues);
                ?>
                <tr valign="top">
                    <td><?php _e('Visibility', $this->plugin_name); ?></td>
                    <td>


                        <p><?php _e('Post/page Binding', $this->plugin_name); ?></p><br/>
                        <input id="showtype-on" type="radio" <?php echo($showtype == 1 ? 'checked="checked"' : ''); ?>
                               value="1" name="cbxfeedbackbtnmetabox[showtype]"/>
                        <label
                            for="showtype-on"><?php _e('Show only in following post(s)', $this->plugin_name); ?></label>
                        <input id="showtype-off" type="radio" <?php echo($showtype == 0 ? 'checked="checked"' : ''); ?>
                               value="0" name="cbxfeedbackbtnmetabox[showtype]"/>
                        <label for="showtype-off"><?php _e('Hide in following post(s)', $this->plugin_name); ?></label>

                        <p class="description"><?php _e('Post the post IDs here to show/hide for particular pages/posts. Comma(,) separated list. Leave the list blank for no filter.', $this->plugin_name); ?></p>
                        <br/>
                        <input placeholder="<?php _e('Put the post, page IDs with comma', $this->plugin_name); ?>"
                               type="text" name="cbxfeedbackbtnmetabox[postlist]" value="<?php echo $postlist; ?>"/>

                    </td>
                </tr>
                <tr valign="top" class="alternate">
                    <td><?php _e('Horizontal Position', $this->plugin_name) ?></td>
                    <td>
                        <input type="number" name="cbxfeedbackbtnmetabox[horizontal]" value="<?php echo $horizontal; ?>"
                               size="6"/><br/>

                        <p class="description"><?php _e('Horizaontal position as percentage, don\'t put %, just put something like 50 0r 60, 0 is taken as left, 100 is taken as right, rest position is calculated as percentage.', $this->plugin_name); ?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <td><?php _e('Vertical Position', $this->plugin_name) ?></td>
                    <td>
                        <input type="number" name="cbxfeedbackbtnmetabox[vertical]" value="<?php echo $vertical; ?>"
                               size="6"/><br/>

                        <p class="description"><?php _e('Vertical position as percentage, don\'t put %, just put something like 50 0r 60, 0 is taken as top left/right, 100 is taken as bottom left/right, rest position is calculated as percentage.', $this->plugin_name); ?></p>
                    </td>
                </tr>
                <tr valign="top" class="alternate">
                    <td><?php _e('Background Color', $this->plugin_name); ?></td>
                    <td>
                        <input class="cbxcolor" data-default-color="#0066CC" type="text"
                               name="cbxfeedbackbtnmetabox[bcolor]" value="<?php echo $bcolor; ?>" size="7"/><br/>

                        <p class="description"><?php _e('Background color of feedback button', $this->plugin_name); ?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <td><?php _e('Background Color for mouse hover', $this->plugin_name); ?></td>
                    <td>
                        <input class="cbxcolor" data-default-color="#FF8B00" type="text"
                               name="cbxfeedbackbtnmetabox[hcolor]" value="<?php echo $hcolor; ?>" size="7"/><br/>

                        <p class="description"><?php _e('Background color of feedback button when mouse hover', $this->plugin_name); ?></p>
                    </td>
                </tr>
                <tr valign="top" class="alternate">
                    <td><?php _e('Button Text', $this->plugin_name) ?></td>
                    <td>
                        <select id="cbxfeedbackbuttontext" name="cbxfeedbackbtnmetabox[btext]"
                                class="cbxfeedbackbuttontext select_buttontext select_buttontext">
                            <option
                                value="contact_small.png" <?php echo($btext == 'contact_small.png' ? 'selected="selected"' : ''); ?> ><?php _e('Contact', $this->plugin_name); ?></option>
                            <option
                                value="be_social_small.png" <?php echo($btext == 'be_social_small.png' ? 'selected="selected"' : ''); ?> ><?php _e('be social. share!', $this->plugin_name); ?></option>
                            <option
                                value="callback_caps.png" <?php echo($btext == 'callback_caps.png' ? 'selected="selected"' : ''); ?> ><?php _e('CALL BACK', $this->plugin_name); ?></option>
                            <option
                                value="callback_small.png" <?php echo($btext == 'callback_small.png' ? 'selected="selected"' : ''); ?> ><?php _e('call back', $this->plugin_name); ?></option>
                            <option
                                value="care_share.png" <?php echo($btext == 'care_share.png' ? 'selected="selected"' : ''); ?> ><?php _e('care for share?', $this->plugin_name); ?></option>
                            <option
                                value="COMENTARIOS-FEEDBACK.png" <?php echo($btext == 'COMENTARIOS-FEEDBACK.png' ? 'selected="selected"' : ''); ?> ><?php _e('COMENTARIOS-FEEDBACK', $this->plugin_name); ?></option>
                            <option
                                value="COMENTARIOS.png" <?php echo($btext == 'COMENTARIOS.png' ? 'selected="selected"' : ''); ?> ><?php _e('COMENTARIOS', $this->plugin_name); ?></option>
                            <option
                                value="contact_caps.png" <?php echo($btext == 'contact_caps.png' ? 'selected="selected"' : ''); ?> ><?php _e('CONTACT', $this->plugin_name); ?></option>
                            <option
                                value="contact_us_caps.png" <?php echo($btext == 'contact_us_caps.png' ? 'selected="selected"' : ''); ?> ><?php _e('CONTACT US', $this->plugin_name); ?></option>
                            <option
                                value="contact_us_mix.png" <?php echo($btext == 'contact_us_mix.png' ? 'selected="selected"' : ''); ?> ><?php _e('Contact Us', $this->plugin_name); ?></option>
                            <option
                                value="feedback_caps.png" <?php echo($btext == 'feedback_caps.png' ? 'selected="selected"' : ''); ?> ><?php _e('FEEDBACK', $this->plugin_name); ?></option>
                            <option
                                value="feedback_mix.png" <?php echo($btext == 'feedback_mix.png' ? 'selected="selected"' : ''); ?> ><?php _e('Feedback', $this->plugin_name); ?></option>
                            <option
                                value="feedback_small.png" <?php echo($btext == 'feedback_small.png' ? 'selected="selected"' : ''); ?> ><?php _e('feedback', $this->plugin_name); ?></option>
                            <option
                                value="requestacallback_caps.png" <?php echo($btext == 'requestacallback_caps.png' ? 'selected="selected"' : ''); ?> ><?php _e('REQUEST A CALL BACK', $this->plugin_name); ?></option>
                            <option
                                value="requestacallback_small.png" <?php echo($btext == 'requestacallback_small.png' ? 'selected="selected"' : ''); ?> ><?php _e('Request a call back', $this->plugin_name); ?></option>
                            <option
                                value="custom_img" <?php echo($btext == 'custom_img' ? 'selected="selected"' : ''); ?> ><?php _e('Custom Image...', $this->plugin_name); ?></option>
                            <option
                                value="custom_text" <?php echo($btext == 'custom_text' ? 'selected="selected"' : ''); ?> ><?php _e('Custom Text...', $this->plugin_name); ?></option>
                        </select>

                        <div
                            class="for_custom_image for_custom_image" <?php echo ($btext != 'custom_img') ? ' style="display:none;"' : ''; ?> >
                            <?php _e('Image URL:', $this->plugin_name); ?> <input
                                placeholder="<?php echo _e('Click to upload'); ?>" class="cbxfeedbackimage" type="text"
                                name="cbxfeedbackbtnmetabox[btext_img]" value="<?php echo $btext_cust_img; ?>"
                                size="25"/><br/>
                            <?php _e('Image height:', $this->plugin_name); ?> <input type="text"
                                                                                     name="cbxfeedbackbtnmetabox[btext_height]"
                                                                                     value="<?php echo $btext_cust_height; ?>"
                                                                                     size="6"/>px<br/>

                            <p class="description"><?php _e('Select your button text. For customized text image put your image url and image height.', $this->plugin_name); ?></p>
                        </div>
                        <div
                            class="for_custom_text for_custom_text" <?php echo ($btext != 'custom_text') ? ' style="display:none;"' : ''; ?>>
                            <?php _e('Custom text:', $this->plugin_name); ?><input type="text"
                                                                                   name="cbxfeedbackbtnmetabox[btext_text]"
                                                                                   value="<?php echo $btext_cust_text; ?>"
                                                                                   size="25"/>
                        </div>
                    </td>
                </tr>
                <tr valign="top">
                    <td><?php _e('Link Button to Post/Page (ID)', $this->plugin_name) ?></td>
                    <td>
                        <input type="text" name="cbxfeedbackbtnmetabox[postid]" value="<?php echo $postid; ?>"/><br/>
                        <?php if ($postid != '') echo sprintf('Linked: <a target="_blank" href="%s">%s</a>', get_permalink($postid), get_the_title($postid)); ?>
                        <p class="description"><?php _e('Put post or page id that you want to link as feedback or contact page, normally you should put page id', $this->plugin_name); ?></p>
                    </td>
                </tr>
                <tr valign="top" class="alternate">
                    <td><?php _e('Custom Link', $this->plugin_name) ?></td>
                    <td>
                        <input type="text" name="cbxfeedbackbtnmetabox[custom_link]"
                               value="<?php echo $custom_link; ?>"/><br/>

                        <p class="description"><?php _e('To use custom link leave the post/page id blank', $this->plugin_name); ?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <td><?php _e('Custom Title', $this->plugin_name) ?></td>
                    <td>
                        <input type="text" name="cbxfeedbackbtnmetabox[link_title]" value="<?php echo $link_title; ?>"/><br/>

                        <p class="description"><?php _e('Title for the anchor tag', $this->plugin_name); ?></p>
                    </td>
                </tr>
                <tr valign="top" class="alternate">
                    <td><?php _e('Link Target', $this->plugin_name); ?></td>
                    <td>
                        <?php
                            //var_dump($link_target);
                        ?>
                        <input id="clinkopen-_blank"
                               type="radio" <?php echo($link_target == '_blank' ? 'checked="checked"' : ''); ?>
                               value="_blank" name="cbxfeedbackbtnmetabox[link_target]"/>
                        <label for="clinkopen-_blank"><?php _e('Open in new tab', $this->plugin_name); ?></label>
                        <input id="clinkopen-_self"
                               type="radio" <?php echo($link_target == '_self' ? 'checked="checked"' : ''); ?>
                               value="_self" name="cbxfeedbackbtnmetabox[link_target]"/>
                        <label for="clinkopen-_self"><?php _e('Open in same tab', $this->plugin_name); ?></label>

                        <p class="description"><?php _e('Control openning link in same window or new tab.', $this->plugin_name); ?></p>

                    </td>
                </tr>

                <?php

                    do_action('wpfvfbtn_button_setting_before_end', $fieldValues);
                ?>
                </tbody>
            </table>

            <?php

            echo '</div>';


        }//end display metabox


        /**
         * Determines whether or not the current user has the ability to save meta data associated with this post.
         *
         * @param        int $post_id            The ID of the post being save
         * @param            bool                Whether or not the user has the ability to save this post.
         */
        public function save_post_feedbackbtn($post_id, $post) {

            $post_type = 'cbxfeedbackbtn';

            // If this isn't a 'book' post, don't update it.
            if ($post_type != $post->post_type) {
                return;
            }


            if (!empty($_POST['cbxfeedbackbtnmetabox'])) {

                $postData = $_POST['cbxfeedbackbtnmetabox'];


                $saveableData = array();


                //if(!empty($postData['bdnewsphotobox'])) {
                if ($this->user_can_save($post_id, 'cbxfeedbackbtnmetabox', $postData['nonce'])) {

                    $saveableData['showtype'] = intval($postData['showtype']);
                    //$saveableData['visible'] 	                = intval($postData['visible']);
                    $saveableData['postlist'] = sanitize_text_field($postData['postlist']);


                    $saveableData['vertical']   = intval($postData['vertical']);
                    $saveableData['horizontal'] = intval($postData['horizontal']);


                    $saveableData['bcolor'] = WpfixedverticalfeedbackbuttonHelper::sanitize_hex_color($postData['bcolor']);
                    $saveableData['hcolor'] = WpfixedverticalfeedbackbuttonHelper::sanitize_hex_color($postData['hcolor']);


                    $saveableData['btext']        = sanitize_text_field($postData['btext']);
                    $saveableData['btext_img']    = sanitize_text_field($postData['btext_img']);
                    $saveableData['btext_height'] = sanitize_text_field($postData['btext_height']);
                    $saveableData['btext_text']   = sanitize_text_field($postData['btext_text']);

                    //$saveableData['linktarget'] 	            = sanitize_text_field($postData['linktarget']);

                    $postid                 = intval($postData['postid']);
                    $saveableData['postid'] = ($postid == 0) ? '' : $postid;

                    $saveableData['custom_link'] = sanitize_text_field($postData['custom_link']);
                    $saveableData['link_title']  = sanitize_text_field($postData['link_title']);
                    $saveableData['link_target'] = sanitize_text_field($postData['link_target']);

                    $saveableData = apply_filters('save_post_feedbackbtn', $saveableData, $postData);

                    update_post_meta($post_id, '_cbxfeedbackbtnmeta', $saveableData);

                    //exit();
                }
            }
        }

        /**
         * Determines whether or not the current user has the ability to save meta data associated with this post.
         *
         * @param        int $post_id            The ID of the post being save
         * @param            bool                Whether or not the user has the ability to save this post.
         */
        function user_can_save($post_id, $action, $nonce) {

            $is_autosave    = wp_is_post_autosave($post_id);
            $is_revision    = wp_is_post_revision($post_id);
            $is_valid_nonce = (isset($nonce) && wp_verify_nonce($nonce, $action));

            // Return true if the user is able to save; otherwise, false.
            return !($is_autosave || $is_revision) && $is_valid_nonce;

        }

        /**
         * Add Setting links in plugin listing
         *
         * @param $links
         *
         * @return mixed
         */
        public function add_wpfixedverticalfeedbackbutton_settings_link($links) {

            $support_link = '<a target="_blank" href="http://codeboxr.com/product/fixed-vertical-feedback-button-for-wordpress">' . __('Support', 'wpfixedverticalfeedbackbutton') . '</a>';
            array_unshift($links, $support_link);

            return $links;
        }

        public function remove_menus() {

            $button_count = wp_count_posts('cbxfeedbackbtn');


            //remove add button option if already one button is created
            if ($button_count->publish > 0) {
                do_action('cbxfeedbackbtn_remove', $this);

            }


        }

        public function cbxfeedbackbtn_remove_core() {
            remove_submenu_page('edit.php?post_type=cbxfeedbackbtn', 'post-new.php?post_type=cbxfeedbackbtn');        //remove add feedback menu

            $result     = stripos($_SERVER['REQUEST_URI'], 'post-new.php');
            $post_type  = isset($_REQUEST['post_type'])? esc_attr($_REQUEST['post_type']): '';

            if ($result !== false ) {
                if($post_type == 'cbxfeedbackbtn'){
                    wp_redirect(get_option('siteurl') . '/wp-admin/edit.php?post_type=cbxfeedbackbtn&cbxfeedbackbtn_error=true');
                }

            }
        }

        /**
         * Showing Admin notice
         *
         */
        function permissions_admin_notice() {
            echo "<div id='permissions-warning' class='error fade'><p><strong>" . sprintf(__('Sorry, you can not create more than one button in free verion, <a target="_blank" href="%s">Grab Pro</a>', 'wpfixedverticalfeedbackbutton'), 'http://codeboxr.com/product/fixed-vertical-feedback-button-for-wordpress' ) . "</strong></p></div>";
        }

        /**
         * Admin notice if user try to create new button in free version
         */
        function cbxfeedbackbtn_notice() {
            if (isset($_GET['cbxfeedbackbtn_error'])) {
                add_action('admin_notices', array($this, 'permissions_admin_notice'));
            }
        }

        /**
         * Add support link to plugin description in /wp-admin/plugins.php
         *
         * @param  array  $plugin_meta
         * @param  string $plugin_file
         *
         * @return array
         */
        public function support_link($plugin_meta, $plugin_file) {

            if ($this->plugin_basename == $plugin_file) {
                $plugin_meta[] = sprintf(
                    '<a target="_blank" href="%s">%s</a>', 'http://codeboxr.com/product/fixed-vertical-feedback-button-for-wordpress', __('Get Pro', 'wpfixedverticalfeedbackbutton')
                );
            }

            return $plugin_meta;
        }


    }
