<?php

/**
 * Fired during plugin activation
 *
 * @link       http://codeboxr.com
 * @since      1.0.0
 *
 * @package    Wpfixedverticalfeedbackbutton
 * @subpackage Wpfixedverticalfeedbackbutton/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wpfixedverticalfeedbackbutton
 * @subpackage Wpfixedverticalfeedbackbutton/includes
 * @author     Codeboxr <info@codeboxr.com>
 */
class Wpfixedverticalfeedbackbutton_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		//check if there is any thing in option named "wpfixedverticalfeedbackbutton"

		$option = get_option('wpfixedverticalfeedbackbutton');
		if($option !==  false){

			//check if old way then migrate and delete the option so that we can use it for other purpose later
			if(isset($option['buttonno']) && isset($option['buttoncon'])){

				$button_count   = intval($option['buttonno']);
				$button_con     = $option['buttoncon'];

				for($i = 0; $i < $button_count; $i++){

					$name       = $button_con['name'][$i];
					if($name == '') $name = sprintf(__('Feedback Button Backup - %d','wpfixedverticalfeedbackbutton'), $i);
					$show       = intval($button_con['show'][$i]);
					$post_status = ($show)? 'publish':'private';


					$post_arr = array(
						'post_title'    => $name,
						'post_status'   => $post_status,
						'post_type'     => 'cbxfeedbackbtn'
					);

					$post_id  = wp_insert_post($post_arr);
					$postData = $button_con; //reassign to skipt typing too much :P

					$saveableData['showtype'] 	                = intval($postData['showtype'][$i]); //
					//$saveableData['visible'] 	                = intval($postData['visible']);
					$saveableData['postlist'] 	                = sanitize_text_field($postData['postlist'][$i]); //


					$saveableData['vertical'] 	                = intval($postData['top'][$i]); //
					$saveableData['horizontal'] 	            = intval($postData['right'][$i]); //



					$saveableData['bcolor'] 	                = WpfixedverticalfeedbackbuttonHelper::sanitize_hex_color($postData['backcolor'][$i]); //
					$saveableData['hcolor'] 	                = WpfixedverticalfeedbackbuttonHelper::sanitize_hex_color($postData['hbackcolor'][$i]); //


					$saveableData['btext'] 	                    = sanitize_text_field($postData['buttontext'][$i]); //
					$saveableData['btext_img'] 	                = sanitize_text_field($postData['bilink'][$i]); //
					$saveableData['btext_height'] 	            = sanitize_text_field($postData['biheight'][$i]); //
					$saveableData['btext_text'] 	            = sanitize_text_field($postData['bctext'][$i]); //

					//$saveableData['linktarget'] 	            = sanitize_text_field($postData['linktarget']);

					$postid                                     = intval($postData['id'][$i]); //
					$saveableData['postid'] 	                = ($postid == 0) ? '': $postid;

					$saveableData['custom_link'] 	            = sanitize_text_field($postData['clink'][$i]); //
					$saveableData['link_title'] 	            = sanitize_text_field($postData['clinktitle'][$i]); //
					$saveableData['link_target'] 	            = sanitize_text_field($postData['clinkopen'][$i]); //

					if(isset($postData['form_open'][$i]) && isset($postData['choose_form'][$i]) && isset($postData['form_listing'][$i])){
						$saveableData['form_open'] 	                = intval(sanitize_text_field($postData['form_open'][$i]));
						$saveableData['choose_form'] 	            = sanitize_text_field($postData['choose_form'][$i]);
						$saveableData['form_listing'] 	            = sanitize_text_field($postData['form_listing'][$i]);
					}

					//$saveableData = apply_filters('save_post_feedbackbtn', $saveableData, $postData);
					update_post_meta($post_id, '_cbxfeedbackbtnmeta', $saveableData);

				}

				//now delete the option if migrating first time from old way to post type way
				delete_option('wpfixedverticalfeedbackbutton');
			}
			//end //check if old way then migrate and delete the option so that we can use it for other purpose later

		}
	}

}
