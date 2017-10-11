<?php
// If this file is called directly, abort.
defined( 'ABSPATH' ) or die();

/**
 * The horizontal sharing class.
 */
if ( ! class_exists( 'OSS_Common_Sharing' ) ) {

    class OSS_Common_Sharing {

        /**
         * 
         * @global type $oss_js_in_footer
         */
        public static function vertical_sharing() {
           
            global $oss_js_in_footer;
            // Enqueue main scripts in footer
            if ($oss_js_in_footer) {
                add_action('wp_footer', array(get_class(), 'get_vertical_sharing_script'), 100);
            } else {
                add_action('wp_head', array(get_class(), 'get_vertical_sharing_script'), 100);
            }
           //wp_register_script( 'oss-social-sharing', '//sharecdn.social9.com/v1/social9.min.js', array(), OSS_PLUGIN_VERSION, $oss_js_in_footer);
           //wp_register_script( 'oss-social-sharing',  'http://localhost/wordpress/wp-content/plugins/simplified-social-share/oss-social-sharing/assets/js/OpenSocialShare.js', array(), $oss_js_in_footer);
            
        }
        
       

        /**
         * 
         * @global type $oss_js_in_footer
         */
        public static function horizontal_sharing() {
            global $oss_js_in_footer;
            // Enqueue main scripts in footer
            if ($oss_js_in_footer) {
                add_action('wp_footer', array(get_class(), 'get_horizontal_sharing_script'), 100);
            } else {
                add_action('wp_head', array(get_class(), 'get_horizontal_sharing_script'), 100);
            }
           // wp_register_script( 'oss-social-sharing', '//sharecdn.social9.com/v1/social9.min.js', array(), OSS_PLUGIN_VERSION, $oss_js_in_footer);
            //wp_register_script( 'oss-social-sharing',  'http://localhost/wordpress/wp-content/plugins/simplified-social-share/oss-social-sharing/assets/js/OpenSocialShare.js', array(), $oss_js_in_footer);
         
        }

        /**
         * Get OpenSocialShare Horizontal Simple Social Sharing JavaScript loaded in <head>.
         * 
         * @global type $oss_share_settings
         * @global type $oss_api_settings
         */
        public static function get_horizontal_sharing_script() {
           
            global $oss_share_settings, $oss_api_settings;

            $theme = $oss_share_settings['horizontal_share_interface'];

            switch ($theme) {
                case '32-h':
                    $size = '32';
                    $interface = 'square';
                    $countertype = "0";
                    $widgetTheme ='0';
                    break;
                case '16-h':
                    $size = '16';
                    $interface = 'square';
                    $countertype = "0";
                    $widgetTheme ='0';
                    break;
                case 'responsive':
                    $size = '32';
                    $interface = 'responsive';
                    $countertype = "0";
                    $widgetTheme ='0';
                    break;
                case 'single-lg-h':
                    $size = '32';
                    $interface = 'image';
                    $countertype = "0";
                    $widgetTheme ='0';
                    break;
                case 'single-sm-h':
                    $size = '16';
                    $interface = 'image';
                    $countertype = "0";
                    $widgetTheme ='0';
                    break;
                case 'hybrid-h-h':
                    $size = '32';
                    $countertype = "1";
                    $widgetTheme ='1';
                    break;
                case 'hybrid-h-v':
                    $size = '32';
                    $countertype = "0";
                    $widgetTheme ='1';
                    
                    break;
                default:
                    $size = '32';
                    $interface = 'square';
                    break;
            }
           
            $horizontalShare ='';
           
           
            if (isset($oss_share_settings['emailMessage']) && $oss_share_settings['emailMessage'] !='') {
            $horizontalShare  .='emailMessage:"'. $oss_share_settings['emailMessage'].'",';
            }
            if (isset($oss_share_settings['emailSubject']) && $oss_share_settings['emailSubject'] !='') {
            $horizontalShare  .='emailSubject:"'. $oss_share_settings['emailSubject'].'",';
            }
            if ($oss_share_settings['emailcontent'] !='') {
            $horizontalShare  .='isEmailContentReadOnly:'. $oss_share_settings['emailcontent'].',';
            }
            if ($oss_share_settings['isTotalShare'] !='') {
            $horizontalShare  .='isTotalShare:'. $oss_share_settings['isTotalShare'].',';
            }
            if ($oss_share_settings['mobile_enable'] !='') {
            $horizontalShare  .='isMobileFriendly:'. $oss_share_settings['mobile_enable'].',';
            }
           
            if (isset($oss_share_settings['facebookAppId']) && $oss_share_settings['facebookAppId'] !='') {
            $horizontalShare  .='facebookAppId:"'. $oss_share_settings['facebookAppId'].'",';
            }
            if ($oss_share_settings['shortenUrl'] !='') {
            $horizontalShare  .='isShortenUrl:'. $oss_share_settings['shortenUrl'].',';
            }
            if ($oss_share_settings['isOpenSingleWindow'] !='') {
            $horizontalShare  .='isOpenSingleWindow:'. $oss_share_settings['isOpenSingleWindow'].',';
            }
           
            if (!empty($oss_share_settings['popupHeightWidth']) && !empty($oss_share_settings['popupWindowHeight']) && !empty($oss_share_settings['popupWindowWidth'])) {
                $popUpWindow ='{height:'.$oss_share_settings['popupWindowHeight'].',width :'.$oss_share_settings['popupWindowWidth'].'}';
                $horizontalShare  .='popupWindowSize:'. $popUpWindow.',';
            }
            if (isset($oss_share_settings['twittermention']) && $oss_share_settings['twittermention'] !='') {
            $horizontalShare  .='twittermention:"'. $oss_share_settings['twittermention'].'",';
            }
            if (isset($oss_share_settings['twitterhashtags']) && $oss_share_settings['twitterhashtags'] !='') {
            $horizontalShare  .='twitterhashtag:"'. $oss_share_settings['twitterhashtags'].'",';
            }
            if (isset($oss_share_settings['customOptions']) && $oss_share_settings['customOptions'] !='') {
            $horizontalShare  .=$oss_share_settings['customOptions'].',';
            }
            

               $scriptHorizontal= '{name:';
            if($oss_share_settings['horizontal_share_interface'] =='hybrid-h-h' && isset($oss_share_settings['horizontal_sharing_providers']['Hybrid']['Facebook Like']) && $oss_share_settings['horizontal_sharing_providers']['Hybrid']['Facebook Like']=='Facebook Like' && $oss_share_settings['facebookPage']!=''|| $oss_share_settings['horizontal_share_interface'] =='hybrid-h-v' && $oss_share_settings['horizontal_sharing_providers']['Hybrid']['Facebook Like']=='Facebook Like' && $oss_share_settings['facebookPage']!=''){
                foreach ($oss_share_settings['horizontal_sharing_providers']['Hybrid'] as $key => $value){
                    if($key == 'Facebook Like'){
                   $scriptHorizontal.=  '"'.$value.'"'.',';
                   $scriptHorizontal.=  'url:'.'"'.$oss_share_settings['facebookPage'].'"';
                   $scriptHorizontal.= '},'; 
                    }else{
                        $scriptHorizontal .= '"'.$value.'"'.',';
                        
                    }
                   
                }
                 
                $scriptHorizontal = substr($scriptHorizontal,0,-1);
                 
            }

                ?>

               <script type="text/javascript">
        var shareWidget = new OpenSocialShare();
        shareWidget.init({
             <?php echo $horizontalShare?>
                 
            isCounterWidgetTheme: <?php echo $widgetTheme?>, // 0 or 1 - standard themes or counter widget themes
            isHorizontalCounter: <?php echo $countertype?>, // 0 or 1 - counter on top or counter to right - counter themes only
            isHorizontalLayout: 1, // 0 or 1 - vertical layout or horizontal layout
            widgetIconSize: "<?php echo $size?>", // "16" or "32" - 16px or 32px standard themes only
           <?php if($widgetTheme == '0'){ ?>
            widgetStyle: "<?php echo $interface?>", //"image", "square" or "responsive" - standard themes only
            
           
            providers: {
                
                   top: ["<?php if(isset($oss_share_settings['horizontal_rearrange_providers'])){echo implode('","', $oss_share_settings['horizontal_rearrange_providers']);} ?>"]
                },
           widgets: {
                 //all : _private.getAllButtonName(_private.widgetConfig),
         <?php if($oss_share_settings['horizontal_share_interface'] =='hybrid-h-h' && isset($oss_share_settings['horizontal_sharing_providers']['Hybrid']['Facebook Like']) && $oss_share_settings['horizontal_sharing_providers']['Hybrid']['Facebook Like']=='Facebook Like' && $oss_share_settings['facebookPage']!=''|| $oss_share_settings['horizontal_share_interface'] =='hybrid-h-v' && $oss_share_settings['horizontal_sharing_providers']['Hybrid']['Facebook Like']=='Facebook Like' && $oss_share_settings['facebookPage']!=''){
             ?>
                 top: [<?php echo $scriptHorizontal?>]
         <?php }else{?>
             top: ["<?php echo implode('","', $oss_share_settings['horizontal_sharing_providers']['Hybrid']); ?>"]
         <?php  } ?>
             },
               <?php  }else{?>
                    
                        widgets: {
                 //all : _private.getAllButtonName(_private.widgetConfig),
         <?php if($oss_share_settings['horizontal_share_interface'] =='hybrid-h-h' && isset($oss_share_settings['horizontal_sharing_providers']['Hybrid']['Facebook Like'])&& $oss_share_settings['horizontal_sharing_providers']['Hybrid']['Facebook Like']=='Facebook Like' && $oss_share_settings['facebookPage']!=''|| $oss_share_settings['horizontal_share_interface'] =='hybrid-h-v' && isset($oss_share_settings['horizontal_sharing_providers']['Hybrid']['Facebook Like']) && $oss_share_settings['horizontal_sharing_providers']['Hybrid']['Facebook Like']=='Facebook Like' && $oss_share_settings['facebookPage']!=''){
             ?>
                 top: [<?php echo $scriptHorizontal?>]
         <?php }else{?>
             top: ["<?php echo implode('","', $oss_share_settings['horizontal_sharing_providers']['Hybrid']); ?>"]
         <?php  } ?>
             },
             <?php  }?>
           theme: 'OpenSocialShareDefaultTheme',
             
        });
        shareWidget.injectInterface(".oss_horizontal_share");
        shareWidget.setWidgetTheme(".oss_horizontal_share");
    </script>
            <?php 
        }
        
        
        /**
         * Get OpenSocialShare Vertical Simple Social Sharing div and script.
         * 
         * @global type $post
         * @global type $oss_share_settings
         * @global type $oss_api_settings
         * @return type
         */
        public static function get_vertical_sharing_script() {
         
            global $post, $oss_share_settings, $oss_api_settings;

            if ( is_object( $post ) ) {
                $ossMeta = get_post_meta($post->ID, '_oss_meta', true);

                // If sharing disabled on this page/post, return content unaltered.
                if ( isset( $ossMeta['sharing'] ) && $ossMeta['sharing'] == '1' && ! is_front_page() ) {
                    return;
                }
            }

            $is_mobile = self::mobile_detect();
            if ($is_mobile && isset($oss_share_settings['mobile_enable']) && $oss_share_settings['mobile_enable'] == '1') {
                return;
            }

            $position = OSS_Vertical_Sharing::get_vertical_position();

            if (isset(OSS_Vertical_Sharing::$position['class'])) {
                foreach (OSS_Vertical_Sharing::$position['class'] as $key => $value) {
                    $position[$value]['class'] = $value;
                   
                }
                 
            }
          
            if (isset($position)) {
               
                foreach ($position as $key => $value) {
                   if ($value) {
                    switch ($key) {
                        case 'top_left':                                
                                $params = array(
                                    'top' => '0px',
                                    'right' => '',
                                    'bottom' => '',
                                    'left' => '0px'
                                );
                                $class = OSS_Vertical_Sharing::$params['top_left']['class'];
                            break;
                        case 'top_right':
                                $params = array(
                                    'top' => '',
                                    'right' => '0px',
                                    'bottom' => '',
                                    'left' => ''
                                );
                                $class = OSS_Vertical_Sharing::$params['top_right']['class'];
                            break;
                        case 'middle_right':
                                $params = array(
                                    'top' => '',
                                    'right' => '0px',
                                    'bottom' => '',
                                    'left' => ''
                                );
                                $class = OSS_Vertical_Sharing::$params['middle_right']['class'];
                            break;
                        case 'middle_left':
                                $params = array(
                                    'top' => '',
                                    'right' => '0px',
                                    'bottom' => '',
                                    'left' => ''
                                );
                                $class = OSS_Vertical_Sharing::$params['middle_left']['class'];
                            break;
                        case 'bottom_left':
                                $params = array(
                                    'top' => '',
                                    'right' => '',
                                    'bottom' => '0px',
                                    'left' => '0px'
                                );
                                $class = OSS_Vertical_Sharing::$params['bottom_left']['class'];
                            break;
                        case 'bottom_right':
                                $params = array(
                                    'top' => '',
                                    'right' => '0px',
                                    'bottom' => '0px',
                                    'left' => ''
                                );
                                $class = OSS_Vertical_Sharing::$params['bottom_right']['class'];
                            break;
                        default:
                                $params = array(
                                    'top' => '',
                                    'right' => '',
                                    'bottom' => '',
                                    'left' => ''
                                );
                                $class = $position[$key]['class'];
                                break;
                    }
                

                    if (isset($params)) {
                        $top = $params['top'] ? $params['top'] : '';
                        $right = $params['right'];
                        $bottom = $params['bottom'];
                        $left = $params['left'];

                        $hybrid = false;
                        $theme = $oss_share_settings['vertical_share_interface'];

                        switch ($theme) {
                            case '32-v':
                                $size = '32';
                                 $widgetTheme ='0';
                                 $countertype ='0';
                                break;
                            case '16-v':
                                $size = '16';
                                 $widgetTheme ='0';
                                 $countertype ='0';
                                break;
                            case 'hybrid-v-h':
                                $hybrid = true;
                                $size = '32';
                                $countertype = "1";
                                 $widgetTheme ='1';
                                break;
                            case 'hybrid-v-v':
                                $hybrid = true;
                                $size = '32';
                                $countertype = "0";
                                 $widgetTheme ='1';
                                break;
                            default:
                                $size = '32';
                                $top = 'top';
                                $left = 'left';
                                break;
                        }
                        
                        
                        $verticalShare ='';
           
           
            if (isset($oss_share_settings['emailMessage']) && $oss_share_settings['emailMessage'] !='') {
            $verticalShare  .='emailMessage:"'. $oss_share_settings['emailMessage'].'",';
            }
            if (isset($oss_share_settings['emailSubject']) && $oss_share_settings['emailSubject'] !='') {
            $verticalShare  .='emailSubject:"'. $oss_share_settings['emailSubject'].'",';
            }
            if ($oss_share_settings['emailcontent'] !='') {
            $verticalShare  .='isEmailContentReadOnly:'. $oss_share_settings['emailcontent'].',';
            }
            if ($oss_share_settings['mobile_enable'] !='') {
            $verticalShare  .='isMobileFriendly:'. $oss_share_settings['mobile_enable'].',';
            }
            if ($oss_share_settings['isTotalShare'] !='') {
            $verticalShare  .='isTotalShare:'. $oss_share_settings['isTotalShare'].',';
            }
           
            if (isset($oss_share_settings['facebookAppId']) && $oss_share_settings['facebookAppId'] !='') {
            $verticalShare  .='facebookAppId:"'. $oss_share_settings['facebookAppId'].'",';
            }
            if ($oss_share_settings['shortenUrl'] !='') {
            $verticalShare  .='isShortenUrl:'. $oss_share_settings['shortenUrl'].',';
            }
            if ($oss_share_settings['isOpenSingleWindow'] !='') {
            $verticalShare  .='isOpenSingleWindow:'. $oss_share_settings['isOpenSingleWindow'].',';
            }
            
            if (!empty($oss_share_settings['popupHeightWidth']) && !empty($oss_share_settings['popupWindowHeight']) && !empty($oss_share_settings['popupWindowWidth'])) {
                $popUpWindow ='{height:'.$oss_share_settings['popupWindowHeight'].',width :'.$oss_share_settings['popupWindowWidth'].'}';
                $verticalShare  .='popupWindowSize:'. $popUpWindow.',';
            }
            if (isset($oss_share_settings['twittermention']) && $oss_share_settings['twittermention'] !='') {
            $verticalShare  .='twittermention:"'. $oss_share_settings['twittermention'].'",';
            }
            if (isset($oss_share_settings['twitterhashtags']) && $oss_share_settings['twitterhashtags'] !='') {
            $verticalShare  .='twitterhashtag:"'. $oss_share_settings['twitterhashtags'].'",';
            }
            if (isset($oss_share_settings['customOptions']) && $oss_share_settings['customOptions'] !='') {
            $verticalShare  .=$oss_share_settings['customOptions'].',';
            }

            $scriptVertical= '{name:';
            if($oss_share_settings['vertical_share_interface'] =='hybrid-v-v' && $oss_share_settings['vertical_sharing_providers']['Hybrid']['Facebook Like']=='Facebook Like' && $oss_share_settings['facebookPage']!=''|| $oss_share_settings['vertical_share_interface'] =='hybrid-v-h' && $oss_share_settings['vertical_sharing_providers']['Hybrid']['Facebook Like']=='Facebook Like' && $oss_share_settings['facebookPage']!=''){
                foreach ($oss_share_settings['vertical_sharing_providers']['Hybrid'] as $key => $value){
                    if($key == 'Facebook Like'){
                   $scriptVertical.=  '"'.$value.'"'.',';
                   $scriptVertical.=  'url:'.'"'.$oss_share_settings['facebookPage'].'"';
                   $scriptVertical.= '},'; 
                    }else{
                        $scriptVertical .= '"'.$value.'"'.',';
                        
                    }
                   
                }
                 
                $scriptVertical = substr($scriptVertical,0,-1);
                 
            }
      
                            ?>
                            <script type="text/javascript">
        var shareWidgetVertical = new OpenSocialShare();
        shareWidgetVertical.init({
             <?php echo $verticalShare?>
                 
            isCounterWidgetTheme: <?php echo $widgetTheme?>, // 0 or 1 - standard themes or counter widget themes
            isHorizontalCounter: <?php echo $countertype?>, // 0 or 1 - counter on top or counter to right - counter themes only
            isHorizontalLayout: 0, // 0 or 1 - vertical layout or horizontal layout
            widgetIconSize: "<?php echo $size?>", // "16" or "32" - 16px or 32px standard themes only
            widgetStyle: "square", //"image", "square" or "responsive" - standard themes only
           
            providers: {
                
                   top: ["<?php if(isset($oss_share_settings['vertical_rearrange_providers'])){echo implode('","', $oss_share_settings['vertical_rearrange_providers']);} ?>"]
                },
            widgets: {
                 //all : _private.getAllButtonName(_private.widgetConfig),
         <?php if($oss_share_settings['vertical_share_interface'] =='hybrid-v-v' && isset($oss_share_settings['horizontal_sharing_providers']['Hybrid']['Facebook Like'] )&& $oss_share_settings['vertical_sharing_providers']['Hybrid']['Facebook Like']=='Facebook Like' && $oss_share_settings['facebookPage']!=''|| $oss_share_settings['vertical_share_interface'] =='hybrid-v-h' && isset($oss_share_settings['vertical_sharing_providers']['Hybrid']['Facebook Like']) &&$oss_share_settings['vertical_sharing_providers']['Hybrid']['Facebook Like']=='Facebook Like' && $oss_share_settings['facebookPage']!=''){
             ?>
                 top: [<?php echo $scriptVertical?>]
         <?php }else{?>
             top: ["<?php echo implode('","', $oss_share_settings['vertical_sharing_providers']['Hybrid']); ?>"]
         <?php  } ?>
             },
           
            theme: 'OpenSocialShareDefaultTheme',  
        });
        shareWidgetVertical.injectInterface(".<?php echo $class?>");
        shareWidgetVertical.setWidgetTheme(".<?php echo $class?>");
    </script>
                        
                            <?php
                        
                    }
                }
            }
        }
        }

        /**
         * 
         * @return boolean
         */
        public static function mobile_detect() {

            $useragent = $_SERVER['HTTP_USER_AGENT'];

            if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4))) {
                return true;
            } else {
                return false;
            }
        }
    }
}
