<?php

/**
 * Print the page title.
 *
 * By default, is added via "wpc_add_before_content" hook.
 */
function wpcampus_parent_print_page_title() {
	?>
	<h1 class="wpc-page-title"><?php

		if ( is_404() ) {
			_e( 'Page Not Found', 'wpcampus' );
		} else {
			the_title();
		}

	?></h1>
	<?php
}

/**
 * Print the 404 page.
 */
function wpcampus_parent_print_404() {

	do_action( 'wpc_add_before_404' );

	?>
	<p><?php _e( 'Uh-oh. This page seems to be missing. Please check to make sure the link you requested was entered correctly.', 'wpcampus' ); ?></p>
	<p><?php printf( __( 'If you can\'t find what you\'re looking for in the menu, please %1$sreach out to us%2$s and let us know. We\'d be happy to help.', 'wpcampus' ), '<a href="/contact/">', '</a>' ); ?></p>
	<?php

	do_action( 'wpc_add_after_404' );

}
