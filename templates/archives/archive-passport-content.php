<?php
/**
 * The template for displaying the information of each passports of the user.
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
			<h2 class="entry-title entry-title--in-cover">
				<a href="<?php the_permalink(); ?>" rel="bookmark">
					<?php 
					$language = get_term_by('id', get_post_meta( $post->ID,'_passport_language',true ), 'field_of_education');
					the_title();
					echo '<br>' . 'Language : ' . $language->name;
					?>
				</a>
			</h2>
		</div>
	</header><!-- .entry-header -->
	<?php endif; ?>

	<div class="content-box-inner">

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
	</div>
</article><!-- #post-## -->
