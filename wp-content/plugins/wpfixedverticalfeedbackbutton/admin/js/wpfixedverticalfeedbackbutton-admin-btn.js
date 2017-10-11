(function( $ ) {
	'use strict';

	jQuery(document).ready(function($){
		$('.cbxcolor').wpColorPicker();

		$('.cbxfeedbackimage').click(function(e) {
			e.preventDefault();
			var $imagefiled = $(this);
			var image = wp.media({
				title: wpfixedverticalfeedbackbutton.uploadtext,
				// mutiple: true if you want to upload multiple files at once
				multiple: false
			}).open()
					.on('select', function(e){
						// This will return the selected image from the Media Uploader, the result is an object
						var uploaded_image = image.state().get('selection').first();
						// We convert uploaded_image to a JSON object to make accessing it easier
						// Output to the console uploaded_image
						//console.log(uploaded_image);
						var image_url = uploaded_image.toJSON().url;
						// Let's assign the url value to the input field
						$imagefiled.val(image_url);
					});
		});

		$('#cbxfeedbackbuttontext').change(function() {
			//console.log('changed');
			var val = $(this).val();
			//var selnumber = $(this).attr('data-selnumber');
			//console.log(this);
			if(val == 'custom_img') {
				//console.log($(this).next('div.for_custom_image'));
				$('div.for_custom_image').show();
				$('div.for_custom_text').hide();
			} else if(val == 'custom_text') {
				//console.log(val);
				$('div.for_custom_image').hide();
				$('div.for_custom_text').show();
			} else {
				//console.log(val);
				//console.log($(this).next('div.for_custom_image'));
				$('div.for_custom_image').hide();
				$('div.for_custom_text').hide();
			}
		});

	});

})( jQuery );
