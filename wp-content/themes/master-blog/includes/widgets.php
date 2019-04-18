<?php
/**
 * Custom widgets.
 *
 * @package master_blog
 */

if ( ! function_exists( 'master_blog_load_widgets' ) ) :

	/**
	 * Load widgets.
	 *
	 * @since 1.0.0
	 */
	function master_blog_load_widgets() {

		// Extended Recent Post.
		register_widget( 'master_blog_Extended_Recent_Posts' );

		// Popular Post.
		register_widget( 'master_blog_Popular_Posts' );

	}

endif;

add_action( 'widgets_init', 'master_blog_load_widgets' );

/**
 * Recent Posts Widget
 */
require get_template_directory() . '/includes/widgets/recent-posts.php';

/**
 * Popular Posts Widget
 */
require get_template_directory() . '/includes/widgets/popular-posts.php';
