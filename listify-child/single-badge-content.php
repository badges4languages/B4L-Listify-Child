<?php
/**
 * The template for displaying standard blog content.
 *
 * @package Listify
 */

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
		<!-- Description of the badge (Certification, Target, Fields of Education and Level). 
		Display the terms of taxonomies or post meta. -->
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

		<?php if ( is_singular() ) : ?>
			<div class="entry-content">
				<?php the_content(); ?>
			</div>
		<?php else : ?>
			<div class="entry-summary">
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
