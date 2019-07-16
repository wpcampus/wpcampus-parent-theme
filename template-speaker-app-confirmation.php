<?php

/**
 * Template Name: WPCampus: Speaker App Confirmation
 */

// If we came from the application, redirect out of the frame.
if ( ! empty( $_SERVER['HTTP_REFERER'] ) && 'https://' . DOMAIN_CURRENT_SITE . '/speaker-application/' == $_SERVER['HTTP_REFERER'] ) :

	if ( ! empty( $_GET['redirect'] ) ) {
		wpcampus_network()->html_redirect( 'https://2019.' . DOMAIN_CURRENT_SITE . '/call-for-speakers/confirmation/' );
	}

	wpcampus_network()->content_only();

endif;

get_template_part( 'index' );
