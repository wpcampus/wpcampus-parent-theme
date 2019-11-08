				</div><!-- #wpc-content-->
			</div><!-- .wpc-container -->
		</div><!-- #wpc-main -->
		<?php

		do_action( 'wpc_add_after_main' );

		?>
	</main><!-- #wpc-body -->
	<?php

	do_action( 'wpc_add_before_footer' );

	// Print network footer.
	if ( function_exists( 'wpcampus_print_network_footer' ) ) {
		wpcampus_print_network_footer();
	}

	?>
	</div><!-- #wpc-wrapper -->
	<?php wp_footer(); ?>
</body>
</html>
