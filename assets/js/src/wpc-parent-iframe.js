(function( $ ) {
	'use strict';

	$(document).ready(function() {

		if ( $('.wpc-iframe-resize').length > 0 ) {

			// We need this to "talk" to iframes from other subdomains.
			document.domain = 'wpcampus.org';

			$('.wpc-iframe-resize').addClass( 'loading' );

			iFrameResize({
				checkOrigin: false,
				initCallback: function(iframe) {
					wpcampus_parent_iframe_loaded(iframe);
				},
				resizedCallback: function(data) {
					wpcampus_parent_iframe_loaded(data.iframe);
				},
				scrollCallback: function() {}
			}, 'iframe.wpc-iframe-resize');

			/*$( window ).on( 'resize', function() {
				wpcampus_parent_iframes_resize();
			});*/

			/*$('.wpc-iframe-resize').addClass( 'loading' ).on( 'load', function(){
				var $iframe = $(this);

				// Set the iframe height to match content height.
				$(this).wpcampus_parent_iframe_resize();

				$iframe.removeClass( 'loading' );

				// Watch for the iframe to change to match height.
				$iframe.contents().find('form').on( 'change', function(){

					$iframe.wpcampus_parent_iframe_resize();

					// We need this to make sure iframe is resized after CSS transitions.
					var iframeTimeout = setTimeout(function(){
						$iframe.wpcampus_parent_iframe_resize();
						clearTimeout(iframeTimeout);
					}, 2000);

				});
			});*/
		}
	});

	function wpcampus_parent_iframe_loaded(iframe) {
		iframe.classList.remove('loading');
	}

	/*function wpcampus_parent_get_iframe_height( iframeID ) {
		if ( ! iframeID ) {
			return 0;
		}

		var iframe = document.getElementById( iframeID );
		if ( iframe === null ) {
			return 0;
		}

		var iframeDoc = iframe.contentDocument? iframe.contentDocument : iframe.contentWindow.document,
			body = iframeDoc.body,
			html = iframeDoc.documentElement;

		return Math.max( body.scrollHeight, body.offsetHeight, html.clientHeight, html.scrollHeight, html.offsetHeight );
	}

	$.fn.wpcampus_parent_iframe_resize = function() {
		var $iframe = $(this),
			iframeHeight = wpcampus_parent_get_iframe_height( $iframe.attr('id') );

		if ( iframeHeight > 0 ) {
			$iframe.css({ 'height': iframeHeight + 'px' });
		}
	};

	function wpcampus_parent_iframes_resize() {
		$('.wpc-iframe-resize').each(function() {
			$(this).wpcampus_parent_iframe_resize();
		});
	};*/
})(jQuery);
