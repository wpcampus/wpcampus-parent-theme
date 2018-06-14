<?php

$includes_path = TEMPLATEPATH . '/inc/';
require_once $includes_path . 'theme-parts.php';

/**
 * Setup the parent theme:
 *
 * - Load the text domain.
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

	// Add the MailChimp signup form to bottom of all content.
	if ( function_exists( 'wpcampus_print_mailchimp_signup' ) ) {
		add_action( 'wpc_add_after_content', 'wpcampus_print_mailchimp_signup' );
	}

	// Add theme support.
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array(
		'search-form',
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

	// Print network subscribe after notifications.
	if ( function_exists( 'wpcampus_print_network_subscribe' ) ) {
		add_action( 'wpc_add_before_main', 'wpcampus_print_network_subscribe' );
	}

	// Print page title.
	if ( ! is_front_page() ) {

		add_action( 'wpc_add_before_content', 'wpcampus_parent_print_page_title', 10 );

		if ( ! is_404() ) {
			add_action( 'wpc_add_before_content', 'wpcampus_parent_print_breadcrumbs', 15 );
		}
	} else {

		add_action( 'wpc_add_before_content', 'wpcampus_parent_print_main_callout', 10 );

	}
}
add_action( 'wp', 'wpcampus_parent_setup_theme_parts', 0 );

/**
 * Make sure the Open Sans
 * font weights we need are added.
 */
function wpcampus_parent_load_open_sans_weights( $weights ) {
	return array_merge( $weights, array( 400, 700 ) );
}
add_filter( 'wpcampus_open_sans_font_weights', 'wpcampus_parent_load_open_sans_weights' );

/**
 * Setup/enqueue styles and scripts for theme.
 */
function wpcampus_parent_enqueue_theme() {

	// Set the directories.
	$wpcampus_dir     = trailingslashit( get_template_directory_uri() );
	$wpcampus_dir_css = $wpcampus_dir . 'assets/build/css/';

	// Enqueue the base styles.
	// wpc-fonts-open-sans is registered in the network plugin.
	wp_enqueue_style( 'wpcampus-parent', $wpcampus_dir_css . 'styles.min.css', array( 'wpc-fonts-open-sans' ), null );

}
add_action( 'wp_enqueue_scripts', 'wpcampus_parent_enqueue_theme', 0 );

/**
 * Load favicons.
 */
function wpcampus_add_favicons() {

	// Set the images folder.
	$favicons_folder = get_template_directory_uri() . '/assets/images/favicons/';

	?>
	<link rel="shortcut icon" href="<?php echo $favicons_folder; ?>wpcampus-favicon-60.png"/>
	<?php

	// Set the Apple image sizes.
	$apple_image_sizes = array( 57, 60, 72, 76, 114, 120, 144, 152, 180 );
	foreach ( $apple_image_sizes as $size ) :
		?>
		<link rel="apple-touch-icon" sizes="<?php echo "{$size}x{$size}"; ?>" href="<?php echo $favicons_folder; ?>wpcampus-favicon-<?php echo $size; ?>.png">
		<?php
	endforeach;

	// Set the Android image sizes.
	$android_image_sizes = array( 16, 32, 96, 192 );
	foreach ( $android_image_sizes as $size ) :

		?>
		<link rel="icon" type="image/png" sizes="<?php echo "{$size}x{$size}"; ?>" href="<?php echo $favicons_folder; ?>wpcampus-favicon-<?php echo $size; ?>.png">
		<?php

	endforeach;

	?>
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="<?php echo $favicons_folder; ?>wpcampus-favicon-144x144.png">
	<meta name="theme-color" content="#ffffff">
	<?php
}
add_action( 'wp_head', 'wpcampus_add_favicons' );
add_action( 'admin_head', 'wpcampus_add_favicons' );
add_action( 'login_head', 'wpcampus_add_favicons' );
