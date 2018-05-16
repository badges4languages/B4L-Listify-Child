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
		<?php if ( ! is_singular( 'page' ) ) : ?>
		<div class="entry-meta">
			<span class="entry-author author vcard">
				<?php echo get_avatar( get_the_author_meta( 'ID' ), 50 ); ?>
				<a class="url fn n" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php the_author(); ?></a>
			</span>

			<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
			<span class="entry-comments">
				<?php comments_popup_link( __( '0 Comments', 'listify' ), __( '1 Comment', 'listify' ), __( '% Comments', 'listify' ) ); ?>
			</span>
			<?php endif; ?>

			<span class="entry-share">
				<?php do_action( 'listify_share_object' ); ?>
			</span>
		</div>
		<?php endif; ?>

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
