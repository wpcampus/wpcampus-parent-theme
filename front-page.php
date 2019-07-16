<?php

if ( function_exists( 'wpcampus_print_network_callout' ) ) {
	add_action( 'wpcampus_before_article', 'wpcampus_print_network_callout', 0 );
}

get_template_part( 'index' );
