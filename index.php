<?php

get_header();

do_action( 'wpc_add_before_content' );

if ( ! have_posts() ) :
	wpcampus_parent_print_404();
else :
	while ( have_posts() ) :
		the_post();

		the_content();

	endwhile;
endif;

do_action( 'wpc_add_after_content' );

get_footer();
