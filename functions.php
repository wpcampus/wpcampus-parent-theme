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

	// Enable network components.
	if ( function_exists( 'wpcampus_network_enable' ) ) {
		wpcampus_network_enable( array( 'banner', 'notifications', 'coc', 'footer' ) );
	}

	// Print Code of Conduct after main content.
	if ( function_exists( 'wpcampus_print_network_coc' ) ) {
		add_action( 'wpc_add_before_footer', 'wpcampus_print_network_coc' );
	}

	// Add the MailChimp signup form to bottom of all content.
	if ( function_exists( 'wpcampus_print_mailchimp_signup' ) ) {
		add_action( 'wpc_add_after_content', 'wpcampus_print_mailchimp_signup', 1000 );
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
		add_action( 'wpc_add_before_body', 'wpcampus_print_network_notifications' );
	}

	// Print network subscribe after notifications.
	// @TODO must have been deleted at some point?
	/*if ( function_exists( 'wpcampus_print_network_subscribe' ) ) {
		add_action( 'wpc_add_before_main', 'wpcampus_print_network_subscribe' );
	}*/

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
	return array_merge( $weights, array( 400, 600, 700 ) );
}
add_filter( 'wpcampus_open_sans_font_weights', 'wpcampus_parent_load_open_sans_weights' );

/**
 * Setup/enqueue styles and scripts for theme.
 */
function wpcampus_parent_enqueue_theme() {

	// Set the directories.
	$wpcampus_dir     = trailingslashit( get_template_directory_uri() );
	$wpcampus_dir_css = $wpcampus_dir . 'assets/build/css/';
	$wpcampus_dir_js  = $wpcampus_dir . 'assets/build/js/';

	$assets_ver = '2.4';

	// Enqueue the base styles.
	// wpc-fonts-open-sans is registered in the network plugin.
	wp_enqueue_style( 'wpcampus-parent', $wpcampus_dir_css . 'styles.min.css', array( 'wpc-fonts-open-sans' ), $assets_ver );

	// Right now this is enqueued in the app template file.
	wp_register_script( 'wpc-iframe-resizer', $wpcampus_dir_js . 'iframeResizer.min.js', array(), $assets_ver );
	wp_register_script( 'wpc-parent-iframe', $wpcampus_dir_js . 'wpc-parent-iframe.min.js', array( 'jquery', 'wpc-iframe-resizer' ), $assets_ver );

}
add_action( 'wp_enqueue_scripts', 'wpcampus_parent_enqueue_theme', 0 );

function wpcampus_print_content() {

	$is_archive = is_archive();

	if ( $is_archive ) {

		$article_css = array( 'wpcampus-articles' );

		$post_types = get_query_var( 'post_type' );
		if ( ! empty( $post_types ) ) {

			if ( ! is_array( $post_types ) ) {
				$post_types = explode( ',', $post_types );
			}

			foreach ( $post_types as $post_type ) {
				$article_css[] = "post-{$post_type}";
			}
		}

		echo '<div class="' . implode( ' ', $article_css ) . '">';

	}

	while ( have_posts() ) :
		the_post();

		// Get post information.
		$post_id = get_the_ID();
		$post_permalink = get_permalink( $post_id );

		do_action( 'wpcampus_before_article' );

		?>
		<article id="post-<?php echo $post_id; ?>" <?php post_class(); ?>>
			<?php

			if ( $is_archive ) :

				do_action( 'wpcampus_before_article_header' );

				?>
				<h2 class="article-title"><a href="<?php echo $post_permalink; ?>"><?php the_title(); ?></a></h2>
				<?php

				do_action( 'wpcampus_after_article_header' );

				do_action( 'wpcampus_before_article_excerpt' );

				the_excerpt();

				do_action( 'wpcampus_after_article_excerpt' );

			else :

				do_action( 'wpcampus_before_article_content' );

				the_content();

				do_action( 'wpcampus_after_article_content' );

			endif;

			?>
		</article>
		<?php

		do_action( 'wpcampus_after_article' );

	endwhile;

	if ( $is_archive ) {
		echo '</div>';
	}
}

/**
 * Add custom query vars.
 */
function wpcampus_parent_add_query_vars( $vars ) {
	$vars[] = 'wpc_template';
	return $vars;
}
add_filter( 'query_vars', 'wpcampus_parent_add_query_vars' );

/**
 * Load template based on query vars.
 */
function wpcampus_parent_setup_template( $template ) {

	// See if we're querying for a template.
	$wpc_template = get_query_var( 'wpc_template' );
	if ( empty( $wpc_template ) ) {
		return $template;
	}

	$wpc_template = 'template-' . $wpc_template;

	//do_action( "get_template_part_{$wpc_template}", $wpc_template, null );

	// Look for our template, find default if doesnt exist.
	$templates = array( "{$wpc_template}.php", $template );

	return locate_template( $templates, false, false );
}
add_filter( 'template_include', 'wpcampus_parent_setup_template' );
