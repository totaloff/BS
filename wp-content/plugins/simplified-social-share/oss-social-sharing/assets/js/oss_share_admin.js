jQuery(document).ready(function($) {

	//tabs
	$('.oss-options-tab-btns li').click(function(){
		var tab_id = $(this).attr('data-tab');

		$('.oss-options-tab-btns li').removeClass('oss-active');
		$('.oss-tab-frame').removeClass('oss-active');

		$(this).addClass('oss-active');
		$("#"+tab_id).addClass('oss-active');
	});

	var openSocialShareHorizontalSharingProviders;
	var openSocialShareVerticalSharingProviders;
	
	function init(){
		openSocialShareHorizontalSharingProviders = $('.OpenSocialShare_hz_share_providers');
		openSocialShareVerticalSharingProviders = $('.Oss_ve_share_providers')

		var h_selected = $('input:radio[name="OpenSocialShare_share_settings[horizontal_share_interface]"]:checked').val();
		var v_selected = $('input:radio[name="OpenSocialShare_share_settings[vertical_share_interface]"]:checked').val();

		if(h_selected == "32-h" || h_selected == "16-h" || h_selected == "responsive") {
			$('#oss_hz_theme_options,#oss_hz_hz_theme_options,#oss_horizontal_rearrange_container').show();
			$('#oss_hz_ve_theme_options').hide();
			
		}else if (h_selected == "hybrid-h-h" || h_selected == "hybrid-h-v") {
			$('#oss_hz_theme_options,#oss_hz_ve_theme_options').show();
			$('#oss_hz_hz_theme_options,#oss_horizontal_rearrange_container').hide();
			
		}else{
			$('#oss_hz_theme_options,#oss_horizontal_rearrange_container').hide();
			
		}

		if(v_selected == "32-v" || v_selected == "16-v") {
			$('#oss_ve_theme_options,#oss_ve_hz_theme_options,#oss_vertical_rearrange_container').show();
			$('#oss_ve_ve_theme_options').hide();
			
		}else if (v_selected == "hybrid-v-h" || v_selected == "hybrid-v-v") {
			$('#oss_ve_theme_options,#oss_ve_ve_theme_options').show();
			$('#oss_ve_hz_theme_options,#oss_vertical_rearrange_container').hide();
			
		}else{
			$('#oss_ve_theme_options,#oss_vertical_rearrange_container').hide();
			
		}
	}

	if($('#oss-enable-horizontal').is(':checked')){
		$(".oss-option-disabled-hr").hide();
	}else{
		$(".oss-option-disabled-hr").show();
	}

	if($('#oss-enable-vertical').is(':checked')){
		$(".oss-option-disabled-vr").hide();
	}else{
		$(".oss-option-disabled-vr").show();
	}

	$('input:radio[name="OpenSocialShare_share_settings[horizontal_share_interface]"]').change( function(){
		if(this.value == "32-h" || this.value == "16-h" || this.value == "responsive") {
			$('#oss_hz_theme_options,#oss_hz_hz_theme_options,#oss_horizontal_rearrange_container').show();
			$('#oss_hz_ve_theme_options').hide();
			
		}else if (this.value == "hybrid-h-h" || this.value == "hybrid-h-v") {
			$('#oss_hz_theme_options,#oss_hz_ve_theme_options').show();
			$('#oss_hz_hz_theme_options,#oss_horizontal_rearrange_container').hide();
			
		}else{
			$('#oss_hz_theme_options,#oss_horizontal_rearrange_container').hide();
			
		}
	});

	$('input:radio[name="OpenSocialShare_share_settings[vertical_share_interface]"]').change( function(){
		if(this.value == "32-v" || this.value == "16-v") {
			$('#oss_ve_theme_options,#oss_ve_hz_theme_options,#oss_vertical_rearrange_container').show();
			$('#oss_ve_ve_theme_options').hide();
			
		}else if (this.value == "hybrid-v-h" || this.value == "hybrid-v-v") {
			$('#oss_ve_theme_options,#oss_ve_ve_theme_options,#oss_vertical_rearrange_container').show();
			$('#oss_ve_hz_theme_options,#oss_vertical_rearrange_container').hide();
			
		}else{
			$('#oss_ve_theme_options,#oss_vertical_rearrange_container').hide();
			
		}
	});

	$("#ossHorizontalSortable").sortable({
		scroll: false,
		revert: true,
		tolerance: 'pointer',
		items: '> li:not(.oss-pin)',
		containment: 'parent',
		axis: 'x'
	});

	$("#ossVerticalSortable").sortable({
		scroll: false,
		revert: true,
		tolerance: 'pointer',
		items: '> li:not(.oss-pin)',
		containment: 'parent',
		axis: 'y'
	});

	// prepare rearrange provider list
	function openSocialShareRearrangeProviderList(elem, sharingType) {
           
		$ul = $('#oss' + sharingType + 'Sortable');
                
		if (elem.checked) {
			$listItem = $('<li />');
			$listItem.attr({
				id: 'OpenSocialShare' + sharingType + 'LI' + elem.value,
				title: elem.value,
				class: 'osshare_iconsprite32 oss-icon-' + elem.value.toLowerCase()
			});

			// append hidden field
			$provider = $('<input />');
			$provider.attr({
				type: 'hidden',
				name: 'OpenSocialShare_share_settings[' + sharingType.toLowerCase() + '_rearrange_providers][]',
				value: elem.value
			});
                        
                        
			$listItem.append($provider);
			$ul.append($listItem);

		} else {
                    
			
				$('#OpenSocialShare' + sharingType + 'LI' + elem.value).remove();
				$('#oss' + sharingType + 'LI' + elem.value).remove();
				
			
		}
	}

	// limit maximum number of providers selected in horizontal sharing
	function ossHorizontalSharingLimit( elem ) {
		var checkCount = 0;
		for (var i = 0; i < openSocialShareHorizontalSharingProviders.length; i++) {
			if (openSocialShareHorizontalSharingProviders[i].checked) {
				// count checked providers
				checkCount++;
				if (checkCount >= 9) {
					elem.checked = false;
					$('#ossHorizontalSharingLimit').show().delay(3000).fadeOut();
					return;
				}
			}
		}
	}

	// limit maximum number of providers selected in horizontal sharing
	function ossHorizontalVerticalSharingLimit( elem ) {
		var checkCount = 0;
		var inputs = document.getElementsByClassName(elem.className);

		for (var i = 0; i < inputs.length; i++) {
			if (inputs[i].checked) {
				// count checked providers
				checkCount++;
				if (checkCount >= 9) {
					elem.checked = false;
					$('#ossHorizontalVerticalSharingLimit').show().delay(3000).fadeOut();
					return;
				}
			}
		}
	}

	// limit maximum number of providers selected in vertical sharing
	function ossVerticalSharingLimit( elem ) {
          
		var checkCount = 0;
		for (var i = 0; i < openSocialShareVerticalSharingProviders.length; i++) {
			if (openSocialShareVerticalSharingProviders[i].checked) {
                         
				// count checked providers
				checkCount++;
				if (checkCount >= 9) {
					elem.checked = false;
					$('#ossVerticalSharingLimit').show().delay(3000).fadeOut();
					return;
				}
			}
		}
	}

	function ossVerticalVerticalSharingLimit( elem ) {
		var checkCount = 0;
		var inputs = document.getElementsByClassName(elem.className);
		for (var i = 0; i < inputs.length; i++) {
			if (inputs[i].checked) {
				// count checked providers
				checkCount++;
				if (checkCount >= 9) {
					elem.checked = false;
					$('#ossVerticalVerticalSharingLimit').show().delay(3000).fadeOut();
					return;
				}
			}
		}
	}

	$('.OpenSocialShare_hz_share_providers').change(function(){
		ossHorizontalSharingLimit( this );
		openSocialShareRearrangeProviderList( this, 'Horizontal' );
	});

	$('.OpenSocialShare_hz_ve_share_providers').change(function(){
		ossHorizontalVerticalSharingLimit( this );
	});

	$('.Oss_ve_share_providers').change(function(){
                ossVerticalSharingLimit( this );
		openSocialShareRearrangeProviderList( this, 'Vertical' );
	});

	$('.Oss_ve_ve_share_providers').change(function(){
		ossVerticalVerticalSharingLimit( this );
	});

	$('#oss-clicker-hr-home').change(function(){
		if($(this).is(':checked')){
			$('.oss-clicker-hr-home-options.default').prop('checked', true);
		}else{
			$('.oss-clicker-hr-home-options').prop('checked', false);
		}
	});

	$('#oss-clicker-hr-post').change(function(){
		if($(this).is(':checked')){
			$('.oss-clicker-hr-post-options.default').prop('checked', true);
		}else{
			$('.oss-clicker-hr-post-options').prop('checked', false);
		}
	});

	$('#oss-clicker-hr-static').change(function(){
		if($(this).is(':checked')){
			$('.oss-clicker-hr-static-options.default').prop('checked', true);
		}else{
			$('.oss-clicker-hr-static-options').prop('checked', false);
		}
	});

	$('#oss-clicker-hr-excerpts').change(function(){
		if($(this).is(':checked')){
			$('.oss-clicker-hr-excerpts-options.default').prop('checked', true);
		}else{
			$('.oss-clicker-hr-excerpts-options').prop('checked', false);
		}
	});

	$('#oss-enable-horizontal').change(function(){
		if($(this).is(':checked')){
			$('#oss-clicker-hr-home').prop('checked', true);
			$('.oss-clicker-hr-home-options.default').prop('checked', true);
			$('#oss-clicker-hr-post').prop('checked', true);
			$('.oss-clicker-hr-post-options.default').prop('checked', true);
			$('#oss-clicker-hr-static').prop('checked', true);
			$('.oss-clicker-hr-static-options.default').prop('checked', true);
			$('#oss-clicker-hr-excerpts').prop('checked', true);
			$('.oss-clicker-hr-excerpts-options.default').prop('checked', true);

		}else{
			$('#oss-clicker-hr-home').prop('checked', false);
			$('.oss-clicker-hr-home-options').prop('checked', false);
			$('#oss-clicker-hr-post').prop('checked', false);
			$('.oss-clicker-hr-post-options').prop('checked', false);
			$('#oss-clicker-hr-static').prop('checked', false);
			$('.oss-clicker-hr-static-options').prop('checked', false);
			$('#oss-clicker-hr-excerpts').prop('checked', false);
			$('.oss-clicker-hr-excerpts-options').prop('checked', false);
		}
	});

	$('#oss-clicker-vr-home').change(function(){
		if($(this).is(':checked')){
			$('.oss-clicker-vr-home-options.default').prop('checked', true);
		}else{
			$('.oss-clicker-vr-home-options').prop('checked', false);
		}
	});

	$('#oss-clicker-vr-post').change(function(){
		if($(this).is(':checked')){
			$('.oss-clicker-vr-post-options.default').prop('checked', true);
		}else{
			$('.oss-clicker-vr-post-options').prop('checked', false);
		}
	});

	$('#oss-clicker-vr-static').change(function(){
		if($(this).is(':checked')){
			$('.oss-clicker-vr-static-options.default').prop('checked', true);
		}else{
			$('.oss-clicker-vr-static-options').prop('checked', false);
		}
	});

	$('#oss-enable-vertical').change(function(){
		if($(this).is(':checked')){
			$('#oss-clicker-vr-home').prop('checked', true);
			$('.oss-clicker-vr-home-options.default').prop('checked', true);
			$('#oss-clicker-vr-post').prop('checked', true);
			$('.oss-clicker-vr-post-options.default').prop('checked', true);
			$('#oss-clicker-vr-static').prop('checked', true);
			$('.oss-clicker-vr-static-options.default').prop('checked', true);

		}else{
			$('#oss-clicker-vr-home').prop('checked', false);
			$('.oss-clicker-vr-home-options').prop('checked', false);
			$('#oss-clicker-vr-post').prop('checked', false);
			$('.oss-clicker-vr-post-options').prop('checked', false);
			$('#oss-clicker-vr-static').prop('checked', false);
			$('.oss-clicker-vr-static-options').prop('checked', false);
		}
	});

	$('#oss-enable-horizontal').change(function(){
		if($(this).is(':checked')){
			$(".oss-option-disabled-hr").hide();
		}else{
			$(".oss-option-disabled-hr").show();
		}
	});

	$('#oss-enable-vertical').change(function(){
		if($(this).is(':checked')){
			$(".oss-option-disabled-vr").hide();
		}else{
			$(".oss-option-disabled-vr").show();
		}
	});

	init();


 
    facebookPageUrlTextBox();
   
    jQuery('.oss_horizontal_interface input[type="radio"],.oss_vertical_interface input[type="radio"],#oss-enable-vertical,#oss-enable-horizontal').click(function(){
        facebookPageUrlTextBox();
    });
    checkValidJson();
    popUpHideShowDiv();
  
    jQuery('.advanceSettings').click(function(){
       popUpHideShowDiv();
      });
    
    jQuery('#oSSAdvanceSetting').find('input[type="submit"]').addClass('advanceSettings');
    popUpHideShow();
    jQuery('input[name="OpenSocialShare_share_settings[popupHeightWidth]"]').click(function(){
        popUpHideShow();
        
    })
    
//    jQuery('input[name="OpenSocialShare_share_settings[popupHeightWidth]"]').click(function(){
//        if(jQuery('input[name="OpenSocialShare_share_settings[popupHeightWidth]"]:checked').val() == '1' && jQuery('input[name="OpenSocialShare_share_settings[popupWindowHeight]"]').val() != '' && jQuery('input[name="OpenSocialShare_share_settings[popupWindowWidth]"]').val() != ''){
//           jQuery(".advanceSettings").attr('disabled','disabled'); 
//        }else{
//            
//            jQuery(".advanceSettings").removeAttr('disabled');
//        }
//        
//        
//    })
    jQuery('input[name="OpenSocialShare_share_settings[popupWindowHeight]"], input[name="OpenSocialShare_share_settings[popupWindowWidth]"]').blur(function(){
        if(jQuery('input[name="OpenSocialShare_share_settings[popupHeightWidth]"]:checked').val() == '1'){ 
            if(jQuery('input[name="OpenSocialShare_share_settings[popupWindowHeight]"]').val() == '' ){
                jQuery(".errorMessageHeight").show();
            }            
            if(jQuery('input[name="OpenSocialShare_share_settings[popupWindowWidth]"]').val() == ''){
                jQuery(".errorMessageWidth").show();
            }
            if(jQuery('input[name="OpenSocialShare_share_settings[popupWindowHeight]"]').val() != ''){
                jQuery(".errorMessageHeight").hide();
            } 
            if(jQuery('input[name="OpenSocialShare_share_settings[popupWindowWidth]"]').val() != ''){
                jQuery(".errorMessageWidth").hide();
            }
            if((jQuery('input[name="OpenSocialShare_share_settings[popupWindowWidth]"]').val() != '') && (jQuery('input[name="OpenSocialShare_share_settings[popupWindowHeight]"]').val() != '')){
                jQuery(".advanceSettings").removeAttr('disabled');
            }else{
                jQuery(".advanceSettings").attr('disabled','disabled');
            }
        }
        else{
            jQuery(".errorMessageHeight,.errorMessageWidth").hide();
            jQuery(".advanceSettings").removeAttr('disabled');
        }
    });
    
    jQuery('input[name="OpenSocialShare_share_settings[popupHeightWidth]"]').click(function(){
        if(jQuery('input[name="OpenSocialShare_share_settings[popupHeightWidth]"]:checked').val() == '1' && (jQuery('input[name="OpenSocialShare_share_settings[popupWindowHeight]"]').val() != '')||( jQuery('input[name="OpenSocialShare_share_settings[popupWindowWidth]"]').val() != '' )){
            jQuery(".errorMessageWidth,.errorMessageHeight").hide();
            jQuery(".advanceSettings").removeAttr('disabled');
        }else{
            jQuery(".advanceSettings").removeAttr('disabled');
        }
     });
    });
    

function facebookPageUrlTextBox(){

        if (jQuery('input[name="OpenSocialShare_share_settings[vertical_share_interface]"]:checked').val() == "hybrid-v-v" && jQuery('input[name="OpenSocialShare_share_settings[vertical_enable]"]:checked').val() == "1" || jQuery('input[name="OpenSocialShare_share_settings[vertical_share_interface]"]:checked').val() == "hybrid-v-h" && jQuery('input[name="OpenSocialShare_share_settings[vertical_enable]"]:checked').val() == "1" || jQuery('input[name="OpenSocialShare_share_settings[horizontal_share_interface]"]:checked').val() == "hybrid-h-h" && jQuery('input[name="OpenSocialShare_share_settings[horizontal_enable]"]:checked').val() == "1" || jQuery('input[name="OpenSocialShare_share_settings[horizontal_share_interface]"]:checked').val() == "hybrid-h-v" && jQuery('input[name="OpenSocialShare_share_settings[horizontal_enable]"]:checked').val() == "1") {
           jQuery("#facebookPage").show();
        }else{
           jQuery("#facebookPage").hide();
        }
}


 jQuery(window).load(function () {

    jQuery.post(ajaxurl, {
        action: 'showHomePagePopup',
    }, function (response) {


        jQuery('.showPluginHomePopUp').append(response);

        jQuery(".close-image").on('click', function () {

            jQuery('.showPluginHomePopUp').remove();
            jQuery('#overlay-back').fadeOut(500);
        });
        jQuery('#hidePluginPopUp').click(function () {

            jQuery.post(ajaxurl, {
                action: 'hidePluginHomePopup',
            }, function (response) {

            });
        });

        window.fbAsyncInit = function () {

            FB.Event.subscribe('edge.create', function (response) {
                jQuery('.showPluginHomePopUp').remove();
                jQuery('#overlay-back').fadeOut(500);
                jQuery.post(ajaxurl, {
                    action: 'disablePopup',
                }, function (response) {

                });
            });
        };

        setTimeout(function () {
            if(typeof twttr !='undefined'){
            twttr.events.bind(
                    'follow',
                    function (event) {
                        var followedUserId = event.data.user_id;
                        var followedScreenName = event.data.screen_name;
                        jQuery('.showPluginHomePopUp').remove();
                        jQuery('#overlay-back').fadeOut(500);
                        jQuery.post(ajaxurl, {
                            action: 'disablePopup',
                        }, function (response) {

                        });
                    }
            );
        }
        }, 3000);
    });
});

// Function to validate raas option json format
 function checkValidJson() {


    var addCustomOption = jQuery('textarea[name="OpenSocialShare_share_settings[customOptions]"]');
       addCustomOption.blur(function(){
       var profile = addCustomOption.val();
       var response = '';
       try
       {
           response = jQuery.parseJSON(profile);
           
           if(response != true && response != false){
               var validjson = JSON.stringify(response, null, '\t').replace(/</g, '&lt;');
               if(validjson != 'null'){
                   addCustomOption.val(validjson);
                   addCustomOption.css("border","1px solid green");
               }else{
                   addCustomOption.css("border","1px solid red");
               }
           }
           else{
               addCustomOption.css("border","1px solid green");
           }
       } catch (e)
       {
           addCustomOption.css("border","1px solid green");
       }
   });
}

function popUpHideShow() {
    if(jQuery('input[name="OpenSocialShare_share_settings[popupHeightWidth]"]:checked').val() == '1'){
            jQuery('#popupArea').show();
        }else{
            jQuery('#popupArea').hide();
            
        }
}
function popUpHideShowDiv() {
    if(jQuery('input[name="OpenSocialShare_share_settings[popupHeightWidth]"]:checked').val() == '1' && jQuery('input[name="OpenSocialShare_share_settings[popupWindowHeight]"]').val() == '' && jQuery('input[name="OpenSocialShare_share_settings[popupWindowWidth]"]').val() == ''){
            jQuery(".errorMessageHeight,.errorMessageWidth").show();
            
            jQuery(".advanceSettings").attr('disabled','disabled');
            
        }else{
            jQuery(".errorMessageHeight,.errorMessageWidth").hide();
            jQuery(".advanceSettings").removeAttr('disabled');
        }
    }
