/**
 *  Copy the block pattern to the clipboard.
 * 
 */

jQuery(document).ready(function ($) {

	var clipboard = new ClipboardJS('.inclusive-copy');
	clipboard.on('success', function (e) {
		var $wrapper = $(e.trigger).closest('li');
		$('.success', $wrapper).addClass('visible');
	});

} );
