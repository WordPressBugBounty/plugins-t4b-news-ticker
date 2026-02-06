/*!
 * T4B News Ticker - Admin JavaScript
 *
 * Implements tabbable JavaScript functionality, allowing users to switch between 
 * different sections within the plugin settings page using tabs.
 * Uses localStorage to remember the active tab, so the plugin interface maintains 
 * the user's last tab state even after a page reload or revisit.
 *
 * T4B News Ticker v1.4.3 - 16 November, 2025
 * by @realwebcare - https://www.realwebcare.com/
 */
jQuery(document).ready(function($) {
	"use strict";

	// Switches option sections
	$('.group').hide();
	var activetab = '';
	if (typeof(localStorage) != 'undefined' ) {
		activetab = localStorage.getItem("activetab");
	}
	//if url has section id as hash then set it as active or override the current local storage value
	if(window.location.hash){
		activetab = window.location.hash;
		if (typeof(localStorage) != 'undefined' ) {
			localStorage.setItem("activetab", activetab);
		}
	}
	if (activetab != '' && $(activetab).length ) {
		$(activetab).fadeIn();
	} else {
		$('.group:first').fadeIn();
	}
	$('.group .collapsed').each(function(){
		$(this).find('input:checked').parent().parent().parent().nextAll().each(
		function(){
			if ($(this).hasClass('last')) {
				$(this).removeClass('hidden');
				return false;
			}
			$(this).filter('.hidden').removeClass('hidden');
		});
	});
	if (activetab != '' && $(activetab + '-tab').length ) {
		$(activetab + '-tab').addClass('nav-tab-active');
	}
	else {
		$('.nav-tab-wrapper a:first').addClass('nav-tab-active');
	}
    $('.t4bnt-notice .t4bnt-close-icon').on('click', function (e) {
        $(this).closest('.t4bnt-notice').fadeOut(300, function () {
            $(this).remove();
        });
    });
	$('.nav-tab-wrapper a').click(function(evt) {
		$('.nav-tab-wrapper a').removeClass('nav-tab-active');
		$(this).addClass('nav-tab-active').blur();
		var clicked_group = $(this).attr('href');
		if (typeof(localStorage) != 'undefined' ) {
			localStorage.setItem("activetab", $(this).attr('href'));
		}
		$('.group').hide();
		$(clicked_group).fadeIn();
		evt.preventDefault();
	});
	$('body').on('click', '.wpsa-browse', function (event) {
		event.preventDefault();
		var self = $(this);
		// Create the media frame.
		var file_frame = wp.media.frames.file_frame = wp.media({
			title: self.data('uploader_title'),
			button: {
				text: self.data('uploader_button_text'),
			},
			multiple: false
		});
		file_frame.on('select', function () {
			attachment = file_frame.state().get('selection').first().toJSON();
			self.prev('.wpsa-url').val(attachment.url).change();
		});
		// Finally, open the modal
		file_frame.open();
	});

	// Plugin various options toggling
	var selected_effect = $("select[id='t4bnt_advance[ticker_effect]'] option:selected").val();

	$('.ticker_fadetime, .scroll_control, .scroll_speed, .reveal_speed').hide();
	if (selected_effect === 'slide' || selected_effect === 'fade') {$('.ticker_fadetime').show();}
	if (selected_effect === 'scroll') {$('.scroll_control, .scroll_speed').show();}
	if (selected_effect === 'ticker') {$('.reveal_speed, .ticker_fadetime').show();}

	$("select").change(function(){
		var selected_effect = $("select[id='t4bnt_advance[ticker_effect]'] option:selected").val();

		if (selected_effect === 'slide' || selected_effect === 'fade') {
			$('.scroll_control, .scroll_speed, .reveal_speed').fadeOut();
			$('.ticker_fadetime').fadeIn();
		}
		if (selected_effect === 'ticker') {
			$('.scroll_control, .scroll_speed').fadeOut();
			$('.reveal_speed, .ticker_fadetime').fadeIn();
		}
		if (selected_effect === 'scroll') {
			$('.ticker_fadetime, .reveal_speed').fadeOut();
			$('.scroll_control, .scroll_speed').fadeIn();
		}
	});

	var selected_tickerType = $(".ticker_type input[type='radio']:checked").val();

	$('.ticker_cat, .ticker_tag, .ticker_custom, .ticker_postno, .ticker_order, .ticker_order_by, .title_length').hide();

	if (selected_tickerType === 'category') {
		$('.ticker_cat, .ticker_postno, .ticker_order, .ticker_order_by, .title_length').show();
	}
	if (selected_tickerType === 'tag') {
		$('.ticker_tag, .ticker_postno, .ticker_order, .ticker_order_by, .title_length').show();
	}
	if (selected_tickerType === 'custom') {
		$('.ticker_custom').show();
	}

	$(".ticker_type input[type='radio']").change(function() {
		var selected_tickerType = $("input[type='radio']:checked").val();

		if (selected_tickerType === 'category') {
			$('.ticker_tag, .ticker_custom').fadeOut();
			$('.ticker_cat, .ticker_postno, .ticker_order, .ticker_order_by, .title_length').fadeIn();
		}
		if (selected_tickerType === 'tag') {
			$('.ticker_cat, .ticker_custom').fadeOut();
			$('.ticker_tag, .ticker_postno, .ticker_order, .ticker_order_by, .title_length').fadeIn();
		}
		if (selected_tickerType === 'custom') {
			$('.ticker_cat, .ticker_tag, .ticker_postno, .ticker_order, .ticker_order_by, .title_length').fadeOut();
			$('.ticker_custom').fadeIn();
		}
	});

    $(".copy-tooltip").click(function() {
        var shortcode = "[t4b-ticker]"; // Define the shortcode to copy

        // Create a temporary input element
        var tempInput = $("<input>");
        $("body").append(tempInput);
        tempInput.val(shortcode).select();
        document.execCommand("copy");
        tempInput.remove();

        // Update tooltip text
        $("#t4bntTooltip").text("Copied!");

        // Reset tooltip text after 2 seconds
        setTimeout(function() {
            $("#t4bntTooltip").text("Click to Copy Shortcode!");
        }, 2000);
    });
});

function toggleVisibility(id) {
	"use strict";
	var e = document.getElementById(id);

	if(e.style.display === 'block') {
		e.style.display = 'none';
	} else {
		e.style.display = 'block';
	}
}