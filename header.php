<?php

/**
 * TODO:
 * - Clean up <head> and remove all of the unnecessary stuff.
 */

// Get the theme directory.
$theme_dir = trailingslashit( get_stylesheet_directory_uri() );

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php

	do_action( 'wpc_add_before_wrapper' );

	?>
	<div id="wpc-wrapper">
