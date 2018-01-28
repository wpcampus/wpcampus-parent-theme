<?php

/**
 * Setup the parent theme:
 *
 * - Load the textdomain.
 * - Enable network functionality.
 * - Add theme support.
 */
function wpcampus_parent_setup_theme() {

	// Load the textdomain.
	load_theme_textdomain( 'wpcampus', get_template_directory() . '/languages' );

	// Enable network banner.
	if ( function_exists( 'wpcampus_enable_network_banner' ) ) {
		wpcampus_enable_network_banner();
	}

	// Enable network notifications.
	if ( function_exists( 'wpcampus_enable_network_notifications' ) ) {
		wpcampus_enable_network_notifications();
	}

	// Enable network footer.
	if ( function_exists( 'wpcampus_enable_network_footer' ) ) {
		wpcampus_enable_network_footer();
	}

	// Add theme support.
	add_theme_support( 'title-tag' );
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	));
}
add_action( 'after_setup_theme', 'wpcampus_parent_setup_theme', 0 );
