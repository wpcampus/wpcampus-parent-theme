<?php

/**
 * Template Name: WPCampus: Speakers
 */

/**
 * Load speaker app specific assets.
 */
function wpcampus_add_page_title_actions( $actions ) {

	$twitter_url = get_option( 'wpc_twitter_speakers_list' );

	if ( empty( $twitter_url ) ) {
		return $actions;
	}

	$actions[] = array(
		'href'  => $twitter_url,
		'label' => sprintf( __( 'Follow speakers on %s', 'wpcampus-2018' ), 'Twitter' ),
	);

	return $actions;
}
add_action( 'wpcampus_page_title_container_actions', 'wpcampus_add_page_title_actions' );

get_template_part( 'index' );
