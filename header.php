<?php

/**
 * TODO:
 * - Clean up <head> and remove all of the unnecessary stuff.
 */

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
		<?php

		if ( has_action( 'wpc_add_to_header' ) ) :

			do_action( 'wpc_add_before_header' );

			?>
			<header id="wpc-header">
				<?php

				do_action( 'wpc_add_to_header' );

				?>
			</header>
			<?php

			do_action( 'wpc_add_after_header' );

		endif;

		do_action( 'wpc_add_before_body' );

		?>
		<div id="wpc-body" role="main">
			<?php

			do_action( 'wpc_add_before_main' );

			?>
			<div id="wpc-main">
				<div class="wpc-container">
					<div id="wpc-content" <?php post_class(); ?>>
