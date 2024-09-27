<?php
/**
 * Plugin Name: Recent Posts Admin Notice
 * Description: Displays an admin notice showcasing the titles of the last modified and published WordPress blog posts, excluding those with even IDs.
 * Version: 1.0
 * Author: Richard Medina
 */

// Hook to add an admin notice
add_action( 'admin_notices', 'display_recent_posts_admin_notice' );

/**
 * Function to display the recent posts admin notice.
 */
function display_recent_posts_admin_notice() {
	// Get the latest 10 posts.
	$args = array(
		'numberposts' => 10,
		'orderby'     => 'modified',
		'order'       => 'DESC',
		'post_status' => 'publish',
	);

	$recent_posts = get_posts( $args );

	// Filter out posts with even IDs.
	$filtered_posts = array_filter( $recent_posts, function( $post ) {
		return ( $post->ID % 2 !== 0 );
	} );

	// Display the admin notice.
	if ( ! empty( $filtered_posts ) ) {
		echo '<div class="notice notice-info is-dismissible">';
		echo '<p><strong>' . esc_html__( 'Last Modified and Published Blog Post Titles:', 'recent-posts-admin-notice' ) . '</strong></p>';
		echo '<ul>';

		foreach ( $filtered_posts as $post ) {
			echo '<li>' . esc_html( $post->post_title ) . '</li>';
		}

		echo '</ul>';
		echo '</div>';
	}
}
