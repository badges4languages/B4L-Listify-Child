<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Listify
 */

get_header(); ?>

	<?php // Badge without featured image
	if ( ! has_post_thumbnail() ): ?>
		<!-- Add classes and default badge image url -->
		<div style="background-image: url( <?php echo get_stylesheet_directory_uri() . '/images/default-badge.png'; ?>);" class="page-cover page-cover--large has-image badge-image">
	<?php //Badge with normal featured image (original code)
	else: ?>
		<div 
			<?php
			echo apply_filters(
				'listify_cover', 'page-cover page-cover--large badge-image', array( // WPCS: XSS ok.
					'size' => 'full',
				)
			);
			?>
		>
	<?php endif; ?>
	
		<h1 class="page-title cover-wrapper">
		<?php
		the_post();
		the_title();
		rewind_posts();
?>
</h1>
	</div>

	<div id="primary" class="container">
		<div class="row content-area">

			<?php if ( 'left' === esc_attr( listify_theme_mod( 'content-sidebar-position', 'right' ) ) ) : ?>
				<?php get_sidebar(); ?>
			<?php endif; ?>

			<main id="main" class="site-main col-xs-12 
				<?php
				if ( 'none' !== esc_attr( listify_theme_mod( 'content-sidebar-position', 'right' ) ) && is_active_sidebar( 'widget-area-sidebar-1' ) ) :
				?>
				col-sm-7 col-md-8<?php endif; ?>" role="main">

				<?php
				while ( have_posts() ) :
					the_post();
				?>

					<?php 
						if (get_post_type() == 'open-badge' ) :
							get_template_part( 'single-badge-content' );
						else :
							get_template_part( 'content' );
						endif;
					?>

					<?php comments_template(); ?>

				<?php endwhile; ?>

			</main>
		</div>
		
		<div style="text-align: center; padding-bottom: 10px;">
			<?php echo "<a href=\"javascript:history.go(-1)\" class=\"button button-small\">Return</a>"; ?>
		</div>
	</div>

<?php get_footer(); ?>
