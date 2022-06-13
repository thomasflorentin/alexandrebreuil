( function( $ ) {

	'use strict';

	/**
	 * Demo importer.
	 */
	$(document).ready(function(){
		$('.button-install-demo').on('click', function(){
			var answer = confirm(konzeptAdmin.confirmMessage);
			
			return answer;
		});
		
		$('body').on('change', '.demo-content-select', function(){
			var selected = [];
			
			$('.demo-content-select').each(function(index, element){
				var checked = this.checked;
				var name = $(this).attr('name');
				checked && selected.push(name);
			});
			
			var href = $('.button-install-demo').attr('href');
			$('.button-install-demo').attr('href', href.replace(/demo_version=.*?&/, `demo_version=${selected.join(encodeURIComponent('|'))}&` ));
		});
	});

} )( jQuery );

/**
 * Styling page scripts.
 * Initialization of WP Color Picker.
 */
jQuery(document).ready(function(){
	if(typeof jQuery.wp === "object" && typeof jQuery.wp.wpColorPicker === "function"){
		var options = {
			palettes: false
		};
		jQuery(".flow_styling_input_color").wpColorPicker(options);
	}
});

/**
 * Footer creator scripts.
 * Updates footer creator container.
 */
function updateColumns(){
	jQuery('.footer-columns').empty();
	var myString = jQuery('[name="footer_col_countcustom"]').val();
	if(myString === undefined){
		return;
	}
	var myArray = myString.split(',');
	jQuery.each(myArray, function(index, value) {
		if(value == ''){
			return;
		}
		var column = jQuery('<div class="' + value + '"></div>').append('<div class="column-label">Column ' + ( index + 1 ) + '</div>');
		jQuery('.footer-columns').append(column);
	});
}
jQuery(document).ready(function(){
	jQuery('.footer-clear-rows').click(function(){
		jQuery('[name="footer_col_countcustom"]').val('');
		jQuery('[name="footer_col_countcustom"]').trigger('change');
	});
	jQuery('.footer-add-new-row').click(function(){
		var currentVal = jQuery('[name="footer_col_countcustom"]').val();
		if(currentVal != ''){
			currentVal += ', ';
		}
		var newRow = jQuery('.footer-new-row select').val();
		jQuery('[name="footer_col_countcustom"]').val(currentVal + newRow);
		jQuery('[name="footer_col_countcustom"]').trigger('change');
	});
	updateColumns();
	jQuery('[name="footer_col_countcustom"]').on('change', function(){
		updateColumns();
	});
});

/**
 * Parse URL (SuperSlide, ImageSampler)
 *
 * Source: http://james.padolsey.com/javascript/parsing-urls-with-the-dom/
 * License: http://unlicense.org/
 */
function parseURL(url) {
    var a =  document.createElement('a');
    a.href = url;
    return {
        source: url,
        protocol: a.protocol.replace(':',''),
        host: a.hostname,
        port: a.port,
        query: a.search,
        params: (function(){
            var ret = {},
                seg = a.search.replace(/^\?/,'').split('&'),
                len = seg.length, i = 0, s;
            for (;i<len;i++) {
                if (!seg[i]) { continue; }
                s = seg[i].split('=');
                ret[s[0]] = s[1];
            }
            return ret;
        })(),
        file: (a.pathname.match(/\/([^\/?#]+)$/i) || [,''])[1],
        hash: a.hash.replace('#',''),
        path: a.pathname.replace(/^([^\/])/,'/$1'),
        relative: (a.href.match(/tps?:\/\/[^\/]+(.+)/) || [,''])[1],
        segments: a.pathname.replace(/^\//,'').split('/')
    };
}