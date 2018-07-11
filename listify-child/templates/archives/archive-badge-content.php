<?php
/**
 * The template for displaying the information of each badges in the archive page.
 *
 * @package Listify
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( ! is_singular() ) : ?>
	<?php

	// Badge without featured image
	 	if ( ! has_post_thumbnail() ): ?>

		<!-- Add classes and default badge image url -->
			<header style="background-image: url( <?php echo get_stylesheet_directory_uri() . '/images/default-badge.png'; ?>);" class="entry-header entry-cover has-image">
				<div class="cover-wrapper">
					<h2 class="entry-title entry-title--in-cover"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
				</div>
			</header><!-- .entry-header -->

		<?php //Badge with normal featured image (original code)
		else: ?>

			<header <?php echo apply_filters( 'listify_cover', 'entry-header entry-cover' ); ?>>
				<div class="cover-wrapper">
					<h2 class="entry-title entry-title--in-cover"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
				</div>
			</header><!-- .entry-header -->

		<?php endif; ?>

	<?php endif; ?>
	
	<div class="content-box-inner">

		<?php if ( is_singular() ) : ?>
			<div class="entry-content">
				<?php the_content(); ?>
			</div>
		<?php else : ?>
			<div class="entry-summary">
				<!-- Description of the badge (Certification, Target, Fields of Education and Level). -->
				<div class="badge-description-archive">
					<?php  if( get_post_meta($post->ID, '_certification', true) == 'certified' ): ?>
						<div class="badge-description-content"> <b>Certification Type: </b>Certified </div>
					<?php else: ?>
						<div class="badge-description-content"> <b>Certification Type: </b>Not Certified </div>
					<?php endif; ?>

					<?php if( get_post_meta($post->ID, '_target', true) == 'teacher' ): ?>
						<div class="badge-description-content"> <b>Target: </b>Teacher </div>
					<?php else: ?>
						<div class="badge-description-content"> <b>Target: </b>Student </div>
					<?php endif; ?>
					
					<div class="badge-description-content"> 
						<?php if( strpos( get_CPT_terms($post->ID, 'field_of_education' ), ',' ) !== false ){ ?>
							<b>Fields of Education: </b><?php echo get_CPT_terms($post->ID, 'field_of_education' ); ?>
						<?php } else { ?>
							<b>Field of Education: </b><?php echo get_CPT_terms($post->ID, 'field_of_education' ); ?>
						<?php } ?>
					</div>
					<div class="badge-description-content"> 
						<?php if( strpos( get_CPT_terms($post->ID, 'level' ), ',' ) !== false ){ ?>
							<b>Levels: </b><?php echo get_CPT_terms($post->ID, 'level' ); ?> 
						<?php } else { ?>
							<b>Level: </b><?php echo get_CPT_terms($post->ID, 'level' ); ?> 
						<?php } ?>
					</div>
				</div>
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->
		<?php endif; ?>

		<?php wp_link_pages(); ?>

		<?php if ( ! is_singular() ) : ?>
			<footer class="entry-footer">
				<a href="<?php the_permalink(); ?>" class="button button-small"><?php _e( 'Read More', 'listify' ); ?></a>
			</footer><!-- .entry-footer -->
		<?php endif; ?>
	</div>
</article><!-- #post-## -->
