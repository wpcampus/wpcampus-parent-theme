<?php

/**
 * Template Name: WPCampus: Speaker App Confirmation
 */

// If we came from the application, redirect out of the frame.

// Is the URL on the main site thats being iframed.
$app_url = 'https://' . DOMAIN_CURRENT_SITE . '/speaker-application/';

if ( ! empty( $_SERVER['HTTP_REFERER'] ) && $app_url == $_SERVER['HTTP_REFERER'] ) :

	// @TODO move URL to settings.
	if ( ! empty( $_GET['redirect'] ) ) {
		wpcampus_network()->html_redirect( 'https://2020.' . DOMAIN_CURRENT_SITE . '/call-for-speakers/confirmation/' );
	}

	wpcampus_network()->content_only();

endif;

get_template_part( 'index' );
