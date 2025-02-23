/*!
 * T4B News Ticker v1.3.4 - 31 January, 2025
 * by @realwebcare - https://www.realwebcare.com/
 */
jQuery(document).ready(function() {
	"use strict";
	var selected_effect = jQuery("select[id='ticker_effect'] option:selected").val();
	jQuery('.ticker_fadetime, .scroll_control, .scroll_speed, .reveal_speed').hide();
	if (selected_effect === 'slide' || selected_effect === 'fade') {jQuery('.ticker_fadetime').show();}
	if (selected_effect === 'scroll') {jQuery('.scroll_control, .scroll_speed').show();}
	if (selected_effect === 'ticker') {jQuery('.reveal_speed, .ticker_fadetime').show();}
	jQuery("select").change(function(){
		var selected_effect = jQuery("select[id='ticker_effect'] option:selected").val();
		if (selected_effect === 'slide' || selected_effect === 'fade') {
			jQuery('.scroll_control, .scroll_speed, .reveal_speed').fadeOut();
			jQuery('.ticker_fadetime').fadeIn();
		}
		if (selected_effect === 'ticker') {
			jQuery('.scroll_control, .scroll_speed').fadeOut();
			jQuery('.reveal_speed, .ticker_fadetime').fadeIn();
		}
		if (selected_effect === 'scroll') {
			jQuery('.ticker_fadetime, .reveal_speed').fadeOut();
			jQuery('.scroll_control, .scroll_speed').fadeIn();
		}
	});

	var selected_breaking = jQuery("input[type='radio']:checked").val();
	jQuery('.ticker_cat, .ticker_tag, .ticker_custom, .ticker_postno, .ticker_order, .ticker_order_by').hide();
	if (selected_breaking === 'category') {jQuery('.ticker_cat, .ticker_postno, .ticker_order, .ticker_order_by').show();}
	if (selected_breaking === 'tag') {jQuery('.ticker_tag, .ticker_postno, .ticker_order, .ticker_order_by').show();}
	if (selected_breaking === 'custom') { jQuery('.ticker_custom').show(); }
	jQuery("input[type='radio']").change(function(){
		var selected_breaking = jQuery("input[type='radio']:checked").val();
		if (selected_breaking === 'category') {
			jQuery('.ticker_tag, .ticker_custom').fadeOut();
			jQuery('.ticker_cat, .ticker_postno, .ticker_order, .ticker_order_by').fadeIn();
		}
		if (selected_breaking === 'tag') {
			jQuery('.ticker_cat, .ticker_custom').fadeOut();
			jQuery('.ticker_tag, .ticker_postno, .ticker_order, .ticker_order_by').fadeIn();
		}
		if (selected_breaking === 'custom') {
			jQuery('.ticker_cat, .ticker_tag, .ticker_postno, .ticker_order, .ticker_order_by').fadeOut();
			jQuery('.ticker_custom').fadeIn();
		}
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

/* copy shorcode on click */
function t4bntFunction() {
	"use strict";
	var copyText = document.getElementById("t4bntShortcode");
	copyText.select();
	document.execCommand("copy");
	var tooltip = document.getElementById("t4bntTooltip");
	tooltip.innerHTML = "Copied!";
}

function t4bntoutFunc() {
	"use strict";
	var tooltip = document.getElementById("t4bntTooltip");
	tooltip.innerHTML = "Click to Copy Shortcode!";
}