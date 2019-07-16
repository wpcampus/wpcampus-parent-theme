<?php

/**
 * Filter the <body> class to add the page slug.
 */
function wpc_parent_filter_body_class( $class ) {
	global $post;

	// Make sure we have the fields we need.
	if ( empty( $post ) || empty( $post->post_type ) || empty( $post->post_name ) ) {
		return $class;
	}

	$new_class = "{$post->post_type}-{$post->post_name}";

	if ( ! in_array( $new_class, $class ) ) {
		$class[] = $new_class;
	}

	// Add the template.
	$wpc_template = get_query_var( 'wpc_template' );
	if ( in_array( $wpc_template, array( 'content-only' ) ) ) {
		$class[] = "wpc-{$wpc_template}";
	}

	return $class;
}
add_action( 'body_class', 'wpc_parent_filter_body_class' );

/**
 * Print the network banner before the wrapper.
 *
 * Need the separate function so we
 * can pass arguments to the function.
 */
function wpcampus_parent_print_network_banner() {
	if ( function_exists( 'wpcampus_print_network_banner' ) ) {
		wpcampus_print_network_banner( array(
			'skip_nav_id' => 'wpc-main',
		));
	}
}

/**
 * Print the main callout for the home page.
 */
function wpcampus_parent_print_main_callout() {}

/**
 * Print the 2017 callout.

function wpcampus_online_print_2017_callout() {

	?>
	<div class="panel gray" style="text-align:center;margin:20px 0 40px 0;padding-bottom:10px;">
		<h2>WPCampus 2017 Conference on July 14-15</h2>
		<p><a href="https://2017.wpcampus.org/" style="color:inherit;">WPCampus 2017</a> will take place July 14-15 on the campus of Canisius College in Buffalo, New York. <strong>Ticket sales have closed</strong> but, if you can't join us in person, all sessions will be live-streamed and made available online after the event. Gather with other WordPress users on your campus and create your own WPCampus experience!</p>
		<a class="button panel blue block" style="margin-bottom:0;font-weight:bold;font-size:110%;background:#770000;display:block;" href="https://2017.wpcampus.org/">Visit the WPCampus 2017 website</a>
	</div>
	<?php
}*/

/**
 * Print the education survey callout.

function wpcampus_online_print_ed_survey_callout() {

	?>
	<div class="panel gray" style="text-align:center;margin:20px 0 40px 0;padding-bottom:10px;">
		<h2>The "WordPress in Education" Survey</h2>
		<p>After an overwhelming response to our 2016 survey, WPCampus is back this year to dig a little deeper on key topics that schools and campuses care about most when it comes to WordPress and website development. We’d love to include your feedback in our results this year. The larger the data set, the more we all benefit. <strong>The survey will close on June 23rd, 2017.</strong></p>
		<a class="button panel blue block" style="margin-bottom:0;font-weight:bold;font-size:110%;background:#770000;display:block;" href="https://2017.wpcampus.org/announcements/wordpress-in-education-survey/">Take the "WordPress in Education" survey</a>
	</div>
	<?php
}*/

/**
 * Print the page title.
 *
 * By default, is added via "wpc_add_before_content" hook.
 */
function wpcampus_parent_print_page_title() {

	do_action( 'wpc_add_before_page_title' );

	if ( is_404() ) {
		$page_title = __( 'Page Not Found', 'wpcampus' );
	} elseif ( is_post_type_archive() ) {
		$page_title = post_type_archive_title( '', false );
	} else {
		$page_title = get_the_title();
	}

	$page_title = apply_filters( 'wpcampus_page_title', $page_title );

	$page_title_actions = apply_filters( 'wpcampus_page_title_container_actions', array(), $page_title );

	$container_class = array();

	if ( ! empty( $page_title_actions ) ) {
		$container_class[] = 'has-actions';
	}

	$container_class = apply_filters( 'wpcampus_page_title_container_class', $container_class, $page_title );

	// Make sure it has main container class.
	$container_class = array_merge( array( 'wpc-page-title-container' ), $container_class );

	?>
	<div<?php echo ! empty( $container_class ) ? ' class="' . implode( ' ', $container_class ) . '"' : ''; ?>>
		<h1 class="wpc-page-title"><?php echo $page_title; ?></h1>
		<?php

		if ( ! empty( $page_title_actions ) ) :
			?>
			<nav class="wpc-page-title-actions" aria-label="<?php _e( 'Page navigation', 'wpcampus' ); ?>">
				<ul>
					<?php

					foreach ( $page_title_actions as $action ) :

						// Make sure we have info we need.
						if ( empty( $action['href'] ) || empty( $action['label'] ) ) :
							continue;
						endif;

						?>
						<li>
							<a class="button" href="<?php echo $action['href']; ?>"><?php echo $action['label']; ?></a>
						</li>
						<?php
					endforeach;

					?>
				</ul>
			</nav>
			<?php
		endif;

		?>
	</div>
	<?php

	do_action( 'wpc_add_after_page_title' );

}

/**
 * Print the 404 page.
 */
function wpcampus_parent_print_404() {

	do_action( 'wpc_add_before_404' );

	?>
	<p><?php _e( 'Uh-oh. This page seems to be missing. Please check to make sure the link you requested was entered correctly.', 'wpcampus' ); ?></p>
	<p><?php printf( __( 'If you can\'t find what you\'re looking for in the menu, please %1$sreach out to us%2$s and let us know. We\'d be happy to help.', 'wpcampus' ), '<a href="/contact/">', '</a>' ); ?></p>
	<?php

	do_action( 'wpc_add_after_404' );

}

/**
 * Print breadcrumbs.
 */
function wpcampus_parent_print_breadcrumbs() {
	echo wpcampus_parent_get_breadcrumbs_html();
}

/**
 * Get breadcrumbs markup.
 */
function wpcampus_parent_get_breadcrumbs_html() {

	// Get the breadcrumbs.
	$breadcrumbs = wpcampus_parent_get_breadcrumbs();

	// Make sure we have crumbs.
	if ( empty( $breadcrumbs ) ) {
		return '';
	}

	// Build breadcrumbs HTML.
	$breadcrumbs_html = null;

	foreach ( $breadcrumbs as $crumb_key => $crumb ) {

		// Make sure we have what we need.
		if ( empty( $crumb['label'] ) ) {
			continue;
		}

		// If no string crumb key, set as ancestor.
		if ( ! $crumb_key || is_numeric( $crumb_key ) ) {
			$crumb_key = 'ancestor';
		}

		// Setup classes.
		$crumb_classes = array( $crumb_key );

		$breadcrumbs_html .= '<li' . ( ! empty( $crumb_classes ) ? ' class="' . implode( ' ', $crumb_classes ) . '"' : null ) . '>';

		// Set the label.
		$label = wp_trim_words( $crumb['label'], 10 );

		// Add URL and label.
		if ( 'current' != $crumb_key && ! empty( $crumb['url'] ) ) {
			$breadcrumbs_html .= '<a href="' . $crumb['url'] . '" title="' . $crumb['label'] . '">' . $label . '</a>';
		} elseif ( $crumb['label'] != $label ) {
			$breadcrumbs_html .= '<span aria-label="' . $crumb['label'] . '">' . $label . '</span>';
		} else {
			$breadcrumbs_html .= $label;
		}

		$breadcrumbs_html .= '</li>';

	}

	if ( empty( $breadcrumbs_html ) ) {
		return '';
	}

	// Wrap them in nav.
	return '<nav class="wpc-breadcrumbs" aria-label="breadcrumbs"><ul>' . $breadcrumbs_html . '</ul></nav>';
}

/**
 * Get breadcrumbs.
 */
function wpcampus_parent_get_breadcrumbs() {

	/*
	 * Build array of breadcrumbs.
	 *
	 * Start with home.
	 */
	$breadcrumbs = array(
		'home' => array(
			'url'   => '/',
			'label' => __( 'Home', 'wpcampus' ),
		),
	);

	// Get post type.
	$post_type = get_query_var( 'post_type' );

	// Make sure its not an array.
	if ( is_array( $post_type ) ) {
		$post_type = reset( $post_type );
	}

	// Add archive(s).
	if ( is_archive() ) {

		// Add the archive breadcrumb.
		if ( is_post_type_archive() ) {

			// Get the info.
			$post_type_archive_link  = wpcampus_parent_get_post_type_archive_link( $post_type );
			$post_type_archive_title = wpcampus_parent_get_post_type_archive_title( $post_type );

			// Add the breadcrumb.
			if ( $post_type_archive_link && $post_type_archive_title ) {
				$breadcrumbs[] = array(
					'url'   => $post_type_archive_link,
					'label' => $post_type_archive_title,
				);
			}
		} elseif ( is_author() ) {

			// Add crumb to contributors page.
			$breadcrumbs[] = array(
				'url'   => '/contributors/',
				'label' => __( 'Contributors', 'wpcampus' ),
			);

			// Add crumb to current contributor's page.
			$author = get_queried_object();
			if ( ! empty( $author->ID ) ) {
				$breadcrumbs['current'] = array(
					'url'   => get_author_posts_url( $author->ID ),
					'label' => get_the_author_meta( 'display_name', $author->ID ),
				);
			}
		} else {

			$breadcrumbs[] = array(
				'url'   => '/blog/',
				'label' => __( 'Blog', 'wpcampus' ),
			);
		}
	} else {

		/*
		 * Add links to main blog
		 * or to post type archive.
		 */
		if ( is_singular( 'post' ) ) {
			$breadcrumbs[] = array(
				'url'   => '/blog/',
				'label' => __( 'Blog', 'wpcampus' ),
			);
		} elseif ( is_singular() ) {

			// Get the information.
			$post_type_archive_link  = wpcampus_parent_get_post_type_archive_link( $post_type );
			$post_type_archive_title = wpcampus_parent_get_post_type_archive_title( $post_type );

			if ( $post_type_archive_link ) {
				$breadcrumbs[] = array(
					'url'   => $post_type_archive_link,
					'label' => $post_type_archive_title,
				);
			}
		}

		// Print info for the current post.
		$post = get_queried_object();
		if ( ! empty( $post ) && is_a( $post, 'WP_Post' ) ) {

			// Get ancestors.
			$post_ancestors = isset( $post ) ? get_post_ancestors( $post->ID ) : array();

			// Add the ancestors.
			foreach ( $post_ancestors as $post_ancestor_id ) {

				// Add ancestor.
				$breadcrumbs[] = array(
					'ID'    => $post_ancestor_id,
					'url'   => get_permalink( $post_ancestor_id ),
					'label' => get_the_title( $post_ancestor_id ),
				);
			}

			// Add current page - if not home page.
			if ( isset( $post ) ) {
				$breadcrumbs['current'] = array(
					'ID'    => $post->ID,
					'url'   => get_permalink( $post ),
					'label' => get_the_title( $post->ID ),
				);
			}
		}
	}

	return apply_filters( 'wpcampus_breadcrumbs', $breadcrumbs );
}

/**
 * Get the post type archive link.
 */
function wpcampus_parent_get_post_type_archive_link( $post_type ) {

	// Make sure we have a post type.
	if ( empty( $post_type ) ) {

		$post_type = get_query_var( 'post_type' );

		if ( empty( $post_type ) ) {
			return '';
		}
	}

	// Make sure its not an array.
	if ( is_array( $post_type ) ) {
		$post_type = reset( $post_type );
	}

	return apply_filters( 'wpcampus_post_type_archive_link', get_post_type_archive_link( $post_type ), $post_type );
}

/**
 * Get the post type archive title.
 */
function wpcampus_parent_get_post_type_archive_title( $post_type = '' ) {

	// Make sure we have a post type.
	if ( empty( $post_type ) ) {

		$post_type = get_query_var( 'post_type' );

		if ( empty( $post_type ) ) {
			return '';
		}
	}

	// Make sure its not an array.
	if ( is_array( $post_type ) ) {
		$post_type = reset( $post_type );
	}

	// Get the post type data.
	$post_type_obj = get_post_type_object( $post_type );

	if ( empty( $post_type_obj->labels->name ) ) {
		return '';
	}

	$title = apply_filters( 'post_type_archive_title', $post_type_obj->labels->name, $post_type );

	return apply_filters( 'wpcampus_post_type_archive_title', $title, $post_type );
}

/**
 * Filters the HTML attributes applied to a menu item's anchor element.
 *
 * Checks if the menu item is the current menu
 * item and adds the aria "current" attribute.
 *
 * @param array   $atts   The HTML attributes applied to the menu item's `<a>` element.
 * @param WP_Post $item  The current menu item.
 * @return array Modified HTML attributes
 */
function wpcampus_parent_add_nav_menu_aria_current( $atts, $item ) {

	/*
	 * If it's not a nav menu item, we need
	 * to check if the item is current post.
	 *
	 * Used for page menus.
	 */
	if ( ! empty( $item->ID ) && ! empty( $item->post_type ) && 'nav_menu_item' != $item->post_type ) {
		global $post;
		if ( ! empty( $post->ID ) && $post->ID == $item->ID ) {
			$atts['aria-current'] = 'page';
		}
		return $atts;
	}

	// Means this is a regular nav menu item.
	if ( ! empty( $item->current ) ) {
		$atts['aria-current'] = 'page';
	}

	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'wpcampus_parent_add_nav_menu_aria_current', 10, 2 );
add_filter( 'page_menu_link_attributes', 'wpcampus_parent_add_nav_menu_aria_current', 10, 2 );
