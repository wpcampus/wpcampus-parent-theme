<?php

get_header();

do_action( 'wpc_add_before_content' );

if ( ! have_posts() ) :
	wpcampus_parent_print_404();
else :
	wpcampus_print_content();
endif;

do_action( 'wpc_add_after_content' );

get_footer();
