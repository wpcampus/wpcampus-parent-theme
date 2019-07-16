<?php

/**
 * Template Name: WPCampus: Speaker Application
 */

/**
 * Load speaker app specific assets.
 */
function wpcampus_parent_speaker_app_assets() {
	wp_enqueue_script( 'wpc-parent-iframe' );
}
add_action( 'wp_enqueue_scripts', 'wpcampus_parent_speaker_app_assets', 20 );

/**
 * Filter the content.
 */
function wpcampus_parent_speaker_app_content( $content ) {

	// @TODO add settings page.

	$speaker_app_url = get_option( 'wpc_speaker_app_url' );
	if ( empty( $speaker_app_url ) ) {
		return;
	}

	$speaker_app_title = get_option( 'wpc_speaker_app_title' );

	ob_start();

	echo $content;

	// sandbox="allow-top-navigation allow-scripts allow-forms allow-same-origin"
	?>
	<iframe title="<?php echo esc_attr( $speaker_app_title ); ?>" id="wpcampus-speaker-app" class="wpc-iframe-resize" src="<?php echo $speaker_app_url; ?>" scrolling="yes"></iframe>
	<?php

	return ob_get_clean();
}
add_filter( 'the_content', 'wpcampus_parent_speaker_app_content' );

get_template_part( 'index' );
