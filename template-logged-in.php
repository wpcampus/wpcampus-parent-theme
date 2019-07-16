<?php

/**
 * Template Name: WPCampus: Logged In
 */

add_filter( 'the_content', function( $content ) {

	$is_user_logged_in = is_user_logged_in();

	if ( $is_user_logged_in ) {

		/*// Add logout link.
		$logout_url = wp_logout_url( get_permalink() );
		?>
		<p><a href="<?php echo $logout_url; ?>"><?php _e( 'Logout', 'wpcampus' ); ?></a></p>
		<?php*/

		return $content;
	}

	$content = '<div class="panel light-royal-blue center">'
		. __( 'You must be logged in to view this content.', 'wpcampus' )
		. '</div>';

	// Force login.
	$content .= wp_login_form( array(
		'echo'           => false,
		'remember'       => true,
		'form_id'        => 'login-form',
		'id_username'    => 'user-login',
		'id_password'    => 'user-pass',
		'id_remember'    => 'remember-me',
		'id_submit'      => 'wp-submit',
		'label_username' => __( 'Username', 'wpcampus' ),
		'label_password' => __( 'Password', 'wpcampus' ),
		'label_remember' => __( 'Remember Me', 'wpcampus' ),
		'label_log_in'   => __( 'Login', 'wpcampus' ),
		'value_username' => '',
		'value_remember' => false,
	));

	return $content;
});

get_template_part( 'index' );
