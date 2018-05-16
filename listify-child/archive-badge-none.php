<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Listify
 */
?>

<article id="post-0" class="hentry content-box content-box-wrapper no-results not-found">
	<div class="content-box-inner">
		<!-- Propose to create a new badge if no result -->
		<?php /*if ( current_user_can( 'publish_posts' ) ) : ?>	
			<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'listify' ), esc_url( admin_url( 'post-new.php' ) ) );*/ ?><!-- </p> -->

			<p><?php _e( 'Sorry, it seems like no badge match with your search.', 'listify' ); ?></p>

	</div>
</article><!-- #post-## -->
