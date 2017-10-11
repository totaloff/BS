<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://codeboxr.com
 * @since      1.0.0
 *
 * @package    Wpfixedverticalfeedbackbutton
 * @subpackage Wpfixedverticalfeedbackbutton/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wpfixedverticalfeedbackbutton
 * @subpackage Wpfixedverticalfeedbackbutton/public
 * @author     Codeboxr <info@codeboxr.com>
 */
class Wpfixedverticalfeedbackbutton_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wpfixedverticalfeedbackbutton-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wpfixedverticalfeedbackbutton-public.js', array( 'jquery' ), $this->version, false );

	}


	public function builtin_buttons($key = ''){

		$buttondata                    = array(
				'be_social_small.png'        => 162,
				'callback_caps.png'          => 113,
				'callback_small.png'         => 91,
				'care_share.png'             => 144,
				'COMENTARIOS.png'            => 151,
				'COMENTARIOS-FEEDBACK.png'   => 264,
				'contact_caps.png'           => 102,
				'contact_small.png'          => 83,
				'contact_us_caps.png'        => 132,
				'contact_us_mix.png'         => 110,
				'feedback_caps.png'          => 115,
				'feedback_mix.png'           => 97,
				'feedback_small.png'         => 90,
				'feedback_tab_white.png'     => 90,
				'requestacallback_caps.png'  => 229,
				'requestacallback_small.png' => 192
		);

		if($key == '' || !isset($buttondata[$key]))  return '100%'; //random height

		return  $buttondata[$key];
	}

	/**
	 * Add html for each button and it's form
	 *
	 * @since    1.0.0
	 */
	public function add_button_html(){

		global $post;
		$gobal_post_id = $post->ID;

		$posts_per_page 	= 1;
		$posts_per_page 	= apply_filters('wpfvfbtn_button_count', $posts_per_page);



		$args = array(
				'post_type' 		=> 'cbxfeedbackbtn',
				'post_status'		=> 'publish',
				'posts_per_page' 	=> $posts_per_page,
				'order'				=> 'DESC',
				'orderby'			=> 'ID'

		);

		// The Query
		$the_query = new WP_Query( $args );


		// The Loop
		if ( $the_query->have_posts() ) {

			while ( $the_query->have_posts() ) {
				$the_query->the_post();

				$loop_post_id = $post->ID;



				$fieldValues = get_post_meta($loop_post_id, '_cbxfeedbackbtnmeta', true);



				$showtype             = isset($fieldValues['showtype']) ? intval($fieldValues['showtype']): 1; //show type
				$postlist             = isset($fieldValues['postlist'])  ? esc_attr($fieldValues['postlist']) : '';


				$vertical             = isset($fieldValues['vertical']) ? intval($fieldValues['vertical']): 50; //vertical alignment
				$horizontal           = isset($fieldValues['horizontal']) ? intval($fieldValues['horizontal']): 0; //horizontal alignment

				$bcolor               = isset($fieldValues['bcolor']) ? esc_attr($fieldValues['bcolor']): '#0066CC'; //button backend color
				$hcolor               = isset($fieldValues['hcolor']) ? esc_attr($fieldValues['hcolor']): '#FF8B00'; //button hover color

				$btext                = isset($fieldValues['btext']) ? esc_attr($fieldValues['btext']): 'contact_small.png'; //button text can be image or custom image or custom text
				$btext_cust_img       = isset($fieldValues['btext_img']) ? esc_attr($fieldValues['btext_img']): ''; //button custom image
				$btext_cust_height    = isset($fieldValues['btext_height']) ? esc_attr($fieldValues['btext_height']): ''; //button custom image height in px
				$btext_cust_text      = isset($fieldValues['btext_text']) ? esc_attr($fieldValues['btext_text']): ''; //custom text as button text




				//post id is used to get permalink for button if used
				$postid               = isset($fieldValues['postid']) ? intval($fieldValues['postid']): 0; //post id (post, page or any post type in wordpress)
				$custom_link          = isset($fieldValues['custom_link']) ? esc_attr($fieldValues['custom_link']): ''; //custom link for button
				$link_title           = isset($fieldValues['link_title']) ? esc_attr($fieldValues['link_title']): ''; //custom link title
				$link_target          = isset($fieldValues['link_target']) ? esc_attr($fieldValues['link_target']): '_blank'; //link target



				$bcolor               = WpfixedverticalfeedbackbuttonHelper::maybe_hash_hex_color($bcolor);
				$hcolor               = WpfixedverticalfeedbackbuttonHelper::maybe_hash_hex_color($hcolor);
				$postid               = ($postid == 0) ? '': $postid;  //just for showing purpose


				//let's render the button html

				$postlist 			= ($postlist != '') ? explode(',', $postlist): array();

				// var_dump($postlist);
				$title = $link_title;
				$open  = $link_target;
				$link  = ($postid == '') ? $custom_link : get_permalink($postid);

				$imageOrText = (
				($btext == 'custom_img') ?
						( ($btext_cust_img != 'custom_img') ?
								'<img src="' . $btext_cust_img . '" style="height:' . $btext_cust_height . '" alt="btnimage" />' : ''
						) : ( ($btext == 'custom_text') ? $btext_cust_text : '<img src="' . plugins_url('images/' . $btext, __FILE__) . '" alt="' . $btext . '" />' )
				);

				if (preg_match('/(^<img) (.*)(\\\?>$)/i', $imageOrText)) {
					echo $style = '<style type="text/css">
                        div#fvfeedbackbutton' . $loop_post_id . ' {
                            transform: none;
                            -webkit-transform: none;
                            -moz-transform: none;
                            -moz-transform-origin: none;
                            -o-transform: none;
                            -o-transform-origin: none;
                            -ms-transform: none;
                            -ms-transform-origin: none;
                            filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=0);

                        }
                        </style>
                    ';
				}




				if ( $showtype == 1 && in_array($gobal_post_id, $postlist) || $showtype == 0 && !in_array($gobal_post_id, $postlist) ||	empty($postlist) ) {


					//$class = $modalAttr = $formOutput = '';
					$class  = $formOutput = '';
					$anchorClass 		= 'wpfvfbtn_displayFormAnchor wpfvfbtn_displayFormAnchor_'.$loop_post_id.' ';
					$cbwpfvb_show_form 	= 0;

					$class 				= apply_filters('wpfvfbtn_button_html_class', $class, $loop_post_id, $fieldValues);



					$open 				= apply_filters('wpfvfbtn_button_html_open', $open, $loop_post_id, $fieldValues);
					$anchorClass 		= apply_filters('wpfvfbtn_button_html_anchorclass', $anchorClass, $loop_post_id, $fieldValues);
					$cbwpfvb_show_form 	= apply_filters('wpfvfbtn_button_html_show_form', $cbwpfvb_show_form, $loop_post_id, $fieldValues);
					$link 				= apply_filters('wpfvfbtn_button_html_link', $link, $loop_post_id, $fieldValues);





					$rightorleft       = intval($horizontal);

					if ($rightorleft > 100) {
						$rightorleft = 50; //always in percentage
					}

					$right_style = ($rightorleft == 100) ? 'right:0%; ': 'left:'.$rightorleft.'%; ';


					$backcolor = $bcolor;
					if ($backcolor == '') {
						$backcolor = '#0066CC';
					}

					if(strpos($backcolor, '#' ) === FALSE){
						$backcolor = '#'.$backcolor;
					}

					$hbackcolor = $hcolor;
					if ($hbackcolor == '') {
						$hbackcolor = '#FF8B00';
					}

					if(strpos($hbackcolor, '#') === FALSE){
						$hbackcolor = '#'.$hbackcolor;
					}

					$top       = intval($vertical);

					if ($top > 100) {
						$top = 50; //always in percentage
					}

					$top_style = ($top == 100) ? 'bottom:0%; ': 'top:'.$top.'%; ';

					$buttontext = $btext;




					$height_style = '';
					//custom image
					if($btext == 'custom_img') {
						$imageurl = $btext_cust_img;
						$height   = $btext_cust_height;
						$height = intval($height);
						if($height == 0){
							$height_style = ' height:100%; ';
						}
						else{
							$height += 10;
							$height_style = ' height:'.$height.'px; ';
						}

					} else {
						$imageurl = WP_PLUGIN_URL . '/wpfixedverticalfeedbackbutton/public/images/' . $buttontext;

						$height   = $this->builtin_buttons($buttontext);
						if($height == '100%'){
							$height_style = ' height:100%; ';
						}
						else{

							$height += 10;
							$height_style = ' height:'.$height.'px; ';
						}
					}





					$bctext = $btext_cust_text;





					if ($btext != 'custom_text') {
						echo '<style type="text/css" media="screen">
								div#fvfeedbackbutton' . $loop_post_id . ' {
									'.$height_style.'
									position:fixed;
									text-indent:-9999px;
									'.$top_style.'
									'.$right_style.'
									width:30px;
									line-height:0;
								}

								div#fvfeedbackbutton' . $loop_post_id . ' span{
									background:url("' . $imageurl . '") no-repeat scroll 50% 50% ' . $backcolor . ';
									display:block;
									'.$height_style.'
									padding:5px;
									position:fixed;
									text-indent:-9999px;
									'.$top_style.'
									'.$right_style.'
									width:30px;
									line-height:0;

								}

								div#fvfeedbackbutton' . $loop_post_id . ' span:hover {
									background-color:' . $hbackcolor . ';

								}
                           </style>';

					}
					else {


						echo '<style type="text/css" media="screen">
                            div#fvfeedbackbutton' . $loop_post_id . '{
                                position:fixed;
                              
                                '.$top_style.'
								'.$right_style.'}';



						echo '
                            div#fvfeedbackbutton' . $loop_post_id . ' a{
                                text-decoration: none;
                            }

                            div#fvfeedbackbutton' . $loop_post_id . ' span {
                                background-color:' . $backcolor . ';
                                display:block;
                             
                                
                                padding:8px;
                                font-weight: bold;
                                color:#fff;
                                font-size: 18px !important;
                                font-family: Arial, sans-serif !important;
								'.$height_style;
								
								//if in first half
								if ($rightorleft < 50) echo '
								       float:left;
								        margin-left:42px;
										transform: rotate(90deg);
										transform-origin: left top 0;
										-webkit-transform: rotate(90deg);
										-webkit-transform-origin: left top;
										-moz-transform: rotate(90deg);
										-moz-transform-origin: left top;
										-o-transform: rotate(90deg);
										-o-transform-origin: left top;
										-ms-transform: rotate(90deg);
										-ms-transform-origin: left top;
										filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=4);
								}';
		
									//if in right half
								else echo '
								float:right;
										margin-right:42px;
										transform-origin: right top 0;
										transform: rotate(270deg);
										-webkit-transform: rotate(270deg);
										-webkit-transform-origin: right top;
										-moz-transform: rotate(270deg);
										-moz-transform-origin: right top;
										-o-transform: rotate(270deg);
										-o-transform-origin: right top;
										-ms-transform: rotate(270deg);
										-ms-transform-origin: right top;
										filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=4);
								} ';

                            echo 'div#fvfeedbackbutton' . $loop_post_id . ' span:hover {
                                	background-color:' . $hbackcolor . ';
                            	  }
                            </style>';
					}

					echo '<style type="text/css" media="screen">
								div.fvfeedbackbutton {
									z-index: 99999 !important;
								}
								div#fvfeedbackbutton' . $loop_post_id . ' a, div#fvfeedbackbutton' . $loop_post_id . ' a:hover, div#fvfeedbackbutton' . $loop_post_id . ' a:focus, div#fvfeedbackbutton' . $loop_post_id . ' a:active{
									outline:0px solid !important;
								}
						  </style>';

					//style end

					//extra style hook
					$extra_style = '';
					$extra_style =  apply_filters('wpfvfbtn_button_extra_style', $extra_style, $loop_post_id, $fieldValues);

					if($extra_style != '') echo '<style type="text/css" media="screen">'.$extra_style.'</style>';


					$anchor_output = '<div class="fvfeedbackbutton '.$class.' " id="fvfeedbackbutton' . $loop_post_id . '"><a class="'.$anchorClass.'"  href="' . $link . '" data-count = "'.$loop_post_id.'" data-show-form = "'.$cbwpfvb_show_form.'" title="' . $title . '" target="' . $open . '"><span>' . $imageOrText . '</span></a></div>';

					$formOutput 		= apply_filters('wpfvfbtn_button_html_formoutput', $formOutput, $loop_post_id, $fieldValues);

					$anchor_output 		= apply_filters('wpfvfbtn_button_anchor_output', $anchor_output, $loop_post_id, $fieldValues);



					echo $anchor_output; //anchor output
					echo $formOutput; //extra form or visual content output


				}

			}

		}


		/* Restore original Post Data */
		wp_reset_postdata();
	}

}
