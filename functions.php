<?php

$includes_path = TEMPLATEPATH . '/inc/';
require_once $includes_path . 'theme-parts.php';

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

/**
 * Add theme components.
 *
 * Runs in "wp" action since this is first
 * hook available after WP object is setup
 * and we can use conditional tags.
 */
function wpcampus_parent_setup_theme_parts() {

	// Print network banner.
	add_action( 'wpc_add_before_wrapper', 'wpcampus_parent_print_network_banner' );

	// Print network notifications.
	if ( function_exists( 'wpcampus_print_network_notifications' ) ) {
		add_action( 'wpc_add_before_main', 'wpcampus_print_network_notifications' );
	}

	// Print page title.
	if ( ! is_front_page() ) {
		add_action( 'wpc_add_before_content', 'wpcampus_parent_print_page_title' );
	}
}
add_action( 'wp', 'wpcampus_parent_setup_theme_parts', 0 );

/**
 * Load favicons.
 */
function wpcampus_add_favicons() {

	// Set the images folder.
	$favicons_folder = get_template_directory_uri() . '/assets/images/favicons/';

	?>
	<link rel="shortcut icon" href="<?php echo $favicons_folder; ?>wpcampus-favicon-60.png"/>
	<link rel="apple-touch-icon" href="<?php echo $favicons_folder; ?>wpcampus-favicon-60.png"/><?php

	// Set the image sizes.
	$image_sizes = array( 57, 72, 76, 114, 120, 144, 152 );

	foreach ( $image_sizes as $size ) :

		?>
		<link rel="apple-touch-icon" sizes="<?php echo "{$size}x{$size}"; ?>" href="<?php echo $favicons_folder; ?>wpcampus-favicon-<?php echo $size; ?>.png"/>
		<?php

	endforeach;

}
add_action( 'wp_head', 'wpcampus_add_favicons' );
add_action( 'admin_head', 'wpcampus_add_favicons' );
add_action( 'login_head', 'wpcampus_add_favicons' );
