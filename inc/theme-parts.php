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
