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
	
		<h1 class="page-title cover-wrapper" style="color: white;">
		<?php
		the_post();
		the_title();
		rewind_posts();
?>
</h1>
	</div>

	<div id="primary" class="container single-badge-content">
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
					
					if ( listify_has_integration( 'woocommerce' ) ) :
						wc_print_notices();
					endif;
					?>

					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

						<?php if ( ! is_singular() ) : ?>

						<header <?php echo apply_filters( 'listify_cover', 'entry-header entry-cover' ); ?>>
							<div class="cover-wrapper">
								<h2 class="entry-title entry-title--in-cover"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
							</div>
						</header><!-- .entry-header -->

						<?php endif; ?>

						<div class="content-box-inner">
							<!-- Description of the badge (Certification, Target, Fields of Education and Level). -->
							<div class="badge-description">
								<?php 
									if( get_post_meta($post->ID, '_certification', true) == 'certified' ):
										echo "<b>Certification Type: </b>Certified<br>";
									else:
										echo "<b>Certification Type: </b>Not Certified<br>";
									endif;

									if( get_post_meta($post->ID, '_target', true) == 'teacher' ):
										echo "<b>Target: </b>Teacher<br>";
									else:
										echo "<b>Target: </b>Student<br>";
									endif;
									
									echo "<b>Field(s) of Education: </b>" . get_CPT_terms($post->ID, 'field_of_education' ) . "<br>";
									echo "<b>Level(s): </b>" . get_CPT_terms($post->ID, 'level' ) . "<br>";
								?>
							</div>

							<!-- Badge's description -->
							<?php if ( is_singular() ) : ?>
								<div class="entry-content">
									<?php the_content(); ?>
								</div>
							<?php endif; ?>

							<?php wp_link_pages(); ?>

						</div>
					</article><!-- #post-## -->

				<?php endwhile; ?>

			</main>
		</div>
		
		<div style="text-align: center; padding-bottom: 10px;">
			<?php echo "<a href=\"javascript:history.go(-1)\" class=\"button button-small\">Return</a>"; ?>
		</div>
	</div>

<?php get_footer(); ?>
