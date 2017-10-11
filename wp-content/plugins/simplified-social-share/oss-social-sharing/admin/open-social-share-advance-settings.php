<?php
// Exit if called directly
if ( ! defined( 'ABSPATH' ) ) {
    exit();
}

/**
 * The main class and initialization point of the mailchimp plugin admin.
 */
if ( ! class_exists( 'advanceSettingsPopUp' ) ) {

class advanceSettingsPopUp {
    
    function __construct(){
        
        register_activation_hook( OSS_PLUGIN_FILE, array(get_class(),'getPluginCurrentDate') );
        register_deactivation_hook( OSS_PLUGIN_FILE, array(get_class(),'deletePluginCurrentDate') );
        register_deactivation_hook( OSS_PLUGIN_FILE, array(get_class(),'deletePluginHomePopUp') );
        add_action( 'admin_init', array($this,'showNoticeTop') );

        add_option( 'pluginHomePopUp', 'true' );
      
        
        add_action( 'wp_ajax_hidePluginHomePopup', array($this, 'hidePluginHomePopup' ) );
        
        add_action( 'wp_ajax_showHomePagePopup', array($this, 'pluginHomePopUp' ) );
         add_action( 'wp_ajax_disablePopup', array($this, 'disablePopup' ) );
       
        add_action( 'wp_ajax_giveReviewNow', array($this, 'giveReviewNow' ) );
        add_action( 'wp_ajax_giveReviewLater', array($this, 'giveReviewLater' ) );
       
       
    }
   
    function pluginHomePopUp() {
       
      $nextHomePopDate = get_option('pluginHomePopUp');
      $currentDate = date("Y-m-d");
       if(strtotime($nextHomePopDate) <= strtotime($currentDate) && $nextHomePopDate !='false'){
        ?>

<div id="overlay-back"></div>
    <div id="popup">
      
        <h1><?php _e('We would Love To Be In Touch With You!', 'OpenSocialShare')?></h1>
        <p><?php _e('Join us on Facebook or Twitter, Lets be friends :-)', 'OpenSocialShare')?></p>
        <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5&appId=821056311318600";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

</script>

        <div class="fb-like fb-like-link" data-href="https://www.facebook.com/social9dotcom" data-layout="button" data-action="like" data-show-faces="false" data-share="false"></div>
        <script>
window.fbAsyncInit = function() {

  FB.Event.subscribe('edge.create', function(response) {
       alert('You liked the URL: ' + response);
  });
};
        </script>
        <div class="twitterlink"><a href="https://twitter.com/social_nine" class="twitter-follow-button" data-show-count="false" data-size="large">Follow @social_nine</a></div>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
        <div><a href="javascript:void(0)" id="hidePluginPopUp" class="close-image">Dismiss</a></div>
    </div>
<?php
}die;
 }
static function getPluginCurrentDate() {
    add_option( 'ossPluginActivateCurrentDates', date(' Y-m-d ') ); 
   
   return;
  }
static function deletePluginCurrentDate() {
    delete_option( 'ossPluginActivateCurrentDates' ); 
   
   return;
  }
static function deletePluginHomePopUp() {
    delete_option( 'pluginHomePopUp' ); 
   
   return;
  }


function showNoticeTop(){
    
            $activationDate = get_option('ossPluginActivateCurrentDates');
            
            
            $nextDate= date("Y-m-d");
          
           if(strtotime($nextDate) >= strtotime(date("Y-m-d",strtotime($activationDate. " +15days"))) && $activationDate!='false'){
            add_action( 'admin_notices', array($this,'reviewNoticeTop')); 
           }

}


function giveReviewNow(){
   
   update_option( 'ossPluginActivateCurrentDates', 'false');
    
  
}
function disablePopup(){
   
   update_option( 'pluginHomePopUp', 'false');
    
  
}

function giveReviewLater(){
    
     $reviewNextDate= date("Y-m-d");
    update_option( 'ossPluginActivateCurrentDates',$reviewNextDate);
    
}
function hidePluginHomePopup(){
    
     $homePopupNextDate= date("Y-m-d", strtotime(" +15days"));
    update_option( 'pluginHomePopUp',$homePopupNextDate);
  
}


function reviewNoticeTop() {
    if(is_super_admin()){
      
    $user_info = get_userdata(1);
        echo '<div class="update-nag notice review-notice" id="showNotice" style="width:97%"><p class="noticeMessage">'; 
       echo  'Hey '.$user_info->first_name.', We are happy to see you have been using Simplified social Sharing Plugin! May We ask you to give us an awesome review on Wordpress?<br>';
        echo '<a href="https://wordpress.org/support/view/plugin-reviews/simplified-social-share#postform" target="_blank" id="giveReview"> '.__("Sure, you deserve it!", "OpenSocialShare").'</a>'.'<br>';
        echo '<a href="javascript:void(0)" id="notGood">'.__("Not good enough", "OpenSocialShare").'.</a>'.'<br>';
        echo '<a href="javascript:void(0)" id="mayBeLater">'.__("Maybe later", "OpenSocialShare").'.</a>';
       echo  '</p><p class="laterMessage" style="display:none;"><b>'.__('Sure, No Problem!', 'OpenSocialShare').'</b></p><p class="goodEnoughMessage" style="display:none;"><b> '.__('Thanks for your feedback', 'OpenSocialShare').'</b></p></div>';
    }    
}
function emailSubscribeNotice() {?>
 
       <div class="update-nag notice" id="showNotice" style="width:97%"><p>
      Subscribe your email| <a  href="javascript:void(0)">Hide Notice</a>
        </p></div>
      
<?php }

}
new advanceSettingsPopUp();
}

